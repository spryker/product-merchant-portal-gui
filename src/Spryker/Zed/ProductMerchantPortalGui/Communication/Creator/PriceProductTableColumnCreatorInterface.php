<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Creator;

use Generated\Shared\Transfer\PriceProductTransfer;

interface PriceProductTableColumnCreatorInterface
{
    public function createPriceColumnId(string $priceTypeName, string $moneyValueType): string;

    /**
     * @param array<string> $propertyPathValues
     */
    public function createColumnIdFromPropertyPath(
        PriceProductTransfer $priceProductTransfer,
        array $propertyPathValues
    ): string;

    public function createVolumeQuantityColumnId(): string;
}
