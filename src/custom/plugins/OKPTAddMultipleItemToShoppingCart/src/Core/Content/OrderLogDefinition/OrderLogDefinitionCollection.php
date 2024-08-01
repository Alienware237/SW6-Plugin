<?php declare(strict_types=1);

namespace OKPT\AddMultipleItemToShoppingCart\Core\Content\OrderLogDefinition;

use Shopware\Core\Framework\DataAbstractionLayer\EntityCollection;

/**
 * @method void add(OrderLogDefinitionEntity $entity)
 * @method void set(string $key, OrderLogDefinitionEntity $entity)
 * @method OrderLogDefinitionEntity[] getIterator()
 * @method OrderLogDefinitionEntity[] getElements()
 * @method OrderLogDefinitionEntity|null get(string $key)
 * @method OrderLogDefinitionEntity|null first()
 * @method OrderLogDefinitionEntity|null last()
 */
class OrderLogDefinitionCollection extends EntityCollection
{
    protected function getExpectedClass(): string
    {
        return OrderLogDefinitionEntity::class;
    }
}
