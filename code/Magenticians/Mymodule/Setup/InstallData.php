<?php
namespace Magenticians\Mymodule\Setup;

use Magento\Eav\Setup\EavSetup; 
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;
    private $attributeSetFactory;
    private $attributeSet;
    private $categorySetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory, AttributeSetFactory $attributeSetFactory, CategorySetupFactory $categorySetupFactory )
        {
            $this->eavSetupFactory = $eavSetupFactory; 
            $this->attributeSetFactory = $attributeSetFactory; 
            $this->categorySetupFactory = $categorySetupFactory; 
        } 

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

                // CREATE ATTRIBUTE SET 
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

        $attributeSet = $this->attributeSetFactory->create();
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Product::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $data = [
            'attribute_set_name' => 'DisableAddToCart', 
            'entity_type_id' => $entityTypeId,
            'sort_order' => 200,
        ];
        $attributeSet->setData($data);
        $attributeSet->validate();
        $attributeSet->save();
        $attributeSet->initFromSkeleton($attributeSetId);
        $attributeSet->save();

                // CREATE PRODUCT ATTRIBUTE
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

            $eavSetup->addAttribute(
                    \Magento\Catalog\Model\Product::ENTITY,
                'text_add_to_cart',
                [
                    'type' => 'varchar',
                    'label' => 'Add to Cart Text',
                    'backend' => '',
                    'input' => 'text',
                    'wysiwyg_enabled'   => false,
                    'source' => '',
                    'required' => false,
                    'sort_order' => 5,
                    'global' => \Magento\Catalog\Model\ResourceModel\Eav\Attribute::SCOPE_STORE,
                    'used_in_product_listing' => true,
                    'visible_on_front' => false,
                    'attribute_set' => 'DisableAddToCart',
            ]
        );  
        $setup->endSetup();
    }

} ?>