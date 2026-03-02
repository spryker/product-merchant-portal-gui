<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProductTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ValidationResponseTransfer;

class ProductMerchantPortalGuiToMerchantProductFacadeBridge implements ProductMerchantPortalGuiToMerchantProductFacadeInterface
{
    /**
     * @var \Spryker\Zed\MerchantProduct\Business\MerchantProductFacadeInterface
     */
    protected $merchantProductFacade;

    /**
     * @param \Spryker\Zed\MerchantProduct\Business\MerchantProductFacadeInterface $merchantProductFacade
     */
    public function __construct($merchantProductFacade)
    {
        $this->merchantProductFacade = $merchantProductFacade;
    }

    public function findMerchantProduct(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ?MerchantProductTransfer {
        return $this->merchantProductFacade->findMerchantProduct($merchantProductCriteriaTransfer);
    }

    public function validateMerchantProduct(MerchantProductTransfer $merchantProductTransfer): ValidationResponseTransfer
    {
        return $this->merchantProductFacade->validateMerchantProduct($merchantProductTransfer);
    }

    public function getProductConcreteCollection(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ProductConcreteCollectionTransfer {
        return $this->merchantProductFacade->getProductConcreteCollection($merchantProductCriteriaTransfer);
    }

    public function findProductConcrete(
        MerchantProductCriteriaTransfer $merchantProductCriteriaTransfer
    ): ?ProductConcreteTransfer {
        return $this->merchantProductFacade->findProductConcrete($merchantProductCriteriaTransfer);
    }

    public function isProductConcreteOwnedByMerchant(
        ProductConcreteTransfer $productConcreteTransfer,
        MerchantTransfer $merchantTransfer
    ): bool {
        return $this->merchantProductFacade->isProductConcreteOwnedByMerchant($productConcreteTransfer, $merchantTransfer);
    }

    public function isProductAbstractOwnedByMerchant(
        ProductAbstractTransfer $productAbstractTransfer,
        MerchantTransfer $merchantTransfer
    ): bool {
        return $this->merchantProductFacade->isProductAbstractOwnedByMerchant($productAbstractTransfer, $merchantTransfer);
    }
}
