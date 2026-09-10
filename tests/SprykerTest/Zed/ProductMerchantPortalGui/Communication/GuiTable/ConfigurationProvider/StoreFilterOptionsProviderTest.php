<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\MerchantUserBuilder;
use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider\StoreFilterOptionsProvider;
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
 * @group StoreFilterOptionsProviderTest
 * Add your own group annotations below this line
 */
class StoreFilterOptionsProviderTest extends Unit
{
    /**
     * @var string
     */
    protected const STORE_NAME = 'DE';

    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testGetStoreOptionsShouldReturnOnlyStoresAssignedToCurrentMerchant(): void
    {
        // Arrange
        $merchantRelatedStoreTransfer = $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME]);
        $this->tester->haveStore([StoreTransfer::NAME => static::STORE_NAME]);

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

        $storeFilterOptionsProvider = new StoreFilterOptionsProvider($merchantUserFacade);

        // Act
        $storeOptions = $storeFilterOptionsProvider->getStoreOptions();

        // Assert
        $this->assertCount(1, $storeOptions);
        $this->assertArrayHasKey($merchantRelatedStoreTransfer->getIdStoreOrFail(), $storeOptions);
    }
}
