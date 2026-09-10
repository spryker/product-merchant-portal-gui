<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\DataProvider;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\DefaultStoreDefaultLocaleNotFoundException;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToLocaleFacadeInterface;

class LocaleDataProvider implements LocaleDataProviderInterface
{
    protected ProductMerchantPortalGuiToLocaleFacadeInterface $localeFacade;

    public function __construct(
        ProductMerchantPortalGuiToLocaleFacadeInterface $localeFacade
    ) {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @throws \Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\DefaultStoreDefaultLocaleNotFoundException
     */
    public function getDefaultStoreDefaultLocale(): LocaleTransfer
    {
        $localeTransfers = $this->localeFacade->getLocaleCollection();

        $defaultLocaleTransfer = current($localeTransfers);

        if ($defaultLocaleTransfer) {
            return $defaultLocaleTransfer;
        }

        throw new DefaultStoreDefaultLocaleNotFoundException();
    }
}
