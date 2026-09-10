<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint;

use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductAttributeFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface;
use Symfony\Component\Validator\Constraint;

class ProductAttributesNotBlankConstraint extends Constraint
{
    protected string $message = 'Please fill in at least one value';

    protected ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade;

    protected ProductMerchantPortalGuiToProductFacadeInterface $productFacade;

    public function __construct(
        ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade,
        ProductMerchantPortalGuiToProductFacadeInterface $productFacade
    ) {
        parent::__construct();

        $this->productAttributeFacade = $productAttributeFacade;
        $this->productFacade = $productFacade;
    }

    public function getProductAttributeFacade(): ProductMerchantPortalGuiToProductAttributeFacadeInterface
    {
        return $this->productAttributeFacade;
    }

    public function getProductFacade(): ProductMerchantPortalGuiToProductFacadeInterface
    {
        return $this->productFacade;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return array<string>|string
     */
    public function getTargets()
    {
        return static::CLASS_CONSTRAINT;
    }
}
