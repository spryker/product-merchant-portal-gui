<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Codeception\Stub;
use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\MerchantUserBuilder;
use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\CurrencyTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Generated\Shared\Transfer\StoreWithCurrencyTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\CurrencyFilterConfigurationProvider;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToCurrencyFacadeInterface;
use SprykerTest\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiCommunicationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductMerchantPortalGui
 * @group Communication
 * @group GuiTable
 * @group ConfigurationProvider
 * @group CurrencyFilterConfigurationProviderTest
 * Add your own group annotations below this line
 */
class CurrencyFilterConfigurationProviderTest extends Unit
{
    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testGetCurrencyOptionsShouldReturnOnlyCurrenciesOfStoresAssignedToCurrentMerchant(): void
    {
        // Arrange
        $merchantRelatedStoreTransfer = (new StoreTransfer())->setIdStore(1)->setName('DE');
        $otherStoreTransfer = (new StoreTransfer())->setIdStore(2)->setName('TR');

        $merchantCurrencyTransfer = (new CurrencyTransfer())->setIdCurrency(1)->setCode('EUR');
        $otherCurrencyTransfer = (new CurrencyTransfer())->setIdCurrency(2)->setCode('TRY');

        $storeWithCurrencyTransfers = [
            (new StoreWithCurrencyTransfer())->setStore($merchantRelatedStoreTransfer)->addCurrency($merchantCurrencyTransfer),
            (new StoreWithCurrencyTransfer())->setStore($otherStoreTransfer)->addCurrency($otherCurrencyTransfer),
        ];

        $currencyFacadeMock = Stub::makeEmpty(
            ProductMerchantPortalGuiToCurrencyFacadeInterface::class,
            [
                'getAllStoresWithCurrencies' => function () use ($storeWithCurrencyTransfers) {
                    return $storeWithCurrencyTransfers;
                },
            ],
        );

        $storeRelationTransfer = (new StoreRelationBuilder())
            ->withStores($merchantRelatedStoreTransfer->toArray())
            ->build();

        $merchantUserTransfer = (new MerchantUserBuilder())
            ->withMerchant([
                MerchantTransfer::ID_MERCHANT => 1,
                MerchantTransfer::STORE_RELATION => $storeRelationTransfer,
            ])
            ->build();

        $merchantUserFacade = $this->tester->createMerchantUserFacadeMock([
            'getCurrentMerchantUser' => function () use ($merchantUserTransfer) {
                return $merchantUserTransfer;
            },
        ]);

        $currencyFilterConfigurationProvider = new CurrencyFilterConfigurationProvider($currencyFacadeMock, $merchantUserFacade);

        // Act
        $currencyOptions = $currencyFilterConfigurationProvider->getCurrencyOptions();

        // Assert
        $this->assertCount(1, $currencyOptions);
        $this->assertArrayHasKey($merchantCurrencyTransfer->getIdCurrencyOrFail(), $currencyOptions);
    }
}
