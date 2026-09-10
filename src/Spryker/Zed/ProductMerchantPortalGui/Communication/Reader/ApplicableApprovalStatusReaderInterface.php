<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Reader;

interface ApplicableApprovalStatusReaderInterface
{
    /**
     * @return array<string>
     */
    public function getApplicableUpdateApprovalStatuses(string $currentStatus): array;
}
