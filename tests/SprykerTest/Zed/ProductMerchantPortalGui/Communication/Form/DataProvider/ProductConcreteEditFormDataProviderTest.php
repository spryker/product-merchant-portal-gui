<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\Form\DataProvider;

use ArrayObject;
use Codeception\Stub;
use Codeception\Test\Unit;
use Generated\Shared\DataBuilder\MerchantUserBuilder;
use Generated\Shared\DataBuilder\StoreRelationBuilder;
use Generated\Shared\Transfer\LocaleCriteriaTransfer;
use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Generated\Shared\Transfer\PriceProductTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\DataProvider\ProductConcreteEditFormDataProvider;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToLocaleFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToMerchantProductFacadeInterface;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductMerchantPortalGui
 * @group Communication
 * @group Form
 * @group DataProvider
 * @group ProductConcreteEditFormDataProviderTest
 * Add your own group annotations below this line
 */
class ProductConcreteEditFormDataProviderTest extends Unit
{
    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\ProductConcreteEditForm::FIELD_USE_ABSTRACT_PRODUCT_PRICES
     *
     * @var string
     */
    protected const PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES = 'useAbstractProductPrices';

    /**
     * @var string
     */
    protected const OPTION_SEARCHABILITY_CHOICES = 'OPTION_SEARCHABILITY_CHOICES';

    /**
     * @var \SprykerTest\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiCommunicationTester
     */
    protected $tester;

    public function testGetOptionsShouldReturnOnlySearchabilityChoicesForLocalesOfMerchantAssignedStores(): void
    {
        // Arrange
        $merchantStoreTransfer = (new StoreTransfer())->setIdStore(1)->setName('DE');
        $storeRelationTransfer = (new StoreRelationBuilder())
            ->withStores($merchantStoreTransfer->toArray())
            ->build();

        $merchantUserTransfer = (new MerchantUserBuilder())
            ->withMerchant([
                MerchantTransfer::ID_MERCHANT => 1,
                MerchantTransfer::STORE_RELATION => $storeRelationTransfer,
            ])
            ->build();

        $merchantUserFacadeMock = $this->tester->createMerchantUserFacadeMock([
            'getCurrentMerchantUser' => function () use ($merchantUserTransfer) {
                return $merchantUserTransfer;
            },
        ]);

        $merchantStoreLocaleTransfer = (new LocaleTransfer())->setIdLocale(46)->setLocaleName('de_DE');
        $otherStoreLocaleTransfer = (new LocaleTransfer())->setIdLocale(203)->setLocaleName('tr_TR');

        $localeFacadeMock = Stub::makeEmpty(
            ProductMerchantPortalGuiToLocaleFacadeInterface::class,
            [
                'getLocaleCollection' => function (?LocaleCriteriaTransfer $localeCriteriaTransfer = null) use ($merchantStoreLocaleTransfer, $otherStoreLocaleTransfer) {
                    $storeNames = $localeCriteriaTransfer?->getLocaleConditions()?->getStoreNames() ?? [];

                    if ($storeNames === ['DE']) {
                        return [$merchantStoreLocaleTransfer];
                    }

                    return [$merchantStoreLocaleTransfer, $otherStoreLocaleTransfer];
                },
            ],
        );

        $productConcreteEditFormDataProvider = new ProductConcreteEditFormDataProvider(
            $merchantUserFacadeMock,
            Stub::makeEmpty(ProductMerchantPortalGuiToMerchantProductFacadeInterface::class),
            $localeFacadeMock,
            Stub::makeEmpty(ProductMerchantPortalGuiToProductFacadeInterface::class),
            $this->tester->getFactory()->createProductAttributeDataProvider(),
            $this->tester->createPriceProductReader($this->tester->createPriceProductFacadeMock()),
        );

        // Act
        $options = $productConcreteEditFormDataProvider->getOptions();

        // Assert
        $this->assertCount(1, $options[static::OPTION_SEARCHABILITY_CHOICES]);
        $this->assertArrayHasKey('de_DE', $options[static::OPTION_SEARCHABILITY_CHOICES]);
        $this->assertSame(
            $merchantStoreLocaleTransfer->getIdLocaleOrFail(),
            $options[static::OPTION_SEARCHABILITY_CHOICES]['de_DE'],
            'Choice value must be the real idLocale (matched against LocalizedAttributesTransfer::getIdLocale() by the searchability transformer), not a positional array index.',
        );
    }

