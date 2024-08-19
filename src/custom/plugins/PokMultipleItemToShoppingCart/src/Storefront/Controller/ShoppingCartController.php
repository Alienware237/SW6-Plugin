<?php declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Storefront\Controller;

use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\Uuid\Uuid;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class ShoppingCartController extends StorefrontController
{
    private CartService $cartService;
    private EntityRepository $orderLogRepository;

    public function __construct(CartService $cartService, EntityRepository $orderLogRepository)
    {
        $this->cartService = $cartService;
        $this->orderLogRepository = $orderLogRepository;
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
        $items = $request->request->get('items', []);

        foreach ($items as $item) {
            $productNumber = $item['productNumber'];
            $quantity = (int)$item['quantity'];

            // Add the product to the cart using Shopware's cart service
            $this->cartService->add($context->getToken(), new LineItem($productNumber, LineItem::PRODUCT_LINE_ITEM_TYPE, $productNumber, $quantity), $context);
        }


        $this->logOrder($context->getToken(), $items);

        return new RedirectResponse($this->generateUrl('frontend.checkout.cart.page'));
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
}
