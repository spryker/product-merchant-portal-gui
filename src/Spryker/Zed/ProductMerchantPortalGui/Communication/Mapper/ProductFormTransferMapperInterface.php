<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper;

use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;

interface ProductFormTransferMapperInterface
{
    /**
     * @param array<mixed> $addProductConcreteFormData
     */
    public function mapAddProductConcreteFormDataToProductConcreteCollectionTransfer(
        array $addProductConcreteFormData,
        ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
    ): ProductConcreteCollectionTransfer;
}
