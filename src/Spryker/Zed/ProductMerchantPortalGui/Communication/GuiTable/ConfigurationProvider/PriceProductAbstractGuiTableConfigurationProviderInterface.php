<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\GuiTable\ConfigurationProvider;

use Generated\Shared\Transfer\GuiTableConfigurationTransfer;

interface PriceProductAbstractGuiTableConfigurationProviderInterface
{
    /**
     * @param array<string, array<string, mixed>> $initialData
     */
    public function getConfiguration(int $idProductAbstract, array $initialData = []): GuiTableConfigurationTransfer;
}
