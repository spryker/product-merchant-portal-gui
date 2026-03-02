<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Service;

use Generated\Shared\Transfer\PriceProductTransfer;

class ProductMerchantPortalGuiToPriceProductVolumeServiceBridge implements ProductMerchantPortalGuiToPriceProductVolumeServiceInterface
{
    /**
     * @var \Spryker\Service\PriceProductVolume\PriceProductVolumeServiceInterface
     */
    protected $priceProductVolumeService;

    /**
     * @param \Spryker\Service\PriceProductVolume\PriceProductVolumeServiceInterface $priceProductVolumeService
     */
    public function __construct($priceProductVolumeService)
    {
        $this->priceProductVolumeService = $priceProductVolumeService;
    }

    public function hasVolumePrices(PriceProductTransfer $priceProductTransfer): bool
    {
        return $this->priceProductVolumeService->hasVolumePrices($priceProductTransfer);
    }

    public function addVolumePrice(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $newVolumePriceProductTransfer
    ): PriceProductTransfer {
        return $this->priceProductVolumeService
            ->addVolumePrice($priceProductTransfer, $newVolumePriceProductTransfer);
    }

    public function deleteVolumePrice(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $volumePriceProductTransferToDelete
    ): PriceProductTransfer {
        return $this->priceProductVolumeService
            ->deleteVolumePrice($priceProductTransfer, $volumePriceProductTransferToDelete);
    }

    public function replaceVolumePrice(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $volumePriceProductTransferToReplace,
        PriceProductTransfer $newVolumePriceProductTransfer
    ): PriceProductTransfer {
        return $this->priceProductVolumeService
            ->replaceVolumePrice(
                $priceProductTransfer,
                $volumePriceProductTransferToReplace,
                $newVolumePriceProductTransfer,
            );
    }

    public function extractVolumePrice(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $volumePriceProductTransfer
    ): ?PriceProductTransfer {
        return $this->priceProductVolumeService
            ->extractVolumePrice($priceProductTransfer, $volumePriceProductTransfer);
    }
}
