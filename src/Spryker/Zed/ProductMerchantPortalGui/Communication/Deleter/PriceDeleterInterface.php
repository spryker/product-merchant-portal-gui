<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Deleter;

use Generated\Shared\Transfer\ValidationResponseTransfer;

interface PriceDeleterInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    public function deletePrices(array $priceProductTransfers, int $volumeQuantity): ValidationResponseTransfer;
}
