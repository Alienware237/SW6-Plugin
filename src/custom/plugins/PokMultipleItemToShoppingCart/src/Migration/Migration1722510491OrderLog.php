<?php

declare(strict_types=1);

namespace PokMultipleItemToShoppingCart\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Log\Package;
use Shopware\Core\Framework\Migration\MigrationStep;

/**
 * @internal
 */
#[Package('core')]
class Migration1722510491OrderLog extends MigrationStep
{
    public function getCreationTimestamp(): int
    {
        return 1722510491;
    }

    public function update(Connection $connection): void
    {

        // Create the Product table with a foreign key to Admin
        $connection->executeStatement("
             CREATE TABLE `customer_selection` (
                `id` BINARY(16) NOT NULL,
                `customer_id` BINARY(16) NOT NULL,
                `product_id` BINARY(16) NOT NULL,
                `quantity` INT NOT NULL,
		`created_at` DATETIME(3) NOT NULL,
		`updated_at` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3),
                PRIMARY KEY (`id`),
                CONSTRAINT `fk.customer_selection.customer_id` FOREIGN KEY (`customer_id`)
                    REFERENCES `customer` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
                CONSTRAINT `fk.customer_selection.product_id` FOREIGN KEY (`product_id`)
                    REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
	");

        $connection->executeStatement("
               ALTER TABLE `customer_selection`
               MODIFY `updated_at` DATETIME(3) NOT NULL DEFAULT CURRENT_TIMESTAMP(3) ON UPDATE CURRENT_TIMESTAMP(3);
        ");
    }

    public function updateDestructive(Connection $connection): void
    {
        // Implement update destructive
    }
}
