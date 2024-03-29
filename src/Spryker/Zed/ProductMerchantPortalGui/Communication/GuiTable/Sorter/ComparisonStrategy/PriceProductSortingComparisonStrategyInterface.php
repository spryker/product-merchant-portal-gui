<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\Sorter\ComparisonStrategy;

interface PriceProductSortingComparisonStrategyInterface
{
    /**
     * @param string $fieldName
     *
     * @return bool
     */
    public function isApplicable(string $fieldName): bool;

    /**
     * @param string $fieldName
     *
     * @return callable
     */
    public function getValueExtractorFunction(string $fieldName): callable;
}
