<?php declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Core\Content\CustomerSelection;

use PokMultipleItemToShoppingCart\Entity\CustomerSelectionEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @extends EntityCollection<CustomerSelectionEntity>
 */
class CustomerSelectionCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return CustomerSelectionEntity::class;
    }
}

