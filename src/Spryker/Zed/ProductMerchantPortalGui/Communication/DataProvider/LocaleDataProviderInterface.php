<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\DataProvider;

interface LocaleDataProviderInterface
{
    /**
     * @return string|null
     */
    public function findDefaultStoreDefaultLocale(): ?string;
}
