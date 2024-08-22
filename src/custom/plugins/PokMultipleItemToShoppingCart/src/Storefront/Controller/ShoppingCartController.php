<?php declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Storefront\Controller;

use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Checkout\Customer\CustomerEntity;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use PokMultipleItemToShoppingCart\Storefront\Service\FastOrderService;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class ShoppingCartController extends StorefrontController
{
    private $fastOrderService;
    private EntityRepository $orderLogRepository;
    private EntityRepository $productRepository;

    public function __construct(FastOrderService $fastOrderService, EntityRepository $orderLogRepository, EntityRepository $productRepository)
    {
	$this->orderLogRepository = $orderLogRepository;
	$this->fastOrderService = $fastOrderService;
	$this->productRepository = $productRepository;
    }

    #[Route(
        path: '/fast-items/add',
        name: 'frontend.fast_items.page',
        methods: ['GET']
    )]
    public function showForm(Request $request, SalesChannelContext $context): Response
    {
        return $this->renderStorefront('@PokMultipleItemToShoppingCart/storefront/page/fast-items.html.twig', [
            'example' => 'Hello world'
        ]);
    }
    #[Route(
        path: '/items-to-shopping-cart/add',
        name: 'frontend.add_items_to_shopping_cart',
        methods: ['POST']
    )]
    public function addToCart(Request $request, SalesChannelContext $context): RedirectResponse
    {
	$customer = $context->getCustomer();
        if (!$customer instanceof CustomerEntity) {
            return $this->redirectToRoute('frontend.account.login.page');  // Redirect to login if not logged in
        }

        // Proceed with adding to cart
	$this->fastOrderService->addToCart($request, $context);

	// Redirect to cart page after successful addition
        return $this->redirectToRoute('frontend.checkout.cart.page');
    }

    #[Route(
        path: '/items-to-shopping-cart/upload',
        name: 'frontend.add_items_to_shopping_cart.upload_csv',
        methods: ['POST']
    )]
    public function uploadCSV(Request $request, SalesChannelContext $context)
    {
        $this->fastOrderService->processCSVUpload($request, $context);

        return $this->redirectToRoute('frontend.checkout.cart.page');
    }

    private function logOrder(string $sessionId, array $products): void
    {
        $this->orderLogRepository->create([
            [
                'id' => Uuid::randomHex(),
                'sessionId' => $sessionId,
                'createdAt' => (new \DateTime())->format('Y-m-d H:i:s'),
                'products' => json_encode($products),
            ]
        ], Context::createDefaultContext());
    }

    #[Route(
        path: '/fast-items/search-product',
        name: 'frontend.fast_items.search_product',
        methods: ['GET']
    )]
    public function searchProduct(Request $request, SalesChannelContext $context): JsonResponse
    {
        $query = $request->query->get('term');
        $criteria = new Criteria();
        $criteria->addFilter(new ContainsFilter('productNumber', $query));
        $criteria->setLimit(10);

	$products = $this->productRepository->search($criteria, $context->getContext());

        $results = [];

        foreach ($products as $product) {
            $results[] = [
                'id' => $product->getId(),
                'label' => $product->getName(),
                'productNumber' => $product->getProductNumber()
            ];
        }

        return new JsonResponse($results);
    }    
}
