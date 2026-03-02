<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint;

use Symfony\Component\Validator\Constraint as SymfonyConstraint;

class UniqueAbstractSkuConstraint extends SymfonyConstraint
{
    /**
     * @var string
     */
    protected const MESSAGE = 'SKU Prefix already exists';

    public function getMessage(): string
    {
        return static::MESSAGE;
    }

    public function getTargets(): string
    {
        return static::CLASS_CONSTRAINT;
    }
}
