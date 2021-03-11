<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;


use Generated\Shared\Transfer\GuiTableConfigurationTransfer;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductAbstractTableViewTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface;
use Spryker\Shared\GuiTable\GuiTableFactoryInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface;

abstract class PriceProductGuiTableConfigurationProvider
{
    protected const TITLE_COLUMN_STORE = 'Store';
    protected const TITLE_COLUMN_CURRENCY = 'Currency';
    protected const TITLE_COLUMN_PREFIX_PRICE_TYPE_NET = 'Net';
    protected const TITLE_COLUMN_PREFIX_PRICE_TYPE_GROSS = 'Gross';

    protected const TITLE_FILTER_IN_STORES = 'Stores';
    protected const TITLE_FILTER_IN_CURRENCIES = 'Currencies';

    protected const TITLE_ROW_ACTION_DELETE = 'Delete';
    protected const TITLE_EDITABLE_BUTTON = 'Add';

    protected const FORMAT_STRING_PRICE_KEY = '%s[%s][%s]';
    protected const FORMAT_STRING_DATA_URL = '%s?%s=%s';
    protected const FORMAT_STRING_PRICES_URL = '%s?%s=${row.%s}&%s=${row.%s}';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\UpdateProductAbstractController::tableDataAction()
     */
    protected const DATA_URL = '/product-merchant-portal-gui/update-product-abstract/table-data';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\SavePriceProductAbstractController::indexAction()
     */
    protected const URL_SAVE_PRICES = '/product-merchant-portal-gui/save-price-product-abstract';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\DeletePriceProductAbstractController::indexAction()
     */
    protected const URL_DELETE_PRICE = '/product-merchant-portal-gui/delete-price-product-abstract';

    /**
     * @var \Spryker\Shared\GuiTable\GuiTableFactoryInterface
     */
    protected $guiTableFactory;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface
     */
    protected $priceProductFacade;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\StoreFilterOptionsProviderInterface
     */
    protected $storeFilterOptionsProvider;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\CurrencyFilterConfigurationProviderInterface
     */
    protected $currencyFilterConfigurationProvider;

    /**
     * @param \Spryker\Shared\GuiTable\GuiTableFactoryInterface $guiTableFactory
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface $priceProductFacade
     * @param \Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\StoreFilterOptionsProviderInterface $storeFilterOptionsProvider
     * @param \Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\CurrencyFilterConfigurationProviderInterface $currencyFilterConfigurationProvider
     */
    public function __construct(
        GuiTableFactoryInterface $guiTableFactory,
        ProductMerchantPortalGuiToPriceProductFacadeInterface $priceProductFacade,
        StoreFilterOptionsProviderInterface $storeFilterOptionsProvider,
        CurrencyFilterConfigurationProviderInterface $currencyFilterConfigurationProvider
    ) {
        $this->guiTableFactory = $guiTableFactory;
        $this->priceProductFacade = $priceProductFacade;
        $this->storeFilterOptionsProvider = $storeFilterOptionsProvider;
        $this->currencyFilterConfigurationProvider = $currencyFilterConfigurationProvider;
    }

    /**
     * @phpstan-param array<mixed> $initialData
     *
     * @param int $idProductAbstract
     * @param array $initialData
     *
     * @return \Generated\Shared\Transfer\GuiTableConfigurationTransfer
     */
    public function getConfiguration(int $idProductAbstract, array $initialData = []): GuiTableConfigurationTransfer
    {
        $guiTableConfigurationBuilder = $this->guiTableFactory->createConfigurationBuilder();

        $guiTableConfigurationBuilder = $this->addColumns($guiTableConfigurationBuilder);
        $guiTableConfigurationBuilder = $this->addFilters($guiTableConfigurationBuilder);


        $guiTableConfigurationBuilder

            ->setDefaultPageSize(10)
            ->isSearchEnabled(false)
            ->isColumnConfiguratorEnabled(false);

        $guiTableConfigurationBuilder = $this->setEditableConfiguration(
            $guiTableConfigurationBuilder,
            $initialData
        );

        return $guiTableConfigurationBuilder->createConfiguration();
    }



