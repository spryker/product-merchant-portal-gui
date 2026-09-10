<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Matcher;

use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PriceProductTableViewTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Creator\PriceProductTableColumnCreatorInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMoneyFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductVolumeFacadeInterface;

class PriceProductTableRowMatcher implements PriceProductTableRowMatcherInterface
{
    /**
     * @uses \Spryker\Shared\PriceProductOfferVolume\PriceProductOfferVolumeConfig::VOLUME_PRICE_TYPE
     *
     * @var string
     */
    protected const VOLUME_PRICE_TYPE = 'volume_prices';

    protected PriceProductTableColumnCreatorInterface $priceProductTableColumnCreator;

    protected ProductMerchantPortalGuiToPriceProductVolumeFacadeInterface $priceProductVolumeFacade;

    protected ProductMerchantPortalGuiToMoneyFacadeInterface $moneyFacade;

    public function __construct(
        PriceProductTableColumnCreatorInterface $priceProductTableColumnCreator,
        ProductMerchantPortalGuiToPriceProductVolumeFacadeInterface $priceProductVolumeFacade,
        ProductMerchantPortalGuiToMoneyFacadeInterface $moneyFacade
    ) {
        $this->priceProductTableColumnCreator = $priceProductTableColumnCreator;
        $this->priceProductVolumeFacade = $priceProductVolumeFacade;
        $this->moneyFacade = $moneyFacade;
    }

    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    public function isPriceProductInRow(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): bool {
        return $this->isSameStoreId($initialDataRow, $priceProductTransfer)
            && $this->isSameCurrencyId($initialDataRow, $priceProductTransfer)
            && $this->isSameNetPrice($initialDataRow, $priceProductTransfer, $propertyPath)
            && $this->isSameGrossPrice($initialDataRow, $priceProductTransfer, $propertyPath)
            && $this->isSameVolumeQuantity($initialDataRow, $priceProductTransfer, $propertyPath);
    }

    /**
     * @param array<mixed> $initialDataRow
     */
    protected function isSameStoreId(array $initialDataRow, PriceProductTransfer $priceProductTransfer): bool
    {
        $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();

        $initialStore = $initialDataRow[PriceProductTableViewTransfer::STORE] ?: null;

        return $initialStore === $moneyValueTransfer->getFkStore();
    }

    /**
     * @param array<mixed> $initialDataRow
     */
    protected function isSameCurrencyId(array $initialDataRow, PriceProductTransfer $priceProductTransfer): bool
    {
        $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();

        $initialCurrency = $initialDataRow[PriceProductTableViewTransfer::CURRENCY] ?: null;

        return $initialCurrency === $moneyValueTransfer->getFkCurrency();
    }

    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    protected function isSameNetPrice(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): bool {
        $priceTypeName = $priceProductTransfer->getPriceTypeOrFail()->getNameOrFail();
        $netPriceColumnId = $this->priceProductTableColumnCreator
            ->createPriceColumnId($priceTypeName, MoneyValueTransfer::NET_AMOUNT);
        $initialNetPrice = $this->convertDecimalToInteger($initialDataRow[$netPriceColumnId]);

        $initialVolumeQuantity = $initialDataRow[PriceProductTableViewTransfer::VOLUME_QUANTITY];
        if ($initialVolumeQuantity === 1 && isset($propertyPath[4])) {
            return false;
        }

        $volumePriceProductTransfer = $this->getVolumePriceProductTransfer(
            $initialDataRow,
            $priceProductTransfer,
            $propertyPath,
        );

        if ($volumePriceProductTransfer !== null) {
            $priceProductTransfer = $volumePriceProductTransfer;
        }

        $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();

        return $initialNetPrice === $moneyValueTransfer->getNetAmount();
    }

    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    protected function isSameGrossPrice(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): bool {
        $priceTypeName = $priceProductTransfer->getPriceTypeOrFail()->getNameOrFail();
        $grossPriceColumnId = $this->priceProductTableColumnCreator
            ->createPriceColumnId($priceTypeName, MoneyValueTransfer::GROSS_AMOUNT);
        $initialGrossPrice = $this->convertDecimalToInteger($initialDataRow[$grossPriceColumnId]);

        $initialVolumeQuantity = $initialDataRow[PriceProductTableViewTransfer::VOLUME_QUANTITY];
        if ($initialVolumeQuantity === 1 && isset($propertyPath[4])) {
            return false;
        }

        $volumePriceProductTransfer = $this->getVolumePriceProductTransfer(
            $initialDataRow,
            $priceProductTransfer,
            $propertyPath,
        );

        if ($volumePriceProductTransfer !== null) {
            $priceProductTransfer = $volumePriceProductTransfer;
        }

        $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();

        return $initialGrossPrice === $moneyValueTransfer->getGrossAmount();
    }

    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    protected function isSameVolumeQuantity(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): bool {
        $initialVolumeQuantity = $initialDataRow[PriceProductTableViewTransfer::VOLUME_QUANTITY] ?: 1;

        $volumePriceProductTransfer = $this->getVolumePriceProductTransfer(
            $initialDataRow,
            $priceProductTransfer,
            $propertyPath,
        );

        if ($volumePriceProductTransfer !== null) {
            $priceProductTransfer = $volumePriceProductTransfer;
        }

        return (int)$initialVolumeQuantity === (int)$priceProductTransfer->getVolumeQuantity();
    }

    /**
     * @param mixed $value
     */
    protected function convertDecimalToInteger($value): ?int
    {
        if ($value === '' || $value === null) {
            return null;
        }

        return $this->moneyFacade->convertDecimalToInteger((float)$value);
    }

    /**
     * @param array<mixed> $initialDataRow
     * @param array<string> $propertyPath
     */
    protected function getVolumePriceProductTransfer(
        array $initialDataRow,
        PriceProductTransfer $priceProductTransfer,
        array $propertyPath
    ): ?PriceProductTransfer {
        $initialVolumeQuantity = $initialDataRow[PriceProductTableViewTransfer::VOLUME_QUANTITY];

        if ($initialVolumeQuantity !== 1 && isset($propertyPath[4])) {
            $volumePriceIndex = (int)$propertyPath[4];
            $volumePriceProductTransfers = $this->priceProductVolumeFacade
                ->extractPriceProductVolumeTransfersFromArray([$priceProductTransfer]);

            if (!isset($volumePriceProductTransfers[$volumePriceIndex])) {
                return null;
            }

            return $volumePriceProductTransfers[$volumePriceIndex];
        }

        return null;
    }
}
