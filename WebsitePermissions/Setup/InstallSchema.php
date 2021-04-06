<?php

namespace BoostMyShop\WebsitePermissions\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $otpTableName = $installer->getTable('admin_user');
        if ($setup->getConnection()->isTableExists($otpTableName)) {
            $setup->getConnection()->addColumn(
                $otpTableName,
                'website_id',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    'default' => null,
                    'length' => 11,
                    'comment' => 'Website Id'
                ]
            );
        }

        $installer->endSetup();
    }
}
