<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\DataProvider;

use ArrayObject;
use Generated\Shared\Transfer\LocalizedAttributesTransfer;

interface ProductAttributeDataProviderInterface
{
    /**
     * @param array<string> $attributes
     * @param \ArrayObject<int|string, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $localizedAttributeTransfers
     *
     * @return array<array<string>>
     */
    public function getData(array $attributes, ArrayObject $localizedAttributeTransfers): array;

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $localizedAttributes
     */
    public function findLocalizedAttribute(ArrayObject $localizedAttributes, int $idLocale): ?LocalizedAttributesTransfer;

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $localizedAttributesTransfers
     */
    public function findLocalizedAttributeByLocaleName(ArrayObject $localizedAttributesTransfers, string $localeName): ?LocalizedAttributesTransfer;
}
