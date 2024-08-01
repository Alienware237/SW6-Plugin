<?php declare(strict_types=1);

namespace OKPT\AddMultipleItemToShoppingCart\Core\Content\OrderLog;

use OKPT\AddMultipleItemToShoppingCart\Core\Content\OrderLog\OrderLogEntity;
use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(OrderLogEntity $entity)
 * @method void set(string $key, OrderLogEntity $entity)
 * @method OrderLogEntity[] getIterator()
 * @method OrderLogEntity[] getElements()
 * @method OrderLogEntity|null get(string $key)
 * @method OrderLogEntity|null first()
 * @method OrderLogEntity|null last()
 */
class OrderLogCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return OrderLogEntity::class;
    }
}

