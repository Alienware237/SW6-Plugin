<?php declare(strict_types=1);

namespace OKPT\AddMultipleItemToShoppingCart\Core\Content\OrderLogCollection;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(OrderLogCollectionEntity $entity)
 * @method void set(string $key, OrderLogCollectionEntity $entity)
 * @method OrderLogCollectionEntity[] getIterator()
 * @method OrderLogCollectionEntity[] getElements()
 * @method OrderLogCollectionEntity|null get(string $key)
 * @method OrderLogCollectionEntity|null first()
 * @method OrderLogCollectionEntity|null last()
 */
class OrderLogCollectionCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return OrderLogCollectionEntity::class;
    }
}
