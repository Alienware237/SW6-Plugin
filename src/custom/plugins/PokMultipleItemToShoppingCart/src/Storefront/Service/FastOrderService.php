<?php

namespace PokMultipleItemToShoppingCart\Storefront\Service;

use Shopware\Core\Checkout\Cart\SalesChannel\CartService;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\EqualsFilter;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Shopware\Core\Framework\Uuid\Uuid;
use DateTimeImmutable;
use Shopware\Core\Checkout\Customer\CustomerEntity;

class FastOrderService
{
    private CartService $cartService;
    private EntityRepository $productRepository;
    private EntityRepository $customerSelectionRepository;

    public function __construct(
        CartService $cartService,
        EntityRepository $productRepository,
        EntityRepository $customerSelectionRepository
    ) {
        $this->cartService = $cartService;
        $this->productRepository = $productRepository;
        $this->customerSelectionRepository = $customerSelectionRepository;
    }

    public function addToCart(Request $request, SalesChannelContext $context): void
    {
        $customer = $context->getCustomer();
	$submittedArticles = $request->get('products', []);

	echo "submittedArticles: ";
        print_r($submittedArticles);

	$dateTimeNow = new DateTimeImmutable();

        if (!$customer instanceof CustomerEntity) {
            throw new \RuntimeException("Customer not logged in.");
        }

        foreach ($submittedArticles as $article) {
		$productNumber = $article['id'] ?? null;
		$productId = $article['productId'] ?? null;
                $quantity = $article['quantity'] ?? null;

	    if ($productId && $quantity) {
                // Store customer selection in the custom entity
                $this->customerSelectionRepository->create([
                    [
                        'id' => Uuid::randomHex(),
                        'customerId' => $customer->getId(),
                        'productId' => $productId,
                        'quantity' => (int)$quantity,
                        'createdAt' => $dateTimeNow,
                    ]
                ], $context->getContext());

                // Process and add the product to the cart
                $this->processProduct($productId, (int)$quantity, $context);
            }
        }
    }

    // Handling the CSV upload and processing
    public function processCSVUpload(Request $request, SalesChannelContext $context): void
    {
        $customer = $context->getCustomer();

        if (!$customer instanceof CustomerEntity) {
            throw new \RuntimeException("Customer not logged in.");
        }

	$file = $request->files->get('csvFile');
	 $fieldToProcess = $request->get('fieldToProcess');

        if (!$file || !$file->isValid()) {
            throw new FileException('Invalid CSV file upload.');
        }

        // Read CSV file with ; as delimiter
        $csvData = array_map(function($line) {
            return str_getcsv($line, ';');
	}, file($file->getPathname(), FILE_SKIP_EMPTY_LINES));

        foreach ($csvData as $index => $row) {
            if ($index === 0) {
                continue; // Skip header row
	    }

	    // Check if both columns (productNumber and quantity) are available
            if (!isset($row[0]) || !isset($row[1])) {
                continue; // Skip rows that do not have both product number and quantity
            }

            $productNumber = trim($row[0]);
            $quantity = (int)$row[1];

            // Fetch the product ID using the product number
            $criteria = new Criteria();
            $criteria->addFilter(new EqualsFilter('productNumber', $productNumber));
            $productEntity = $this->productRepository->search($criteria, $context->getContext())->first();

            if ($productEntity) {
                $productId = $productEntity->getId();

                // Process and add the product to the cart
                $this->processProduct($productId, $quantity, $context);

                // Store customer selection
                $this->customerSelectionRepository->create([
                    [
                        'id' => Uuid::randomHex(),
                        'customerId' => $customer->getId(),
                        'productId' => trim($productId),
                        'quantity' => (int)$quantity,
                        'createdAt' => new DateTimeImmutable(),
                    ]
                ], $context->getContext());
            }
        }
    }

    private function processProduct(string $productId, int $quantity, SalesChannelContext $context): void
    {
        // Create Line Item and add to the cart
        $lineItem = (new LineItem(Uuid::randomHex(), LineItem::PRODUCT_LINE_ITEM_TYPE, $productId, $quantity))
            ->setStackable(true);

        // Add the line item to the cart
        $cart = $this->cartService->getCart($context->getToken(), $context);
        $this->cartService->add($cart, $lineItem, $context);
    }
}

