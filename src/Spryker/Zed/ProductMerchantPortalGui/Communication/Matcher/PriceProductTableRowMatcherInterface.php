<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Matcher;

use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceProductTableRowMatcherInterface
{
    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    public function isPriceProductInRow(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): bool;
}
