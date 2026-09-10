<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToCurrencyFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMerchantUserFacadeInterface;

class CurrencyFilterConfigurationProvider implements CurrencyFilterConfigurationProviderInterface
{
    protected ProductMerchantPortalGuiToCurrencyFacadeInterface $currencyFacade;

    protected ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade;

    public function __construct(
        ProductMerchantPortalGuiToCurrencyFacadeInterface $currencyFacade,
        ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade
    ) {
        $this->currencyFacade = $currencyFacade;
        $this->merchantUserFacade = $merchantUserFacade;
    }

    /**
     * {@inheritDoc}
     */
    public function getCurrencyOptions(): array
    {
        $merchantStoreIds = $this->getCurrentMerchantStoreIds();
        $storeWithCurrencyTransfers = $this->currencyFacade->getAllStoresWithCurrencies();

        $currencyOptions = [];
        foreach ($storeWithCurrencyTransfers as $storeWithCurrencyTransfer) {
            if (!in_array($storeWithCurrencyTransfer->getStoreOrFail()->getIdStore(), $merchantStoreIds, true)) {
                continue;
            }

            foreach ($storeWithCurrencyTransfer->getCurrencies() as $currencyTransfer) {
                $currencyOptions[(int)$currencyTransfer->getIdCurrency()] = $currencyTransfer->getCodeOrFail();
            }
        }

        return $currencyOptions;
    }

    /**
     * Limited to stores the current merchant is assigned to, not all stores in the system.
     *
     * @return array<int>
     */
    protected function getCurrentMerchantStoreIds(): array
    {
        $merchantTransfer = $this->merchantUserFacade
            ->getCurrentMerchantUser()
            ->getMerchant();

        if (!$merchantTransfer || !$merchantTransfer->getStoreRelation()) {
            return [];
        }

        $storeIds = [];
        foreach ($merchantTransfer->getStoreRelationOrFail()->getStores() as $storeTransfer) {
            $storeIds[] = $storeTransfer->getIdStoreOrFail();
        }

        return $storeIds;
    }
}
