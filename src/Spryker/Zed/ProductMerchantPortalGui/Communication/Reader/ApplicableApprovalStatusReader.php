<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Reader;

use Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig;

class ApplicableApprovalStatusReader implements ApplicableApprovalStatusReaderInterface
{
    protected ProductMerchantPortalGuiConfig $productMerchantPortalGuiConfig;

    public function __construct(ProductMerchantPortalGuiConfig $productMerchantPortalGuiConfig)
    {
        $this->productMerchantPortalGuiConfig = $productMerchantPortalGuiConfig;
    }

    /**
     * @return array<string>
     */
    public function getApplicableUpdateApprovalStatuses(string $currentStatus): array
    {
        return $this->productMerchantPortalGuiConfig->getProductApprovalUpdateStatusTree()[$currentStatus] ?? [];
    }
}
