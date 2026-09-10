<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Expander;

use Generated\Shared\Transfer\MerchantStockCriteriaTransfer;
use Generated\Shared\Transfer\StockProductTransfer;
use Generated\Shared\Transfer\StockTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\DefaultMerchantStockNotFoundException;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMerchantStockFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMerchantUserFacadeInterface;

class ProductStockExpander implements ProductStockExpanderInterface
{
    protected ProductMerchantPortalGuiToMerchantStockFacadeInterface $merchantStockFacade;

    protected ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade;

    public function __construct(
        ProductMerchantPortalGuiToMerchantStockFacadeInterface $merchantStockFacade,
        ProductMerchantPortalGuiToMerchantUserFacadeInterface $merchantUserFacade
    ) {
        $this->merchantStockFacade = $merchantStockFacade;
        $this->merchantUserFacade = $merchantUserFacade;
    }

    /**
     * @param array<\Generated\Shared\Transfer\ProductConcreteTransfer> $productConcreteTransfers
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function expandProductConcreteTransfersWithDefaultMerchantProductStock(
        array $productConcreteTransfers
    ): array {
        $stockTransfer = $this->getStock();

        foreach ($productConcreteTransfers as $productConcreteTransfer) {
            $stockProductTransfer = (new StockProductTransfer())
                ->setQuantity(0)
                ->setStockType($stockTransfer->getNameOrFail())
                ->setFkStock($stockTransfer->getIdStockOrFail())
                ->setSku($productConcreteTransfer->getSkuOrFail());

            $productConcreteTransfer->addStock($stockProductTransfer);
        }

        return $productConcreteTransfers;
    }

    /**
     * @throws \Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\DefaultMerchantStockNotFoundException
     */
    protected function getStock(): StockTransfer
    {
        $idMerchant = $this->merchantUserFacade->getCurrentMerchantUser()
            ->getMerchantOrFail()
            ->getIdMerchantOrFail();

        $merchantStockCriteriaTransfer = (new MerchantStockCriteriaTransfer())
            ->setIsDefault(true)
            ->setIdMerchant($idMerchant);

        $stockTransfers = $this->merchantStockFacade->get($merchantStockCriteriaTransfer)->getStocks();

        if (!isset($stockTransfers[0])) {
            throw new DefaultMerchantStockNotFoundException($idMerchant);
        }

        return $stockTransfers[0];
    }
}
