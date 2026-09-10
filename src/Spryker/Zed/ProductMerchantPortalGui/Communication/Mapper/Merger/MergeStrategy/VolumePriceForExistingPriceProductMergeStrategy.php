<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper\Merger\MergeStrategy;

use ArrayObject;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToPriceProductServiceInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToPriceProductVolumeServiceInterface;

class VolumePriceForExistingPriceProductMergeStrategy extends AbstractPriceProductMergeStrategy
{
    protected ProductMerchantPortalGuiToPriceProductVolumeServiceInterface $priceProductVolumeService;

    public function __construct(
        ProductMerchantPortalGuiToPriceProductVolumeServiceInterface $priceProductVolumeService,
        ProductMerchantPortalGuiToPriceProductServiceInterface $priceProductService
    ) {
        $this->priceProductVolumeService = $priceProductVolumeService;

        parent::__construct($priceProductService);
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    public function isApplicable(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): bool {
        return $this->isVolumePriceProduct($newPriceProductTransfer)
            && $this->isPriceProductInCollection($newPriceProductTransfer, $priceProductTransfers);
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function merge(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): ArrayObject {
        foreach ($priceProductTransfers as $priceProductTransfer) {
            if ($this->isSamePriceProduct($priceProductTransfer, $newPriceProductTransfer)) {
                $this->priceProductVolumeService->addVolumePrice($priceProductTransfer, $newPriceProductTransfer);

                return $priceProductTransfers;
            }
        }

        return $priceProductTransfers;
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    protected function isPriceProductInCollection(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): bool {
        foreach ($priceProductTransfers as $priceProductTransfer) {
            if ($this->isSamePriceProduct($priceProductTransfer, $newPriceProductTransfer)) {
                return true;
            }
        }

        return false;
    }
}
