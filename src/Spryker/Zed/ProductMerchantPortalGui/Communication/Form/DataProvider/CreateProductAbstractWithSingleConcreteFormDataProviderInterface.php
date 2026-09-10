<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\DataProvider;

use Symfony\Component\HttpFoundation\Request;

interface CreateProductAbstractWithSingleConcreteFormDataProviderInterface
{
    /**
     * @return array<string, mixed>
     */
    public function getDefaultData(Request $request): array;
}
