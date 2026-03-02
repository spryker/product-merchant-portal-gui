<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProductTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ValidationResponseTransfer;

interface ProductMerchantPortalGuiToMerchantProductFacadeInterface
{
    public function findMerchantProduct(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ?MerchantProductTransfer;

    public function validateMerchantProduct(MerchantProductTransfer $merchantProductTransfer): ValidationResponseTransfer;

    public function getProductConcreteCollection(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ProductConcreteCollectionTransfer;

    public function findProductConcrete(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ?ProductConcreteTransfer;

    public function isProductConcreteOwnedByMerchant(
        ProductConcreteTransfer $productConcreteTransfer,
        MerchantTransfer $merchantTransfer
    ): bool;

    public function isProductAbstractOwnedByMerchant(
        ProductAbstractTransfer $productAbstractTransfer,
        MerchantTransfer $merchantTransfer
    ): bool;
}
