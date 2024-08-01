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
	    $connection->executeStatement("
            CREATE TABLE IF NOT EXISTS `fast_order_log` (
                `id` BINARY(16) NOT NULL,
                `session_id` VARCHAR(255) NOT NULL,
                `created_at` DATETIME(3) NOT NULL,
                `products` LONGTEXT NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");
    }
}
