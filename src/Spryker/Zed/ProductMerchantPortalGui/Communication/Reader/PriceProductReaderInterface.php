<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Reader;

use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTableCriteriaTransfer;

interface PriceProductReaderInterface
{
    /**
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function getPriceProducts(PriceProductTableCriteriaTransfer $priceProductTableCriteriaTransfer): array;

    /**
     * @return array<\Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function getPriceProductsWithoutPriceExtraction(PriceProductCriteriaTransfer $priceProductCriteriaTransfer): array;
}
