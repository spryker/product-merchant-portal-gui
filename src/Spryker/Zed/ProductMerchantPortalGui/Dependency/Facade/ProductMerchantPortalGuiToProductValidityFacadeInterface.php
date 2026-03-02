<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\ProductConcreteTransfer;

interface ProductMerchantPortalGuiToProductValidityFacadeInterface
{
    public function saveProductValidity(ProductConcreteTransfer $productConcreteTransfer): ProductConcreteTransfer;
}
