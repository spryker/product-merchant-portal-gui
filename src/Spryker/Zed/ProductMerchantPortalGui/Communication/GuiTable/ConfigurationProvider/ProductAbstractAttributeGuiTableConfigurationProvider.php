<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Generated\Shared\Transfer\GuiTableEditableButtonTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\ProductAbstractNotFoundException;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\ProductAbstractForm;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductAttributeFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface;

class ProductAbstractAttributeGuiTableConfigurationProvider implements ProductAbstractAttributeGuiTableConfigurationProviderInterface
{
    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::PARAM_ID_PRODUCT_ABSTRACT
     */
    protected const PARAM_ID_PRODUCT_ABSTRACT = 'idProductAbstract';
    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::PARAM_ATTRIBUTE_NAME
     */
    protected const PARAM_ATTRIBUTE_NAME = 'attribute_name';

    public const COL_KEY_COLUMN_TYPE = 'columnType';
    public const COL_KEY_COLUMN_TYPE_OPTIONS = 'columnTypeOptions';
    public const COL_KEY_ALLOW_INPUT = 'allowInput';
    public const COL_KEY_ID_PRODUCT_ABSTRACT = 'idProductAbstract';
    public const COL_KEY_ATTRIBUTE_NAME = 'attribute_name';
    public const COL_KEY_ATTRIBUTE_DEFAULT = 'attribute_default';

    protected const TITLE_COLUMN_ATTRIBUTE_NAME = 'Attribute';
    protected const TITLE_COLUMN_ATTRIBUTE_DEFAULT = 'Default';

    protected const ID_ROW_ACTION_DELETE = 'delete-attribute';
    protected const TITLE_ROW_ACTION_DELETE = 'Delete';

    protected const FORMAT_STRING_DATA_URL = '%s?%s=%s';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::attributeDataAction()
     */
    protected const PRODUCT_ATTRIBUTES_DATA_URL = '/product-merchant-portal-gui/product-attributes/attribute-data/';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::saveAction()
     */
    protected const PRODUCT_ATTRIBUTE_SAVE_DATA_URL = '/product-merchant-portal-gui/product-attributes/save';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::deleteAction()
     */
    protected const PRODUCT_ATTRIBUTE_DELETE_URL = '/product-merchant-portal-gui/product-attributes/delete';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController::tableDataAction()
     */
    protected const PRODUCT_ATTRIBUTES_TABLE_DATA_URL = '/product-merchant-portal-gui/product-attributes/table-data';

    protected const PLACEHOLDER_SELECT_ATTRIBUTE = 'Select';

    protected const COLOR_GREY = 'grey';
    protected const COLOR_BLUE = 'blue';

    /**
     * @var \Spryker\Shared\GuiTable\GuiTableFactoryInterface
     */
    protected $guiTableFactory;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductAttributeFacadeInterface
     */
    protected $productAttributeFacade;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @param \Spryker\Shared\GuiTable\GuiTableFactoryInterface $guiTableFactory
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface $productFacade
     */
    public function __construct(
        GuiTableFactoryInterface $guiTableFactory,
        ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade,
        ProductMerchantPortalGuiToProductFacadeInterface $productFacade
    ) {
        $this->guiTableFactory = $guiTableFactory;
        $this->productAttributeFacade = $productAttributeFacade;
        $this->productFacade = $productFacade;
    }

