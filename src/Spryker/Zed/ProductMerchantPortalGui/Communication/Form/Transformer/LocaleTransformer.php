<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Transformer;

use Generated\Shared\Transfer\LocaleTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToLocaleFacadeInterface;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @implements \Symfony\Component\Form\DataTransformerInterface<\Generated\Shared\Transfer\LocaleTransfer|null, int|null>
 */
class LocaleTransformer implements DataTransformerInterface
{
    protected ProductMerchantPortalGuiToLocaleFacadeInterface $localeFacade;

    public function __construct(ProductMerchantPortalGuiToLocaleFacadeInterface $localeFacade)
    {
        $this->localeFacade = $localeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\LocaleTransfer|mixed $value
     */
    public function transform($value): ?int
    {
        if (!$value instanceof LocaleTransfer) {
            return null;
        }

        return $value->getIdLocale();
    }

    /**
     * @param mixed|int|null $value
     */
    public function reverseTransform($value): ?LocaleTransfer
    {
        if (!$value) {
            return null;
        }

        return $this->localeFacade->getLocaleById($value);
    }
}
