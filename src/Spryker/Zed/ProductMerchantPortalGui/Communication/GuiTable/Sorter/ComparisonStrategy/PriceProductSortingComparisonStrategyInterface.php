<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\Sorter\ComparisonStrategy;

interface PriceProductSortingComparisonStrategyInterface
{
    public function isApplicable(string $fieldName): bool;

    public function getValueExtractorFunction(string $fieldName): callable;
}
