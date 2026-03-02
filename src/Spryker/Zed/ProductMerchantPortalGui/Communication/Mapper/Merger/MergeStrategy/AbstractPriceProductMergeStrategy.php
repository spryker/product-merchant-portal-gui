<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper\Merger\MergeStrategy;

use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToPriceProductServiceInterface;

abstract class AbstractPriceProductMergeStrategy implements PriceProductMergeStrategyInterface
{
    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToPriceProductServiceInterface
     */
    protected ProductMerchantPortalGuiToPriceProductServiceInterface $priceProductService;

    public function __construct(ProductMerchantPortalGuiToPriceProductServiceInterface $priceProductService)
    {
        $this->priceProductService = $priceProductService;
    }

    protected function isNewPriceProductTransfer(PriceProductTransfer $priceProductTransfer): bool
    {
        return $priceProductTransfer->getIdPriceProduct() === null;
    }

    protected function isVolumePriceProduct(PriceProductTransfer $priceProductTransfer): bool
    {
        return $priceProductTransfer->getVolumeQuantityOrFail() !== 1;
    }

    protected function isSamePriceProduct(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $priceProductTransferToCompare
    ): bool {
        $priceProductGroupKey = $this->priceProductService->buildPriceProductGroupKey($priceProductTransfer);
        $priceProductToCompareGroupKey = $this->priceProductService->buildPriceProductGroupKey($priceProductTransferToCompare);

        return $priceProductGroupKey === $priceProductToCompareGroupKey;
    }
}
