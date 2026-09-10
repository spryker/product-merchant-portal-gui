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

interface ProductMerchantPortalGuiToProductFacadeInterface
{
    /**
     * @throws \Spryker\Zed\Product\Business\Exception\ProductAbstractExistsException
     */
    public function saveProductAbstract(ProductAbstractTransfer $productAbstractTransfer): int;

    /**
     * @throws \Spryker\Zed\Product\Business\Exception\ProductConcreteExistsException
     */
    public function saveProductConcrete(ProductConcreteTransfer $productConcreteTransfer): int;

    public function activateProductConcrete(int $idProductConcrete): void;

    public function deactivateProductConcrete(int $idProductConcrete): void;

    public function hasProductAbstract(string $sku): bool;

    public function hasProductConcrete(string $sku): bool;

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteCollection
     *
     * @throws \Spryker\Zed\Product\Business\Exception\ProductAbstractExistsException
     * @throws \Spryker\Zed\Product\Business\Exception\ProductConcreteExistsException
     */
    public function addProduct(ProductAbstractTransfer $productAbstractTransfer, array $productConcreteCollection): int;

    public function findProductAbstractIdByConcreteId(int $idConcrete): ?int;

    public function findProductAbstractById(int $idProductAbstract): ?ProductAbstractTransfer;

    public function findProductConcreteById(int $idProduct): ?ProductConcreteTransfer;

    /**
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getProductConcretesByCriteria(ProductCriteriaTransfer $productCriteriaTransfer): array;

    public function createProductConcreteCollection(
        ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
    ): void;

    /**
     * @param array<string> $productAbstractSkus
     *
     * @return array<\Generated\Shared\Transfer\ProductAbstractTransfer>
     */
    public function getRawProductAbstractTransfersByAbstractSkus(array $productAbstractSkus): array;
}
