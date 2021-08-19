<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper;

use ArrayObject;
use Generated\Shared\Transfer\MoneyValueTransfer;
use Generated\Shared\Transfer\PaginationTransfer;
use Generated\Shared\Transfer\PriceProductTableViewCollectionTransfer;
use Generated\Shared\Transfer\PriceProductTableViewTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToStoreFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToUtilEncodingServiceInterface;

class PriceProductTableDataMapper implements PriceProductTableDataMapperInterface
{
    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface
     */
    protected $priceProductFacade;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @var \Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToUtilEncodingServiceInterface
     */
    protected $utilEncodingService;

    /**
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToPriceProductFacadeInterface $priceProductFacade
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToStoreFacadeInterface $storeFacade
     * @param \Spryker\Zed\ProductMerchantPortalGui\Dependency\Service\ProductMerchantPortalGuiToUtilEncodingServiceInterface $utilEncodingService
     */
    public function __construct(
        ProductMerchantPortalGuiToPriceProductFacadeInterface $priceProductFacade,
        ProductMerchantPortalGuiToStoreFacadeInterface $storeFacade,
        ProductMerchantPortalGuiToUtilEncodingServiceInterface $utilEncodingService
    ) {
        $this->priceProductFacade = $priceProductFacade;
        $this->storeFacade = $storeFacade;
        $this->utilEncodingService = $utilEncodingService;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer[] $priceProductTransfers
     * @param \Generated\Shared\Transfer\PriceProductTableViewCollectionTransfer $priceProductTableViewCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTableViewCollectionTransfer
     */
    public function mapPriceProductTransfersToPriceProductTableViewCollectionTransfer(
        array $priceProductTransfers,
        PriceProductTableViewCollectionTransfer $priceProductTableViewCollectionTransfer
    ): PriceProductTableViewCollectionTransfer {
        $priceTypeTransfers = $this->priceProductFacade->getPriceTypeValues();

        $priceProductTableViewTransfers = [];

        $storeTransfers = $this->getStoreTransfers();

        foreach ($priceProductTransfers as $priceProductTransfer) {
            $priceProductTransfer
                ->getMoneyValueOrFail()
                ->setStore($storeTransfers[$priceProductTransfer->getMoneyValueOrFail()->getFkStoreOrFail()]);

            $rowKey = $this->createPriceProductTableRowKeyByPriceProductTransfer($priceProductTransfer);

            if (!array_key_exists($rowKey, $priceProductTableViewTransfers)) {
                $priceProductTableViewTransfers[$rowKey] = $this->mapPriceProductTransferToPriceProductTableViewTransfer(
                    $priceProductTransfer,
                    new PriceProductTableViewTransfer()
                );
            }

            $priceProductTableViewTransfer = $priceProductTableViewTransfers[$rowKey];

            $storeIds = $this->getEncodedStoreIds($priceProductTableViewTransfer, $priceProductTransfer);
            $defaultIds = $this->getEncodedDefaultIds($priceProductTableViewTransfer, $priceProductTransfer);

            $prices = array_merge(
                $priceProductTableViewTransfer->getPrices(),
                $this->preparePrices($priceProductTransfer, $priceTypeTransfers)
            );

            $priceProductTableViewTransfer
                ->setTypePriceProductStoreIds($storeIds)
                ->setPriceProductDefaultIds($defaultIds)
                ->setPrices($prices);
        }

        $priceProductTableViewTransfers = $this->updateStoreAndDefaultIdsForVolumePrices($priceProductTableViewTransfers);

        $priceProductTableViewCollectionTransfer
            ->setPagination($this->createPaginationTransfer($priceProductTableViewTransfers))
            ->setPriceProductTableViews(new ArrayObject($priceProductTableViewTransfers));

        return $priceProductTableViewCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param \Generated\Shared\Transfer\PriceProductTableViewTransfer $priceProductTableViewTransfer
     *
     * @return \Generated\Shared\Transfer\PriceProductTableViewTransfer
     */
    protected function mapPriceProductTransferToPriceProductTableViewTransfer(
        PriceProductTransfer $priceProductTransfer,
        PriceProductTableViewTransfer $priceProductTableViewTransfer
    ): PriceProductTableViewTransfer {
        return $priceProductTableViewTransfer
            ->setIdProductAbstract($priceProductTransfer->getIdProductAbstract())
            ->setIdProductConcrete($priceProductTransfer->getIdProduct())
            ->setVolumeQuantity($priceProductTransfer->getVolumeQuantity() ?? 1)
            ->setCurrency($priceProductTransfer->getMoneyValueOrFail()->getCurrencyOrFail()->getCodeOrFail())
            ->setStore($priceProductTransfer->getMoneyValueOrFail()->getStoreOrFail()->getNameOrFail());
    }

    /**
     * @phpstan-param array<\Generated\Shared\Transfer\PriceTypeTransfer> $priceTypeTransfers
     *
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     * @param \Generated\Shared\Transfer\PriceTypeTransfer[] $priceTypeTransfers
     *
     * @return mixed[]
     */
    protected function preparePrices(PriceProductTransfer $priceProductTransfer, array $priceTypeTransfers): array
    {
        $prices = [];

        foreach ($priceTypeTransfers as $priceTypeTransfer) {
            $priceTypeName = mb_strtolower($priceTypeTransfer->getNameOrFail());
            $priceTypeNameFromTransfer = mb_strtolower($priceProductTransfer->getPriceTypeOrFail()->getNameOrFail());

            if ($priceTypeName !== $priceTypeNameFromTransfer) {
                continue;
            }

            $moneyValueTransfer = $priceProductTransfer->getMoneyValueOrFail();

            if ($moneyValueTransfer->getGrossAmount() !== null) {
                $prices[$this->createGrossKey($priceTypeName)] = $moneyValueTransfer->getGrossAmount();
            }

            if ($moneyValueTransfer->getNetAmount() !== null) {
                $prices[$this->createNetKey($priceTypeName)] = $moneyValueTransfer->getNetAmount();
            }
        }

        return $prices;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return string
     */
    protected function createPriceProductTableRowKeyByPriceProductTransfer(
        PriceProductTransfer $priceProductTransfer
    ): string {
        return $this->createPriceProductTableRowKey(
            $priceProductTransfer->getMoneyValueOrFail()->getStoreOrFail()->getNameOrFail(),
            $priceProductTransfer->getMoneyValueOrFail()->getCurrencyOrFail()->getCodeOrFail(),
            $priceProductTransfer->getVolumeQuantity() ?? 1
        );
    }

    /**
     * @param string $storeName
     * @param string $currencyCode
     * @param int $volumeQuantity
     *
     * @return string
     */
    protected function createPriceProductTableRowKey(string $storeName, string $currencyCode, int $volumeQuantity): string
    {
        return sprintf('%s-%s-%d', $storeName, $currencyCode, $volumeQuantity);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTableViewTransfer[] $priceProductTableViewTransfers
     *
     * @return \Generated\Shared\Transfer\PaginationTransfer
     */
    protected function createPaginationTransfer(array $priceProductTableViewTransfers): PaginationTransfer
    {
        $tableViewCount = count($priceProductTableViewTransfers);

        return (new PaginationTransfer())
            ->setFirstPage(1)
            ->setNbResults($tableViewCount);
    }

    /**
     * @param string $pryceTypeName
     *
     * @return string
     */
    protected function createGrossKey(string $pryceTypeName): string
    {
        return sprintf(
            '%s[%s][%s]',
            $pryceTypeName,
            PriceProductTransfer::MONEY_VALUE,
            MoneyValueTransfer::GROSS_AMOUNT
        );
    }

    /**
     * @param string $pryceTypeName
     *
     * @return string
     */
    protected function createNetKey(string $pryceTypeName): string
    {
        return sprintf(
            '%s[%s][%s]',
            $pryceTypeName,
            PriceProductTransfer::MONEY_VALUE,
            MoneyValueTransfer::NET_AMOUNT
        );
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer[]
     */
    protected function getStoreTransfers(): array
    {
        $indexedStores = [];

        $stores = $this->storeFacade->getAllStores();
        foreach ($stores as $store) {
            $indexedStores[$store->getIdStoreOrFail()] = $store;
        }

        return $indexedStores;
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTableViewTransfer $priceProductTableViewTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return string|null
     */
    protected function getEncodedStoreIds(
        PriceProductTableViewTransfer $priceProductTableViewTransfer,
        PriceProductTransfer $priceProductTransfer
    ): ?string {
        $existingStoreIds = $this->utilEncodingService->decodeJson(
            (string)$priceProductTableViewTransfer->getTypePriceProductStoreIds(),
            true
        );
        $existingStoreIds[] = $priceProductTransfer
            ->getMoneyValueOrFail()
            ->getIdEntityOrFail();
        $existingStoreIds = array_filter($existingStoreIds);

        return $this->utilEncodingService->encodeJson($existingStoreIds);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTableViewTransfer $priceProductTableViewTransfer
     * @param \Generated\Shared\Transfer\PriceProductTransfer $priceProductTransfer
     *
     * @return string|null
     */
    protected function getEncodedDefaultIds(
        PriceProductTableViewTransfer $priceProductTableViewTransfer,
        PriceProductTransfer $priceProductTransfer
    ): ?string {
        $existingDefaultIds = $this->utilEncodingService->decodeJson(
            (string)$priceProductTableViewTransfer->getPriceProductDefaultIds(),
            true
        );

        if ($existingDefaultIds === null) {
            $existingDefaultIds = [];
        }

        if (
            $priceProductTransfer
            ->getPriceDimensionOrFail()
            ->getIdPriceProductDefault()
        ) {
            $existingDefaultIds[] = $priceProductTransfer
                ->getPriceDimensionOrFail()
                ->getIdPriceProductDefaultOrFail();
            $existingDefaultIds = array_unique($existingDefaultIds);
        }

        return $this->utilEncodingService->encodeJson($existingDefaultIds);
    }

    /**
     * @param \Generated\Shared\Transfer\PriceProductTableViewTransfer[] $priceProductTableViewTransfers
     *
     * @return \Generated\Shared\Transfer\PriceProductTableViewTransfer[]
     */
    protected function updateStoreAndDefaultIdsForVolumePrices(array $priceProductTableViewTransfers): array
    {
        foreach ($priceProductTableViewTransfers as $priceProductTableViewTransfer) {
            if ($priceProductTableViewTransfer->getVolumeQuantity() <= 1) {
                continue;
            }

            $rowKey = $this->createPriceProductTableRowKey(
                $priceProductTableViewTransfer->getStoreOrFail(),
                $priceProductTableViewTransfer->getCurrencyOrFail(),
                1
            );

            if (!isset($priceProductTableViewTransfers[$rowKey])) {
                continue;
            }

            $basePriceProductTableViewTransfer = $priceProductTableViewTransfers[$rowKey];

            $priceProductTableViewTransfer
                ->setTypePriceProductStoreIds($basePriceProductTableViewTransfer->getTypePriceProductStoreIdsOrFail())
                ->setPriceProductDefaultIds($basePriceProductTableViewTransfer->getPriceProductDefaultIdsOrFail());
        }

        return $priceProductTableViewTransfers;
    }
}