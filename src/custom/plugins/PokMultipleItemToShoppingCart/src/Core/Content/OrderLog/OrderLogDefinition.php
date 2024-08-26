<?php

declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Core\Content\OrderLog;

use Shopware\Core\Framework\DataAbstractionLayer\EntityDefinition;
use Shopware\Core\Framework\DataAbstractionLayer\Field\DateTimeField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\LongTextField;
use Shopware\Core\Framework\DataAbstractionLayer\FieldCollection;
use Shopware\Core\Framework\DataAbstractionLayer\Field\BoolField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\PrimaryKey;
use Shopware\Core\Framework\DataAbstractionLayer\Field\Flag\Required;
use Shopware\Core\Framework\DataAbstractionLayer\Field\IdField;
use Shopware\Core\Framework\DataAbstractionLayer\Field\StringField;

class OrderLogDefinition extends EntityDefinition
{
    public const ENTITY_NAME = 'order_log';

    public function getEntityName(): string
    {
        return self::ENTITY_NAME;
    }

    public function getEntityClass(): string
    {
        return OrderLogEntity::class;
    }

    public function getCollectionClass(): string
    {
        return OrderLogCollection::class;
    }

    protected function defineFields(): FieldCollection
    {
        return new FieldCollection([
            (new IdField('id', 'id'))->addFlags(new Required(), new PrimaryKey()),
            (new StringField('name', 'name')),
            (new StringField('description', 'description')),
        (new BoolField('active', 'active')),
        (new StringField('session_id', 'sessionId'))->addFlags(new Required()),
        (new DateTimeField('created_at', 'createdAt'))->addFlags(new Required()),
        (new DateTimeField('updated_at', 'updatedAt'))->addFlags(new Required()),
            (new LongTextField('products', 'products'))->addFlags(new Required()),
        ]);
    }
}
