<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\CategoryCollectionTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface ProductMerchantPortalGuiToProductCategoryFacadeInterface
{
    public function getCategoryTransferCollectionByIdProductAbstract(int $idProductAbstract, LocaleTransfer $localeTransfer): CategoryCollectionTransfer;

    /**
     * @param array<int> $productIdsToAssign
     */
    public function createProductCategoryMappings(int $idCategory, array $productIdsToAssign): void;

    /**
     * @param array<int> $productIdsToUnAssign
     */
    public function removeProductCategoryMappings(int $idCategory, array $productIdsToUnAssign): void;
}
