<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\ProductCriteriaTransfer;

class ProductMerchantPortalGuiToProductFacadeBridge implements ProductMerchantPortalGuiToProductFacadeInterface
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @param \Spryker\Zed\Product\Business\ProductFacadeInterface $productFacade
     */
    public function __construct($productFacade)
    {
        $this->productFacade = $productFacade;
    }

    public function saveProductAbstract(ProductAbstractTransfer $productAbstractTransfer): int
    {
        return $this->productFacade->saveProductAbstract($productAbstractTransfer);
    }

    public function saveProductConcrete(ProductConcreteTransfer $productConcreteTransfer): int
    {
        return $this->productFacade->saveProductConcrete($productConcreteTransfer);
    }

    public function activateProductConcrete(int $idProductConcrete): void
    {
        $this->productFacade->activateProductConcrete($idProductConcrete);
    }

    public function deactivateProductConcrete(int $idProductConcrete): void
    {
        $this->productFacade->deactivateProductConcrete($idProductConcrete);
    }

    public function findProductAbstractIdByConcreteId(int $idConcrete): ?int
    {
        return $this->productFacade->findProductAbstractIdByConcreteId($idConcrete);
    }

    public function hasProductAbstract(string $sku): bool
    {
        return $this->productFacade->hasProductAbstract($sku);
    }

    public function hasProductConcrete(string $sku): bool
    {
        return $this->productFacade->hasProductConcrete($sku);
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteCollection
     */
    public function addProduct(ProductAbstractTransfer $productAbstractTransfer, array $productConcreteCollection): int
    {
        return $this->productFacade->addProduct($productAbstractTransfer, $productConcreteCollection);
    }

    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer
    {
        return $this->productFacade->findProductAbstractById($idProductAbstract);
    }

    public function findProductConcreteById(int $idProduct): ?ProductConcreteTransfer
    {
        return $this->productFacade->findProductConcreteById($idProduct);
    }

    /**
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getProductConcretesByCriteria(ProductCriteriaTransfer $productCriteriaTransfer): array
    {
        return $this->productFacade->getProductConcretesByCriteria($productCriteriaTransfer);
    }

    public function createProductConcreteCollection(
        ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
    ): void {
        $this->productFacade->createProductConcreteCollection($productConcreteCollectionTransfer);
    }

    /**
     * @param array<string> $productAbstractSkus
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractTransfer>
     */
    public function getRawProductAbstractTransfersByAbstractSkus(array $productAbstractSkus): array
    {
        return $this->productFacade->getRawProductAbstractTransfersByAbstractSkus($productAbstractSkus);
    }
}
