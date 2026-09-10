<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMerchantUserFacadeInterface;

class StoreFilterOptionsProvider implements StoreFilterOptionsProviderInterface
{
    protected ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade;

    public function __construct(ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade)
    {
        $this->merchantUserFacade = $merchantUserFacade;
    }

    /**
     * {@inheritDoc}
     */
    public function getStoreOptions(): array
    {
        $storeTransfers = $this->getCurrentMerchantStores();

        $storeOptions = [];
        foreach ($storeTransfers as $storeTransfer) {
            if ($storeTransfer->getName() === null) {
                continue;
            }
            $storeOptions[(int)$storeTransfer->getIdStore()] = $storeTransfer->getNameOrFail();
        }

        return $storeOptions;
    }

    /**
     * Limited to stores the current merchant is assigned to, not all stores in the system.
     *
     * @return array<\Generated\Shared\Transfer\StoreTransfer>
     */
    protected function getCurrentMerchantStores(): array
    {
        $merchantTransfer = $this->merchantUserFacade
            ->getCurrentMerchantUser()
            ->getMerchant();

        if (!$merchantTransfer || !$merchantTransfer->getStoreRelation()) {
            return [];
        }

        return $merchantTransfer->getStoreRelationOrFail()
            ->getStores()
            ->getArrayCopy();
    }
}
