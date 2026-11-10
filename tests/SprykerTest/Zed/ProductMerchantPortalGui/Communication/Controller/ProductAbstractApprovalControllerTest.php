<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace SprykerTest\Zed\ProductMerchantPortalGui\Communication\Controller;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Service\Container\Container;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Controller\ProductAbstractApprovalController;
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
 * @group ProductAbstractApprovalControllerTest
 * Add your own group annotations below this line
 */
class ProductAbstractApprovalControllerTest extends Unit
{
    protected const int ID_PRODUCT_ABSTRACT = 1;

    protected const string APPROVAL_STATUS_WAITING_FOR_APPROVAL = 'waiting_for_approval';

    protected const string APPROVAL_STATUS_DRAFT = 'draft';

    protected const string APPROVAL_STATUS_APPROVED = 'approved';

    protected const string URL_PRODUCTS = '/product-merchant-portal-gui/products';

    protected ProductMerchantPortalGuiCommunicationTester $tester;

    public function testIndexActionDoesNotSaveProductAbstractWhenProductAbstractIsNotOwnedByCurrentMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(false);
        $this->tester->setProductFacade($this->createProductFacadeMockExpectingNoProductAbstractAccess());

        // Act
        $response = (new ProductAbstractApprovalController())
            ->setApplication(new Container())
            ->indexAction($this->createRequest());

        // Assert
        $this->assertSame(static::URL_PRODUCTS, $response->getTargetUrl());
    }

    public function testIndexActionDoesNotSaveProductAbstractWhenApprovalStatusIsNotApplicableForMerchant(): void
    {
        // Arrange
        $this->tester->setCurrentMerchantProductOwnership(true);
        $this->tester->setProductFacade($this->createProductFacadeMockExpectingNoProductAbstractSave());

        // Act
        $response = (new ProductAbstractApprovalController())
            ->setApplication(new Container())
            ->indexAction($this->createRequest(static::APPROVAL_STATUS_APPROVED));

        // Assert
        $this->assertSame(static::URL_PRODUCTS, $response->getTargetUrl());
    }

    protected function createProductFacadeMockExpectingNoProductAbstractSave(): ProductMerchantPortalGuiToProductFacadeInterface
    {
        $productFacadeMock = $this->createMock(ProductMerchantPortalGuiToProductFacadeInterface::class);
        $productFacadeMock->method('findProductAbstractById')->willReturn(
            (new ProductAbstractTransfer())
                ->setIdProductAbstract(static::ID_PRODUCT_ABSTRACT)
                ->setApprovalStatus(static::APPROVAL_STATUS_DRAFT),
        );
        $productFacadeMock->expects($this->never())->method('saveProductAbstract');

        return $productFacadeMock;
    }

    protected function createProductFacadeMockExpectingNoProductAbstractAccess(): ProductMerchantPortalGuiToProductFacadeInterface
    {
        $productFacadeMock = $this->createMock(ProductMerchantPortalGuiToProductFacadeInterface::class);
        $productFacadeMock->expects($this->never())->method('findProductAbstractById');
        $productFacadeMock->expects($this->never())->method('saveProductAbstract');

        return $productFacadeMock;
    }

    protected function createRequest(string $approvalStatus = self::APPROVAL_STATUS_WAITING_FOR_APPROVAL): Request
    {
        return new Request([
            'id-product-abstract' => static::ID_PRODUCT_ABSTRACT,
            'approval-status' => $approvalStatus,
        ]);
    }
}
