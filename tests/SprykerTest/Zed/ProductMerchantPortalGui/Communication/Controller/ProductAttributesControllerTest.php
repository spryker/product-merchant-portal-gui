<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\Controller;

use Codeception\Test\Unit;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAttributesController;
use Spryker\Zed\ProductMerchantPortalGui\Dependency\Facade\ProductMerchantPortalGuiToProductFacadeInterface;
use SprykerTest\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiCommunicationTester;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductMerchantPortalGui
 * @group Communication
 * @group Controller
 * @group ProductAttributesControllerTest
 * Add your own group annotations below this line
 */
class ProductAttributesControllerTest extends Unit
{
    protected const int ID_PRODUCT_CONCRETE = 1;

    protected const string ATTRIBUTE_NAME = 'color';

    protected const string ERROR_MESSAGE_CONCRETE_PRODUCT_CANNOT_BE_FOUND = 'Concrete Product cannot be found';

    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testConcreteTableDataActionReturnsNotFoundErrorWhenProductConcreteIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->arrangeProductConcreteNotOwnedByCurrentMerchant();

        // Act
        $response = (new ProductAttributesController())->concreteTableDataAction($this->createRequest());

        // Assert
        $this->assertStringContainsString(static::ERROR_MESSAGE_CONCRETE_PRODUCT_CANNOT_BE_FOUND, (string)$response->getContent());
    }

    public function testSaveProductConcreteAttributeActionDoesNotSaveProductConcreteWhenProductConcreteIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->arrangeProductConcreteNotOwnedByCurrentMerchant();

        // Act
        $response = (new ProductAttributesController())->saveProductConcreteAttributeAction($this->createRequest());

        // Assert
        $this->assertStringContainsString(static::ERROR_MESSAGE_CONCRETE_PRODUCT_CANNOT_BE_FOUND, (string)$response->getContent());
    }

    public function testDeleteConcreteProductAttributeActionDoesNotSaveProductConcreteWhenProductConcreteIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->arrangeProductConcreteNotOwnedByCurrentMerchant();

        // Act
        $response = (new ProductAttributesController())->deleteConcreteProductAttributeAction($this->createRequest());

        // Assert
        $this->assertStringContainsString(static::ERROR_MESSAGE_CONCRETE_PRODUCT_CANNOT_BE_FOUND, (string)$response->getContent());
    }

    protected function arrangeProductConcreteNotOwnedByCurrentMerchant(): void
    {
        $this->tester->setCurrentMerchantProductOwnership(false);
        $this->tester->setZedUiFactory();

        $productFacadeMock = $this->createMock(ProductMerchantPortalGuiToProductFacadeInterface::class);
        $productFacadeMock->expects($this->never())->method('findProductConcreteById');
        $productFacadeMock->expects($this->never())->method('saveProductConcrete');
        $this->tester->setProductFacade($productFacadeMock);
    }

    protected function createRequest(): Request
    {
        return new Request([
            'idProductConcrete' => static::ID_PRODUCT_CONCRETE,
            'attribute_name' => static::ATTRIBUTE_NAME,
        ]);
    }
}
