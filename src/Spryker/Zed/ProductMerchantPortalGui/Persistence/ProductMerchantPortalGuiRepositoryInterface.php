<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Persistence;

use Generated\Shared\Transfer\MerchantProductCountsTransfer;
use Generated\Shared\Transfer\MerchantProductTableCriteriaTransfer;
use Generated\Shared\Transfer\ProductAbstractCollectionTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;
use Generated\Shared\Transfer\ProductsDashboardCardCriteriaTransfer;
use Generated\Shared\Transfer\ProductTableCriteriaTransfer;

interface ProductMerchantPortalGuiRepositoryInterface
{
    public function getProductAbstractTableData(
        MerchantProductTableCriteriaTransfer $merchantProductTableCriteriaTransfer
    ): ProductAbstractCollectionTransfer;

    public function getProductTableData(ProductTableCriteriaTransfer $productTableCriteriaTransfer): ProductConcreteCollectionTransfer;

    public function getProductsDashboardCardCounts(
        ProductsDashboardCardCriteriaTransfer $merchantProductDashboardCardCriteriaTransfer
    ): MerchantProductCountsTransfer;
}
