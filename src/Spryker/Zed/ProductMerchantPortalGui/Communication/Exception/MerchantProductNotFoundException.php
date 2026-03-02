<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MerchantProductNotFoundException extends NotFoundHttpException
{
    public function __construct(int $idMerchant, int $idProductAbstract)
    {
        parent::__construct($this->buildMessage($idMerchant, $idProductAbstract));
    }

    protected function buildMessage(int $idMerchant, int $idProductAbstract): string
    {
        return sprintf(
            'Product abstract is not found for product abstract id %d and merchant id %d.',
            $idProductAbstract,
            $idMerchant,
        );
    }
}
