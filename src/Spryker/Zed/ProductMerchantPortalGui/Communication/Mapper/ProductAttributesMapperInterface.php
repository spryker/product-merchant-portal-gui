<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Mapper;

use ArrayObject;
use Symfony\Component\Form\FormErrorIterator;

interface ProductAttributesMapperInterface
{
    /**
     * @param \Symfony\Component\Form\FormErrorIterator $errors
     * @param array $attributesInitialData
     *
     * @return string[][]
     */
    public function mapErrorsToAttributesData(FormErrorIterator $errors, array $attributesInitialData): array;

    /**
     * @param string[][][] $attributesInitialData
     * @param string[] $attributes
     *
     * @return string[]
     */
    public function mapAttributesDataToProductAttributes(array $attributesInitialData, array $attributes): array;

    /**
     * @phpstan-param ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $localizedAttributesTransfers
     *
     * @phpstan-return ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer>
     *
     * @param string[][][] $attributesInitialData
     * @param \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[] $localizedAttributesTransfers
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[]
     */
    public function mapAttributesDataToLocalizedAttributesTransfers(array $attributesInitialData, ArrayObject $localizedAttributesTransfers): ArrayObject;

    /**
     * @phpstan-param ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $destinationLocalizedAttributesTransfers
     * @phpstan-param ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $sourceLocalizedAttributesTransfers
     *
     * @phpstan-return ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer>
     *
     * @param \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[] $destinationLocalizedAttributesTransfers
     * @param \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[] $sourceLocalizedAttributesTransfers
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[]
     */
    public function mapLocalizedAttributesNames(
        ArrayObject $destinationLocalizedAttributesTransfers,
        ArrayObject $sourceLocalizedAttributesTransfers
    ): ArrayObject;

    /**
     * @phpstan-param ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $destinationLocalizedAttributesTransfers
     * @phpstan-param ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer> $sourceLocalizedAttributesTransfers
     *
     * @phpstan-return ArrayObject<int, \Generated\Shared\Transfer\LocalizedAttributesTransfer>
     *
     * @param \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[] $destinationLocalizedAttributesTransfers
     * @param \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[] $sourceLocalizedAttributesTransfers
     *
     * @return \ArrayObject|\Generated\Shared\Transfer\LocalizedAttributesTransfer[]
     */
    public function mapLocalizedDescriptions(
        ArrayObject $destinationLocalizedAttributesTransfers,
        ArrayObject $sourceLocalizedAttributesTransfers
    ): ArrayObject;
}