<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\Controller;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\PriceProductTableViewTransfer;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\UpdateProductAbstractController;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\MerchantProductNotFoundException;
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
 * @group UpdateProductAbstractControllerTest
 * Add your own group annotations below this line
 */
class UpdateProductAbstractControllerTest extends Unit
{
    protected const int ID_PRODUCT_ABSTRACT = 1;

    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testTableDataActionThrowsNotFoundExceptionWhenProductAbstractIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(false);

        // Expect
        $this->expectException(MerchantProductNotFoundException::class);

        // Act
        (new UpdateProductAbstractController())->tableDataAction($this->createTableDataRequest());
    }

    public function testTableDataActionReturnsGuiTableDataResponseWhenProductAbstractIsOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(true);
        $expectedResponse = new JsonResponse();
        $this->tester->setGuiTableHttpDataRequestExecutorResponse($expectedResponse);

        // Act
        $response = (new UpdateProductAbstractController())->tableDataAction($this->createTableDataRequest());

        // Assert
        $this->assertSame($expectedResponse, $response);
    }

    protected function createTableDataRequest(): Request
    {
        return new Request([PriceProductTableViewTransfer::ID_PRODUCT_ABSTRACT => static::ID_PRODUCT_ABSTRACT]);
    }
}
