<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Controller;

use ArrayObject;
use Generated\Shared\Transfer\PriceProductCriteriaTransfer;
use Generated\Shared\Transfer\PriceProductTableViewTransfer;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Persistence\ProductMerchantPortalGuiRepositoryInterface getRepository()
 */
class SavePriceProductConcreteController extends SavePriceProductController
{
    /**
     * @param \ArrayObject|\Generated\Shared\Transfer\PriceProductTransfer[] $priceProductTransfers
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\PriceProductTransfer[]
     */
    protected function expandPriceProductTransfersWithProductId(ArrayObject $priceProductTransfers, $request): ArrayObject
    {
        foreach ($priceProductTransfers as $priceProductTransfer) {
            $priceProductTransfer->setIdProduct(
                $request->get(PriceProductTableViewTransfer::ID_PRODUCT_CONCRETE)
            );
        }

        return $priceProductTransfers;
    }

    /**
     * @param int[] $priceProductStoreIds
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Generated\Shared\Transfer\PriceProductTransfer[]
     */
    protected function findPriceProductTransfers(array $priceProductStoreIds, Request $request): array
    {
        $idProductConcrete = $request->get(PriceProductTableViewTransfer::ID_PRODUCT_CONCRETE);
        $priceProductCriteriaTransfer = (new PriceProductCriteriaTransfer())->setPriceProductStoreIds($priceProductStoreIds);

        return array_values($this->getFactory()
            ->getPriceProductFacade()
            ->findProductConcretePricesWithoutPriceExtraction(
                $idProductConcrete,
                $this->getFactory()->getProductFacade()->findProductAbstractIdByConcreteId($idProductConcrete),
                $priceProductCriteriaTransfer
            ));
    }
}
