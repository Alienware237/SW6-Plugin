<?php declare(strict_types=1);

// src/Controller/Admin/FastOperationsLogController.php

namespace PokMultipleItemToShoppingCart\Storefront\Controller\Admin;

use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Filter\ContainsFilter;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Shopware\Storefront\Controller\StorefrontController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['storefront']])]
class FastOperationsLogController extends StorefrontController
{

    private EntityRepository $customerSelectionRepository;
    public function __construct(EntityRepository $customerSelectionRepository)
    {
        $this->customerSelectionRepository = $customerSelectionRepository;
    }

    #[Route(
        path: '/fast-Operations',
        name: 'api.fast-operations.logs',
        methods: ['GET', 'POST']
    )]
    public function getLogs(Request $request, SalesChannelContext $context): JsonResponse
    {
        // Create a new Criteria object to fetch all data without any filters
        $criteria = new Criteria();

        // Use the repository to fetch all records from the customer_selection table
        $customerSelection = $this->customerSelectionRepository->search($criteria, $context->getContext());

        // Convert the results into a data array
        $data = $customerSelection->getEntities()->getElements();

        // Return the data as a JSON response
        return new JsonResponse(['data' => $data]);
    }
}
