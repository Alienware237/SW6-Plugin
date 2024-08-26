<?php

// custom/plugins/SwagFastOrder/src/Repository/CustomerSelectionRepository.php

namespace PokMultipleItemToShoppingCart\Repository;

use Shopware\Core\Framework\DataAbstractionLayer\DefinitionInstanceRegistry;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepository;
use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use PokMultipleItemToShoppingCart\Core\Content\CustomerSelection\CustomerSelectionDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\VersionManager;
use Shopware\Core\Framework\DataAbstractionLayer\Read\EntityReaderInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntitySearcherInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\EntityAggregatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Event\EntityLoadedEventFactory;

class CustomerSelectionRepository extends EntityRepository
{
    private $repository;

    public function __construct(
        CustomerSelectionDefinition $definition,
        EntityReaderInterface $entityReader,
        VersionManager $versionManager,
        EntitySearcherInterface $entitySearcher,
        EntityAggregatorInterface $entityAggregator,
        EventDispatcherInterface $eventDispatcher,
        EntityLoadedEventFactory $eventFactory
    ) {
        parent::__construct(
            $definition,
            $entityReader,
            $versionManager,
            $entitySearcher,
            $entityAggregator,
            $eventDispatcher,
            $eventFactory
        );
    }

    public function createCustomerSelection(array $data, Context $context): void
    {
        $this->create($data, $context);
    }

    public function getSelectionsByCustomerId(string $customerId, Context $context)
    {
        $criteria = new Criteria();
        $criteria->addFilter(['customerId' => $customerId]);

        return $this->search($criteria, $context);
    }
}
