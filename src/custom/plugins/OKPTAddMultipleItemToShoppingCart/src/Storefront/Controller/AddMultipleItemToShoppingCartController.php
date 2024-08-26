<?php declare(strict_types=1);

namespace OKPT\AddMultipleItemToShoppingCart\Storefront\Controller;

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
class AddMultipleItemToShoppingCartController extends StorefrontController
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
        return $this->renderStorefront('@OKPTAddMultipleItemToShoppingCart//Resources/views/storefront/page/fast-items.html.twig', [
            'example' => 'Hello world'
        ]);
    }

    #[Route(
        path: '/items-to-shopping-cart/add',
        name: 'frontend.items_to_shopping_cart.page',
        methods: ['GET']
    )]
    public function addToCart(Request $request, SalesChannelContext $context): RedirectResponse
    {
        $productNumbers = $request->request->get('productNumbers', []);
        $quantities = $request->request->get('quantities', []);

        $products = [];
        foreach ($productNumbers as $key => $productNumber) {
            $quantity = (int)($quantities[$key] ?? 1);
            $this->cartService->add($context->getToken(), $productNumber, $quantity, $context);
            $products[] = ['productNumber' => $productNumber, 'quantity' => $quantity];
        }

        $this->logOrder($context->getToken(), $products);

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

