<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Controller;

use Generated\Shared\Transfer\LocaleTransfer;
use Generated\Shared\Transfer\MerchantProductCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProductTransfer;
use Generated\Shared\Transfer\ProductConcreteCollectionTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\MerchantProductNotFoundException;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Persistence\ProductMerchantPortalGuiRepositoryInterface getRepository()
 */
class AddProductConcreteController extends AbstractController
{
    protected const RESPONSE_KEY_POST_ACTIONS = 'postActions';
    protected const RESPONSE_KEY_NOTIFICATIONS = 'notifications';
    protected const RESPONSE_KEY_TYPE = 'type';
    protected const RESPONSE_KEY_MESSAGE = 'message';

    protected const RESPONSE_TYPE_REFRESH_TABLE = 'refresh_table';
    protected const RESPONSE_TYPE_CLOSE_OVERLAY = 'close_overlay';
    protected const RESPONSE_TYPE_SUCCESS = 'success';
    protected const RESPONSE_TYPE_ERROR = 'error';

    protected const RESPONSE_MESSAGE_SUCCESS_PRODUCTS_SAVED = 'Success! %d Concrete Products are saved.';
    protected const RESPONSE_MESSAGE_SUCCESS_PRODUCT_SAVED = 'Success! %d Concrete Product is saved.';
    protected const RESPONSE_MESSAGE_ERROR = 'Please resolve all errors.';

