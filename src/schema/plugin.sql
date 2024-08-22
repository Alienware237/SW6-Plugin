CREATE TABLE `plugin` (
    `id` BINARY(16) NOT NULL,
    `base_class` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `composer_name` VARCHAR(255) NULL,
    `autoload` JSON NOT NULL,
    `active` TINYINT(1) NULL DEFAULT '0',
    `managed_by_composer` TINYINT(1) NULL DEFAULT '0',
    `path` VARCHAR(255) NULL,
    `author` VARCHAR(255) NULL,
    `copyright` VARCHAR(255) NULL,
    `license` VARCHAR(255) NULL,
    `version` VARCHAR(255) NOT NULL,
    `upgrade_version` VARCHAR(255) NULL,
    `installed_at` DATETIME(3) NULL,
    `upgraded_at` DATETIME(3) NULL,
    `icon` LONGBLOB NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `json.plugin.autoload` CHECK (JSON_VALID(`autoload`)),
    CONSTRAINT `json.plugin.translated` CHECK (JSON_VALID(`translated`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `plugin_translation` (
    `label` VARCHAR(255) NOT NULL,
    `description` LONGTEXT NULL,
    `manufacturer_link` VARCHAR(255) NULL,
    `support_link` VARCHAR(255) NULL,
    `custom_fields` JSON NULL,
    `created_at` DATETIME(3) NOT NULL,
    `updated_at` DATETIME(3) NULL,
    `plugin_id` BINARY(16) NOT NULL,
    `language_id` BINARY(16) NOT NULL,
    PRIMARY KEY (`plugin_id`,`language_id`),
    CONSTRAINT `json.plugin_translation.custom_fields` CHECK (JSON_VALID(`custom_fields`)),
    KEY `fk.plugin_translation.plugin_id` (`plugin_id`),
    KEY `fk.plugin_translation.language_id` (`language_id`),
    CONSTRAINT `fk.plugin_translation.plugin_id` FOREIGN KEY (`plugin_id`) REFERENCES `plugin` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT `fk.plugin_translation.language_id` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;