<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\Controller;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductTableViewTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\UpdateProductConcreteController;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\ProductConcreteNotFoundException;
use SprykerTest\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiCommunicationTester;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Auto-generated group annotations
 *
 * @group SprykerTest
 * @group Zed
 * @group ProductMerchantPortalGui
 * @group Communication
 * @group Controller
 * @group UpdateProductConcreteControllerTest
 * Add your own group annotations below this line
 */
class UpdateProductConcreteControllerTest extends Unit
{
    protected const int ID_PRODUCT_CONCRETE = 1;

    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testPriceTableDataActionThrowsNotFoundExceptionWhenProductConcreteIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(false);

        // Expect
        $this->expectException(ProductConcreteNotFoundException::class);

        // Act
        (new UpdateProductConcreteController())->priceTableDataAction($this->createPriceTableDataRequest());
    }

    public function testPriceTableDataActionReturnsGuiTableDataResponseWhenProductConcreteIsOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(true);
        $expectedResponse = new JsonResponse();
        $this->tester->setGuiTableHttpDataRequestExecutorResponse($expectedResponse);

        // Act
        $response = (new UpdateProductConcreteController())->priceTableDataAction($this->createPriceTableDataRequest());

        // Assert
        $this->assertSame($expectedResponse, $response);
    }

    protected function createPriceTableDataRequest(): Request
    {
        return new Request([PriceProductTableViewTransfer::ID_PRODUCT_CONCRETE => static::ID_PRODUCT_CONCRETE]);
    }
}
