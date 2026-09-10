<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\DataProvider;

interface ProductConcreteEditFormDataProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getData(int $idProductConcrete): array;

    /**
     * Searchability choices are keyed by locale name, valued by idLocale.
     *
     * @return array<string, array<string, int>>
     */
    public function getOptions(): array;
}