    /**
     * @param int $idProductAbstract
     * @param array $attributesInitialData
     *
     * @throws \Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\ProductAbstractNotFoundException
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    public function getConfiguration(
        int $idProductAbstract,
        array $attributesInitialData
    ): GuiTableConfigurationTransfer {
        $productAbstract = $this->productFacade->findProductAbstractById($idProductAbstract);

        if (!$productAbstract) {
            throw new ProductAbstractNotFoundException((int)$idProductAbstract);
        }

        $guiTableConfigurationBuilder = $this->guiTableFactory->createConfigurationBuilder();

        $guiTableConfigurationBuilder
            ->addColumnChip(static::COL_KEY_ATTRIBUTE_NAME, static::TITLE_COLUMN_ATTRIBUTE_NAME, true, false, self::COLOR_GREY)
            ->addColumnChip(static::COL_KEY_ATTRIBUTE_DEFAULT, static::TITLE_COLUMN_ATTRIBUTE_DEFAULT, true, false, self::COLOR_BLUE);

        foreach ($productAbstract->getLocalizedAttributes() as $localizedAttributesTransfer) {
            $localeTransfer = $localizedAttributesTransfer->getLocaleOrFail();

            $guiTableConfigurationBuilder->addColumnText(
                $localeTransfer->getLocaleNameOrFail(),
                $localeTransfer->getLocaleNameOrFail(),
                true,
                true
            );
            $guiTableConfigurationBuilder->addEditableColumnDynamic(
                $localeTransfer->getLocaleNameOrFail(),
                $localeTransfer->getLocaleNameOrFail(),
                static::COL_KEY_ATTRIBUTE_NAME,
                self::PRODUCT_ATTRIBUTES_DATA_URL
            );
        }

        $dataSourceUrl = sprintf(
            static::FORMAT_STRING_DATA_URL,
            static::PRODUCT_ATTRIBUTES_TABLE_DATA_URL,
            static::COL_KEY_ID_PRODUCT_ABSTRACT,
            $idProductAbstract
        );

        $guiTableConfigurationBuilder->setDataSourceUrl($dataSourceUrl)
            ->setIsPaginationEnabled(false)
            ->isSearchEnabled(false);

        $guiTableConfigurationBuilder = $this->addEditableColumns($guiTableConfigurationBuilder, $attributesInitialData);
        $guiTableConfigurationBuilder = $this->addRowActions($guiTableConfigurationBuilder);
        $guiTableConfigurationTransfer = $guiTableConfigurationBuilder->createConfiguration();

        $guiTableConfigurationTransfer->getEditableOrFail()->getUpdateOrFail()->addDisableForCol('attribute_name');

        return $guiTableConfigurationTransfer;
    }

    /**
     * @param \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
     * @param array $attributesInitialData
     *
     * @return \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface
     */
    protected function addEditableColumns(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder,
        array $attributesInitialData
    ): GuiTableConfigurationBuilderInterface {
        $allAttributes = $this->productAttributeFacade->getProductAttributeCollection();

        $attributesOptions = [];
        foreach ($allAttributes as $attribute) {
            $attributesOptions[$attribute->getKey()] = $attribute->getKey();
        }

        $guiTableConfigurationBuilder->addEditableColumnSelect(
            static::COL_KEY_ATTRIBUTE_NAME,
            static::TITLE_COLUMN_ATTRIBUTE_NAME,
            false,
            $attributesOptions,
            self::PLACEHOLDER_SELECT_ATTRIBUTE
        )->addEditableColumnDynamic(
            static::COL_KEY_ATTRIBUTE_DEFAULT,
            static::TITLE_COLUMN_ATTRIBUTE_DEFAULT,
            static::COL_KEY_ATTRIBUTE_NAME,
            self::PRODUCT_ATTRIBUTES_DATA_URL
        );

        $guiTableConfigurationBuilder->enableInlineDataEditing($this->getAttributeActionUrl(self::PRODUCT_ATTRIBUTE_SAVE_DATA_URL), 'POST');

        $formInputName = sprintf('%s[%s]', ProductAbstractForm::BLOCK_PREFIX, ProductAbstractTransfer::ATTRIBUTES);

        $guiTableConfigurationBuilder->enableAddingNewRows($formInputName, $attributesInitialData, [GuiTableEditableButtonTransfer::TITLE => 'Add']);

        return $guiTableConfigurationBuilder;
    }

    /**
     * @param \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
     *
     * @return \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface
     */
    protected function addRowActions(GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder): GuiTableConfigurationBuilderInterface
    {
        $guiTableConfigurationBuilder->addRowActionUrl(
            static::ID_ROW_ACTION_DELETE,
            static::TITLE_ROW_ACTION_DELETE,
            $this->getAttributeActionUrl(self::PRODUCT_ATTRIBUTE_DELETE_URL)
        );

        return $guiTableConfigurationBuilder;
    }

    /**
     * @param string $action
     *
     * @return string
     */
    protected function getAttributeActionUrl(string $action): string
    {
        return sprintf(
            '%s?%s=${row.%s}&%s=${row.%s}',
            $action,
            static::PARAM_ATTRIBUTE_NAME,
            static::COL_KEY_ATTRIBUTE_NAME,
            static::PARAM_ID_PRODUCT_ABSTRACT,
            static::COL_KEY_ID_PRODUCT_ABSTRACT,
        );
    }
}
