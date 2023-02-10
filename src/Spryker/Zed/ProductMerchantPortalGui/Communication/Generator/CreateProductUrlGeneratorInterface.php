<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Generator;

interface CreateProductUrlGeneratorInterface
{
    /**
     * @param array<string, mixed> $formData
     * @param bool $isSingleConcrete
     *
     * @return string
     */
    public function getCreateUrl(array $formData, bool $isSingleConcrete): string;

    /**
     * @param string $sku
     * @param string $name
     * @param bool $isSingleConcrete
     *
     * @return string
     */
    public function getCreateProductAbstractUrl(string $sku, string $name, bool $isSingleConcrete): string;
}
