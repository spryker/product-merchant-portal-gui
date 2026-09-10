<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade;

use Generated\Shared\Transfer\LocaleCriteriaTransfer;
use Generated\Shared\Transfer\LocaleTransfer;

interface ProductMerchantPortalGuiToLocaleFacadeInterface
{
    public function getCurrentLocale(): LocaleTransfer;

    /**
     * Locale names, e.g. "de_DE".
     *
     * @return array<string>
     */
    public function getAvailableLocales(): array;

    /**
     * @throws \Spryker\Zed\Locale\Business\Exception\MissingLocaleException
     */
    public function getLocale(string $localeName): LocaleTransfer;

    /**
     * Optionally scoped by the criteria's store names.
     *
     * @return array<\Generated\Shared\Transfer\LocaleTransfer>
     */
    public function getLocaleCollection(?LocaleCriteriaTransfer $localeCriteriaTransfer = null): array;

    /**
     * @throws \Spryker\Zed\Locale\Business\Exception\MissingLocaleException
     */
    public function getLocaleById(int $idLocale): LocaleTransfer;
}
