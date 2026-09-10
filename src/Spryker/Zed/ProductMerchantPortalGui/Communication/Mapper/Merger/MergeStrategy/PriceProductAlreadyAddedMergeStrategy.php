<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper\Merger\MergeStrategy;

use ArrayObject;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;

class PriceProductAlreadyAddedMergeStrategy extends AbstractPriceProductMergeStrategy
{
    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    public function isApplicable(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): bool {
        return !$this->isVolumePriceProduct($newPriceProductTransfer)
            && $this->isNewPriceAlreadyAddedToList($newPriceProductTransfer, $priceProductTransfers)
            && $this->hasMergeablePrices($newPriceProductTransfer, $priceProductTransfers);
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     *
     * @return \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer>
     */
    public function merge(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): ArrayObject {
        foreach ($priceProductTransfers as $priceProductTransfer) {
            if (
                $this->isNewPriceProductTransfer($priceProductTransfer)
                && $this->isSamePriceProduct($priceProductTransfer, $newPriceProductTransfer)
                && $this->isMergeablePrices($newPriceProductTransfer, $priceProductTransfer)
            ) {
                $newMoneyValueTransfer = $newPriceProductTransfer->getMoneyValueOrFail();

                $priceProductTransfer->setVolumeQuantity(1);
                $priceProductTransfer
                    ->getMoneyValueOrFail()
                    ->setGrossAmount($newMoneyValueTransfer->getGrossAmount())
                    ->setNetAmount($newMoneyValueTransfer->getNetAmount());

                return $priceProductTransfers;
            }
        }

        return $priceProductTransfers;
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    protected function isNewPriceAlreadyAddedToList(
        PriceProductTransfer $newPriceProductTransfer,
        ArrayObject $priceProductTransfers
    ): bool {
        foreach ($priceProductTransfers as $priceProductTransfer) {
            if (
                $this->isNewPriceProductTransfer($priceProductTransfer)
                && $this->isSamePriceProduct($priceProductTransfer, $newPriceProductTransfer)
            ) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \ArrayObject<int, \Generated\Shared\Transfer\PriceProductTransfer> $priceProductTransfers
     */
    protected function hasMergeablePrices(
        PriceProductTransfer $priceProductTransfer,
        ArrayObject $priceProductTransfers
    ): bool {
        foreach ($priceProductTransfers as $priceProductToCompareTransfer) {
            if ($this->isMergeablePrices($priceProductTransfer, $priceProductToCompareTransfer)) {
                return true;
            }
        }

        return false;
    }

    protected function isMergeablePrices(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTransfer $priceProductToCompareTransfer
    ): bool {
        if (!$this->isSamePriceProduct($priceProductTransfer, $priceProductToCompareTransfer)) {
            return false;
        }

        $moneyValueTransfer = $priceProductTransfer->getMoneyValue();
        $moneyValueToCompareTransfer = $priceProductToCompareTransfer->getMoneyValue();
        if (!$moneyValueTransfer || !$moneyValueToCompareTransfer) {
            return false;
        }

        return $this->hasMergeableNetPrice($moneyValueTransfer, $moneyValueToCompareTransfer)
            || $this->hasMergeableGrossPrice($moneyValueTransfer, $moneyValueToCompareTransfer);
    }

    protected function hasMergeableNetPrice(
        MoneyValueTransfer $moneyValueTransfer,
        MoneyValueTransfer $moneyValueToCompareTransfer
    ): bool {
        if ($moneyValueTransfer->getNetAmount() && !$moneyValueToCompareTransfer->getNetAmount()) {
            return true;
        }

        return !$moneyValueTransfer->getNetAmount() && $moneyValueToCompareTransfer->getNetAmount();
    }

    protected function hasMergeableGrossPrice(
        MoneyValueTransfer $moneyValueTransfer,
        MoneyValueTransfer $moneyValueToCompareTransfer
    ): bool {
        if ($moneyValueTransfer->getGrossAmount() && !$moneyValueToCompareTransfer->getGrossAmount()) {
            return true;
        }

        return !$moneyValueTransfer->getGrossAmount() && $moneyValueToCompareTransfer->getGrossAmount();
    }
}
