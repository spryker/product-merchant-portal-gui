<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Service;

use Generated\Shared\Transfer\PriceProductTransfer;

class ProductMerchantPortalGuiToPriceProductServiceBridge implements ProductMerchantPortalGuiToPriceProductServiceInterface
{
    /**
     * @var \Spryker\Service\PriceProduct\PriceProductServiceInterface
     */
    protected $priceProductService;

    /**
     * @param \Spryker\Service\PriceProduct\PriceProductServiceInterface $priceProductService
     */
    public function __construct($priceProductService)
    {
        $this->priceProductService = $priceProductService;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return string
     */
    public function buildPriceProductGroupKey(PriceProductTransfer $priceProductTransfer): string
    {
        return $this->priceProductService->buildPriceProductGroupKey($priceProductTransfer);
    }
}
