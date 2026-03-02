<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantStockCriteriaTransfer;
use Generated\Shared\Transfer\StockCollectionTransfer;

interface ProductMerchantPortalGuiToMerchantStockFacadeInterface
{
    public function get(MerchantStockCriteriaTransfer $merchantStockCriteriaTransfer): StockCollectionTransfer;
}
