<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint;

use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductAttributeFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToTranslatorFacadeInterface;
use Symfony\Component\Validator\Constraint;

class ProductAbstractAttributeUniqueCombinationConstraint extends Constraint
{
    /**
     * @var string
     */
    protected const PARAMETER_ATTRIBUTE = '%attribute%';

    protected string $message = 'The attribute %attribute% already exists. Please define another one';

    protected ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade;

    protected ProductMerchantPortalGuiToProductFacadeInterface $productFacade;

    protected ProductMerchantPortalGuiToTranslatorFacadeInterface $translatorFacade;

    public function __construct(
        ProductMerchantPortalGuiToProductAttributeFacadeInterface $productAttributeFacade,
        ProductMerchantPortalGuiToProductFacadeInterface $productFacade,
        ProductMerchantPortalGuiToTranslatorFacadeInterface $translatorFacade
    ) {
        parent::__construct();

        $this->productAttributeFacade = $productAttributeFacade;
        $this->productFacade = $productFacade;
        $this->translatorFacade = $translatorFacade;
    }

    public function getProductAttributeFacade(): ProductMerchantPortalGuiToProductAttributeFacadeInterface
    {
        return $this->productAttributeFacade;
    }

    public function getProductFacade(): ProductMerchantPortalGuiToProductFacadeInterface
    {
        return $this->productFacade;
    }

    public function getMessage(string $attribute): string
    {
        /** @phpstan-var array<string, string> $parameters */
        $parameters = [
            static::PARAMETER_ATTRIBUTE => $attribute,
        ];

        return $this->translatorFacade->trans($this->message, $parameters);
    }

    /**
     * @return array<string>|string
     */
    public function getTargets()
    {
        return static::CLASS_CONSTRAINT;
    }
}
