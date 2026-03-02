<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\CategoryCollectionTransfer;
use Generated\Shared\Transfer\CategoryCriteriaTransfer;
use Generated\Shared\Transfer\CategoryTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface ProductMerchantPortalGuiToCategoryFacadeInterface
{
    public function findCategory(CategoryCriteriaTransfer $categoryCriteriaTransfer): ?CategoryTransfer;

    public function getAllCategoryCollection(LocaleTransfer $localeTransfer): CategoryCollectionTransfer;
}
