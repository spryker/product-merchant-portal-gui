<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Generator;

class CreateProductUrlGenerator implements CreateProductUrlGeneratorInterface
{
    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\CreateProductAbstractController::indexAction()
     */
    protected const URL_INDEX_ACTION = '/product-merchant-portal-gui/create-product-abstract';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\CreateProductAbstractController::createWithSingleConcreteAction()
     */
    protected const URL_WITH_SINGLE_CONCRETE_ACTION = '/product-merchant-portal-gui/create-product-abstract/create-with-single-concrete';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\CreateProductAbstractController::createWithMultiConcreteAction()
     */
    protected const URL_WITH_MULTI_CONCRETE_ACTION = '/product-merchant-portal-gui/create-product-abstract/create-with-multi-concrete';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\CreateProductAbstractForm::FIELD_NAME
     */
    protected const FIELD_NAME = 'name';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\CreateProductAbstractForm::FIELD_SKU
     */
    protected const FIELD_SKU = 'sku';

    /**
     * @param mixed[] $formData
     * @param bool $isSingleConcrete
     *
     * @return string
     */
    public function getCreateUrl(array $formData, bool $isSingleConcrete): string
    {
        $getParams = sprintf(
            '?%s=%s&%s=%s',
            static::FIELD_SKU,
            $formData[static::FIELD_SKU],
            static::FIELD_NAME,
            $formData[static::FIELD_NAME]
        );

        return sprintf(
            '%s%s',
            $isSingleConcrete ? static::URL_WITH_SINGLE_CONCRETE_ACTION : static::URL_WITH_MULTI_CONCRETE_ACTION,
            $getParams
        );
    }

    /**
     * @param string $sku
     * @param string $name
     *
     * @return string
     */
    public function getCreateProductAbstractUrl(string $sku, string $name): string
    {
        return sprintf(
            '%s?%s=%s&%s=%s',
            static::URL_INDEX_ACTION,
            static::FIELD_SKU,
            $sku,
            static::FIELD_NAME,
            $name
        );
    }
}