    public function testGetDataWillSetUseAbstractProductPricesToFalseWhenProductHasDefaultAndMerchantPriceForConcreteProduct(): void
    {
        // Arrange
        $merchantProductFacadeMock = $this->tester->createMerchantProductFacadeMock(
            [
                'findProductConcrete' => function () {
                    return (new ProductConcreteTransfer())
                        ->setIdProductConcrete(1)
                        ->setFkProductAbstract(1)
                        ->setPrices((new ArrayObject([new PriceProductTransfer()])));
                },
            ],
        );
        $priceProductFacadeMock = $this->tester->createProductMerchantPortalGuiToPriceProductFacadeMock(
            [
                'findProductConcretePricesWithoutPriceExtraction' => function () {
                    return [new PriceProductTransfer()];
                },
            ],
        );
        $productConcreteEditFormDataProvider = $this->tester->createProductConcreteEditFormDataProvider(
            $merchantProductFacadeMock,
            $priceProductFacadeMock,
        );

        // Act
        $data = $productConcreteEditFormDataProvider->getData(1);

        // Assert
        $this->assertFalse(
            $data[static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES],
            static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES
                . ' should be false when product has default and merchant prices.',
        );
    }

    public function testGetDataWillSetUseAbstractProductPricesToFalseWhenProductHasDefaultAndNoMerchantPriceForConcreteProduct(): void
    {
        // Arrange
        $merchantProductFacadeMock = $this->tester->createMerchantProductFacadeMock(
            [
                'findProductConcrete' => function () {
                    return (new ProductConcreteTransfer())
                        ->setIdProductConcrete(1)
                        ->setFkProductAbstract(1)
                        ->setPrices((new ArrayObject([new PriceProductTransfer()])));
                },
            ],
        );
        $priceProductFacadeMock = $this->tester->createProductMerchantPortalGuiToPriceProductFacadeMock(
            [
                'findProductConcretePricesWithoutPriceExtraction' => function () {
                    return [];
                },
            ],
        );
        $productConcreteEditFormDataProvider = $this->tester->createProductConcreteEditFormDataProvider(
            $merchantProductFacadeMock,
            $priceProductFacadeMock,
        );

        // Act
        $data = $productConcreteEditFormDataProvider->getData(1);

        // Assert
        $this->assertFalse(
            $data[static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES],
            static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES
                . ' should be false when product has default prices.',
        );
    }

    public function testGetDataWillSetUseAbstractProductPricesToFalseWhenProductHasMerchantAndNoDefaultPriceForConcreteProduct(): void
    {
        // Arrange
        $merchantProductFacadeMock = $this->tester->createMerchantProductFacadeMock(
            [
                'findProductConcrete' => function () {
                    return (new ProductConcreteTransfer())
                        ->setIdProductConcrete(1)
                        ->setFkProductAbstract(1);
                },
            ],
        );
        $priceProductFacadeMock = $this->tester->createProductMerchantPortalGuiToPriceProductFacadeMock(
            [
                'findProductConcretePricesWithoutPriceExtraction' => function () {
                    return [new PriceProductTransfer()];
                },
            ],
        );
        $productConcreteEditFormDataProvider = $this->tester->createProductConcreteEditFormDataProvider(
            $merchantProductFacadeMock,
            $priceProductFacadeMock,
        );

        // Act
        $data = $productConcreteEditFormDataProvider->getData(1);

        // Assert
        $this->assertFalse(
            $data[static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES],
            static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES
                . ' should be false when product has merchant prices.',
        );
    }

    public function testGetDataWillSetUseAbstractProductPricesToTrueWhenProductHasNoMerchantAndNoDefaultPriceForConcreteProduct(): void
    {
        // Arrange
        $merchantProductFacadeMock = $this->tester->createMerchantProductFacadeMock(
            [
                'findProductConcrete' => function () {
                    return (new ProductConcreteTransfer())
                        ->setIdProductConcrete(1)
                        ->setFkProductAbstract(1);
                },
            ],
        );
        $priceProductFacadeMock = $this->tester->createProductMerchantPortalGuiToPriceProductFacadeMock(
            [
                'findProductConcretePricesWithoutPriceExtraction' => function () {
                    return [];
                },
            ],
        );
        $productConcreteEditFormDataProvider = $this->tester->createProductConcreteEditFormDataProvider(
            $merchantProductFacadeMock,
            $priceProductFacadeMock,
        );

        // Act
        $data = $productConcreteEditFormDataProvider->getData(1);

        // Assert
        $this->assertTrue(
            $data[static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES],
            static::PRODUCT_CONCRETE_EDIT_FORM_FIELD_USE_ABSTRACT_PRODUCT_PRICES
                . ' should be true when product has no default and no merchant prices.',
        );
    }
}