    protected const PARAM_ID_PRODUCT_ABSTRACT = 'product-abstract-id';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\AddProductConcreteForm::FIELD_ID_PRODUCT_ABSTRACT
     */
    protected const ADD_PRODUCT_CONCRETE_FORM_FIELD_ID_PRODUCT_ABSTRACT = 'idProductAbstract';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\AddProductConcreteForm::FIELD_EXISTING_ATTRIBUTES
     */
    protected const ADD_PRODUCT_CONCRETE_FORM_FIELD_EXISTING_ATTRIBUTES = 'existing_attributes';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\AddProductConcreteForm::FIELD_PRODUCTS
     */
    protected const FIELD_PRODUCTS = 'products';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Zed\ProductMerchantPortalGui\Communication\Exception\MerchantProductNotFoundException
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function indexAction(Request $request): JsonResponse
    {
        $idProductAbstract = $this->castId($request->get(static::PARAM_ID_PRODUCT_ABSTRACT));

        $idMerchant = $this->getFactory()->getMerchantUserFacade()->getCurrentMerchantUser()->getIdMerchantOrFail();
        $merchantProductTransfer = $this->getFactory()->getMerchantProductFacade()->findMerchantProduct(
            (new MerchantProductCriteriaTransfer())->addIdMerchant($idMerchant)->setIdProductAbstract($idProductAbstract)
        );

        if (!$merchantProductTransfer) {
            throw new MerchantProductNotFoundException($idMerchant, $idProductAbstract);
        }

        $productManagementAttributeTransfers = $this->getFactory()
            ->getProductAttributeFacade()
            ->getUniqueSuperAttributesFromConcreteProducts($merchantProductTransfer->getProducts()->getArrayCopy());

        $attributes = $this->getFactory()
            ->createAttributesDataProvider()
            ->getProductAttributesData($productManagementAttributeTransfers);

        $addProductConcreteForm = $this->getFactory()->createAddProductConcreteForm([
            static::ADD_PRODUCT_CONCRETE_FORM_FIELD_ID_PRODUCT_ABSTRACT => $idProductAbstract,
            static::ADD_PRODUCT_CONCRETE_FORM_FIELD_EXISTING_ATTRIBUTES => $this->getFactory()
                ->getUtilEncodingService()
                ->encodeJson($attributes),
        ]);
        $addProductConcreteForm->handleRequest($request);

        $defaultStoreDefaultLocaleTransfer = $this->getFactory()
            ->createLocaleDataProvider()
            ->getDefaultStoreDefaultLocale();

        if ($addProductConcreteForm->isSubmitted() && $addProductConcreteForm->isValid()) {
            $productConcreteCollectionTransfer = $this->getProductConcreteCollection(
                $addProductConcreteForm,
                $defaultStoreDefaultLocaleTransfer
            );
            $this->getFactory()->getProductFacade()->createProductConcreteCollection($productConcreteCollectionTransfer);
        }

        return $this->getResponse(
            $addProductConcreteForm,
            $merchantProductTransfer,
            $productConcreteCollectionTransfer ?? new ProductConcreteCollectionTransfer(),
            $defaultStoreDefaultLocaleTransfer,
            $productManagementAttributeTransfers
        );
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $addProductConcreteForm
     * @param \Generated\Shared\Transfer\LocaleTransfer $localeTransfer
     *
     * @return \Generated\Shared\Transfer\ProductConcreteCollectionTransfer
     */
    protected function getProductConcreteCollection(
        FormInterface $addProductConcreteForm,
        LocaleTransfer $localeTransfer
    ): ProductConcreteCollectionTransfer {
        $formData = $addProductConcreteForm->getData();
        $productConcreteCollectionTransfer = $this->getFactory()
            ->createProductFormTransferMapper()
            ->mapAddProductConcreteFormDataToProductConcreteCollectionTransfer(
                $formData,
                new ProductConcreteCollectionTransfer(),
                $localeTransfer
            );

        $this->getFactory()
            ->createProductStockExpander()
            ->expandProductConcreteTransfersWithDefaultMerchantProductStock($productConcreteCollectionTransfer->getProducts()->getArrayCopy());

        return $productConcreteCollectionTransfer;
    }

    /**
     * @phpstan-param \Symfony\Component\Form\FormInterface<mixed> $addProductConcreteForm
     *
     * @param \Symfony\Component\Form\FormInterface $addProductConcreteForm
     * @param \Generated\Shared\Transfer\MerchantProductTransfer $merchantProductTransfer
     * @param \Generated\Shared\Transfer\ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
     * @param \Generated\Shared\Transfer\LocaleTransfer $defaultStoreDefaultLocaleTransfer
     * @param \Generated\Shared\Transfer\ProductManagementAttributeTransfer[] $productManagementAttributeTransfers
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    protected function getResponse(
        FormInterface $addProductConcreteForm,
        MerchantProductTransfer $merchantProductTransfer,
        ProductConcreteCollectionTransfer $productConcreteCollectionTransfer,
        LocaleTransfer $defaultStoreDefaultLocaleTransfer,
        array $productManagementAttributeTransfers
    ): JsonResponse {
        $responseData = $this->getResponseData(
            $addProductConcreteForm,
            $merchantProductTransfer,
            $defaultStoreDefaultLocaleTransfer,
            $productManagementAttributeTransfers
        );

        if (!$addProductConcreteForm->isSubmitted()) {
            return new JsonResponse($responseData);
        }

        if ($addProductConcreteForm->isValid()) {
            $responseData = $this->addSuccessResponseDataToResponse($responseData, $productConcreteCollectionTransfer);

            return new JsonResponse($responseData);
        }

        $responseData = $this->addErrorResponseDataToResponse($responseData, $addProductConcreteForm);

        return new JsonResponse($responseData);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $addProductConcreteForm
     * @param \Generated\Shared\Transfer\MerchantProductTransfer $merchantProductTransfer
     * @param \Generated\Shared\Transfer\LocaleTransfer $defaultStoreDefaultLocaleTransfer
     * @param \Generated\Shared\Transfer\ProductManagementAttributeTransfer[] $productManagementAttributeTransfers
     *
     * @return mixed[]
     */
    protected function getResponseData(
        FormInterface $addProductConcreteForm,
        MerchantProductTransfer $merchantProductTransfer,
        LocaleTransfer $defaultStoreDefaultLocaleTransfer,
        array $productManagementAttributeTransfers
    ): array {
        $attributesDataProvider = $this->getFactory()->createAttributesDataProvider();
        $localizedAttributesExtractor = $this->getFactory()->createLocalizedAttributesExtractor();

        $productAbstractTransfer = $merchantProductTransfer->getProductAbstractOrFail();
        $localizedAttributesTransfer = $localizedAttributesExtractor->extractLocalizedAttributes(
            $productAbstractTransfer->getLocalizedAttributes(),
            $this->getFactory()->getLocaleFacade()->getCurrentLocale()
        );
        $defaultLocalizedAttributesTransfer = $localizedAttributesExtractor->extractLocalizedAttributes(
            $productAbstractTransfer->getLocalizedAttributes(),
            $defaultStoreDefaultLocaleTransfer
        );

        return [
            'form' => $this->renderView('@ProductMerchantPortalGui/Partials/add_product_concrete_form.twig', [
                'form' => $addProductConcreteForm->createView(),
                'productAbstract' => $productAbstractTransfer,
                'attributes' => $attributesDataProvider->getProductAttributesData($productManagementAttributeTransfers),
                'existingProducts' => $attributesDataProvider->getExistingConcreteProductData(
                    $merchantProductTransfer,
                    $productManagementAttributeTransfers,
                    $defaultStoreDefaultLocaleTransfer
                ),
                'generatedProducts' => $addProductConcreteForm->getData()[static::FIELD_PRODUCTS] ?? [],
                'errors' => $this->getErrors($addProductConcreteForm),
                'attributesErrors' => $this->getFactory()
                    ->createFormErrorsMapper()
                    ->mapAddProductConcreteFormAttributesErrorsToErrorsData($addProductConcreteForm, []),
                'productAbstractDisplayedName' => $localizedAttributesTransfer
                    ? $localizedAttributesTransfer->getName()
                    : $productAbstractTransfer->getName(),
                'productAbstractDefaultName' => $defaultLocalizedAttributesTransfer
                    ? $defaultLocalizedAttributesTransfer->getName()
                    : $productAbstractTransfer->getName(),
            ])->getContent(),
        ];
    }

    /**
     * @param mixed[] $responseData
     * @param \Generated\Shared\Transfer\ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
     *
     * @return mixed[]
     */
    protected function addSuccessResponseDataToResponse(
        array $responseData,
        ProductConcreteCollectionTransfer $productConcreteCollectionTransfer
    ): array {
        $responseData[static::RESPONSE_KEY_POST_ACTIONS] = [
            [
                static::RESPONSE_KEY_TYPE => static::RESPONSE_TYPE_CLOSE_OVERLAY,
            ],
            [
                static::RESPONSE_KEY_TYPE => static::RESPONSE_TYPE_REFRESH_TABLE,
            ],
        ];

        $productsNumber = $productConcreteCollectionTransfer->getProducts()->count();
        $responseData[static::RESPONSE_KEY_NOTIFICATIONS] = [[
            static::RESPONSE_KEY_TYPE => static::RESPONSE_TYPE_SUCCESS,
            static::RESPONSE_KEY_MESSAGE => sprintf(
                $productsNumber === 1 ? static::RESPONSE_MESSAGE_SUCCESS_PRODUCT_SAVED : static::RESPONSE_MESSAGE_SUCCESS_PRODUCTS_SAVED,
                $productsNumber
            ),
        ]];

        return $responseData;
    }

    /**
     * @phpstan-param \Symfony\Component\Form\FormInterface<mixed> $addProductConcreteForm
     *
     * @param mixed[] $responseData
     * @param \Symfony\Component\Form\FormInterface $addProductConcreteForm
     *
     * @return mixed[]
     */
    protected function addErrorResponseDataToResponse(array $responseData, FormInterface $addProductConcreteForm): array
    {
        $responseData[static::RESPONSE_KEY_NOTIFICATIONS][] = [
            static::RESPONSE_KEY_TYPE => static::RESPONSE_TYPE_ERROR,
            static::RESPONSE_KEY_MESSAGE => static::RESPONSE_MESSAGE_ERROR,
        ];

        return $responseData;
    }

    /**
     * @phpstan-param \Symfony\Component\Form\FormInterface<mixed> $addProductConcreteForm
     *
     * @param \Symfony\Component\Form\FormInterface $addProductConcreteForm
     *
     * @return mixed[]
     */
    protected function getErrors(FormInterface $addProductConcreteForm)
    {
        $errors = [];

        if (!$addProductConcreteForm->isSubmitted()) {
            return $errors;
        }

        if ($addProductConcreteForm->isSubmitted() && $addProductConcreteForm->isValid()) {
            return $errors;
        }

        return $this->getFactory()->createFormErrorsMapper()->mapAddProductConcreteFormErrorsToErrorsData(
            $addProductConcreteForm,
            $errors
        );
    }
}
