<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Exception;

use Exception;

class WrongRequestBodyContentException extends Exception
{
    public function __construct(string $key)
    {
        parent::__construct($this->buildMessage($key));
    }

    protected function buildMessage(string $key): string
    {
        return sprintf(
            'Key %s does not exist in request body content.',
            $key,
        );
    }
}
