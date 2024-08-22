<?php declare(strict_types=1);

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
	    // Create the Admin table
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS `admin` (
                `id` BINARY(16) NOT NULL,
                `session_id` VARCHAR(255) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // Create the Product table with a foreign key to Admin
        $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS `product` (
                `id` BINARY(16) NOT NULL,
                `product_number` VARCHAR(255) NOT NULL,
                `quantities` INT NOT NULL,
                `admin_id` BINARY(16) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                PRIMARY KEY (`id`),
                FOREIGN KEY (`admin_id`) REFERENCES `admin`(`id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }

    public function updateDestructive(Connection $connection): void
    {
        // Implement update destructive
    }
}
