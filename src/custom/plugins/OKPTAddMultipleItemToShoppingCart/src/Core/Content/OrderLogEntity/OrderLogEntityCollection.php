<?php declare(strict_types=1);

namespace OKPT\AddMultipleItemToShoppingCart\Core\Content\OrderLogEntity;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(OrderLogEntityEntity $entity)
 * @method void set(string $key, OrderLogEntityEntity $entity)
 * @method OrderLogEntityEntity[] getIterator()
 * @method OrderLogEntityEntity[] getElements()
 * @method OrderLogEntityEntity|null get(string $key)
 * @method OrderLogEntityEntity|null first()
 * @method OrderLogEntityEntity|null last()
 */
class OrderLogEntityCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return OrderLogEntityEntity::class;
    }
}