    /**
     * @param \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
     *
     * @return \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface
     */
    protected function addColumns(
        GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
    ): GuiTableConfigurationBuilderInterface {
        $guiTableConfigurationBuilder->addColumnChip(
            PriceProductAbstractTableViewTransfer::STORE,
            static::TITLE_COLUMN_STORE,
            true,
            false,
            'grey'
        )->addColumnChip(
            PriceProductAbstractTableViewTransfer::CURRENCY,
            static::TITLE_COLUMN_CURRENCY,
            true,
            false,
            'blue'
        );

        foreach ($this->priceProductFacade->getPriceTypeValues() as $priceTypeTransfer) {
            $idPriceTypeName = mb_strtolower($priceTypeTransfer->getNameOrFail());
            $titlePriceTypeName = ucfirst($idPriceTypeName);
            $idNetColumn = sprintf(
                static::FORMAT_STRING_PRICE_KEY,
                $idPriceTypeName,
                PriceProductTransfer::MONEY_VALUE,
                MoneyValueTransfer::NET_AMOUNT
            );

            $idGrossColumn = sprintf(
                static::FORMAT_STRING_PRICE_KEY,
                $idPriceTypeName,
                PriceProductTransfer::MONEY_VALUE,
                MoneyValueTransfer::GROSS_AMOUNT
            );

            $guiTableConfigurationBuilder->addColumnText(
                $idNetColumn,
                static::TITLE_COLUMN_PREFIX_PRICE_TYPE_NET . ' ' . $titlePriceTypeName,
                true,
                false
            )->addColumnText(
                $idGrossColumn,
                static::TITLE_COLUMN_PREFIX_PRICE_TYPE_GROSS . ' ' . $titlePriceTypeName,
                true,
                false
            );
        }

        return $guiTableConfigurationBuilder;
    }

    /**
     * @param \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
     *
     * @return \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface
     */
    protected function addEditableColumns(GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder): GuiTableConfigurationBuilderInterface
    {
        $guiTableConfigurationBuilder->addEditableColumnSelect(
            PriceProductAbstractTableViewTransfer::STORE,
            static::TITLE_COLUMN_STORE,
            false,
            $this->storeFilterOptionsProvider->getStoreOptions()
        )->addEditableColumnSelect(
            PriceProductAbstractTableViewTransfer::CURRENCY,
            static::TITLE_COLUMN_CURRENCY,
            false,
            $this->currencyFilterConfigurationProvider->getCurrencyOptions()
        );

        foreach ($this->priceProductFacade->getPriceTypeValues() as $priceTypeTransfer) {
            $idPriceTypeName = mb_strtolower($priceTypeTransfer->getNameOrFail());
            $titlePriceTypeName = ucfirst($idPriceTypeName);
            $idNetColumn = sprintf(
                static::FORMAT_STRING_PRICE_KEY,
                $idPriceTypeName,
                PriceProductTransfer::MONEY_VALUE,
                MoneyValueTransfer::NET_AMOUNT
            );
            $idGrossColumn = sprintf(
                static::FORMAT_STRING_PRICE_KEY,
                $idPriceTypeName,
                PriceProductTransfer::MONEY_VALUE,
                MoneyValueTransfer::GROSS_AMOUNT
            );
            $fieldOptions = [
                'attrs' => [
                    'step' => '0.01',
                ],
            ];

            $guiTableConfigurationBuilder->addEditableColumnInput(
                $idNetColumn,
                static::TITLE_COLUMN_PREFIX_PRICE_TYPE_NET . ' ' . $titlePriceTypeName,
                'number',
                $fieldOptions
            )->addEditableColumnInput(
                $idGrossColumn,
                static::TITLE_COLUMN_PREFIX_PRICE_TYPE_GROSS . ' ' . $titlePriceTypeName,
                'number',
                $fieldOptions
            );
        }

        return $guiTableConfigurationBuilder;
    }

    /**
     * @param \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder
     *
     * @return \Spryker\Shared\GuiTable\Configuration\Builder\GuiTableConfigurationBuilderInterface
     */
    protected function addFilters(GuiTableConfigurationBuilderInterface $guiTableConfigurationBuilder): GuiTableConfigurationBuilderInterface
    {
        $guiTableConfigurationBuilder
            ->addFilterSelect(
                'inStores',
                static::TITLE_FILTER_IN_STORES,
                true,
                $this->storeFilterOptionsProvider->getStoreOptions()
            )
            ->addFilterSelect(
                'inCurrencies',
                static::TITLE_FILTER_IN_CURRENCIES,
                true,
                $this->currencyFilterConfigurationProvider->getCurrencyOptions()
            );

        return $guiTableConfigurationBuilder;
    }
}