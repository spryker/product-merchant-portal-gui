<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductConcreteNotFoundException extends NotFoundHttpException
{
    public function __construct(int $idProductConcrete)
    {
        parent::__construct($this->buildMessage($idProductConcrete));
    }

    protected function buildMessage(int $idProductConcrete): string
    {
        return sprintf(
            'Product concrete is not found for product concrete id %d.',
            $idProductConcrete,
        );
    }
}
