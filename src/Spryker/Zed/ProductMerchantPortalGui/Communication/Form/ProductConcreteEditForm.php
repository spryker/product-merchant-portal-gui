<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form;

use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Persistence\ProductMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 */
class ProductConcreteEditForm extends AbstractType
{
    protected const FIELD_PRODUCT_CONCRETE = 'productConcrete';
    protected const FIELD_USE_ABSTRACT_PRODUCT_PRICES = 'useAbstractProductPrices';
    protected const FIELD_SEARCHABILITY = 'searchability';

    protected const BLOCK_PREFIX = 'productConcreteEdit';

    protected const OPTION_SEARCHABILITY_CHOICES = 'OPTION_SEARCHABILITY_CHOICES';

    protected const LABEL_USE_ABSTRACT_PRODUCT_PRICES = 'Use Abstract Product prices';
    protected const LABEL_SEARCHABILITY = 'Searchability';

    protected const PLACEHOLDER_SEARCHABILITY = 'Select Locales';

    /**
     * @uses \Spryker\Zed\ProductMerchantPortalGui\Communication\Form\ProductConcreteForm::BLOCK_PREFIX
     */
    protected const BLOCK_PREFIX_PRODUCT_CONCRETE_FORM = 'productConcrete';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired(static::OPTION_SEARCHABILITY_CHOICES);
    }

    /**
     * @phpstan-param \Symfony\Component\Form\FormBuilderInterface<mixed> $builder
     * @phpstan-param array<mixed> $options
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addProductConcreteSubForm($builder)
            ->addUseAbstractProductPricesField($builder)
            ->addSearchabilityField($builder, $options);

        $builder->addModelTransformer($this->getFactory()->createProductConcreteEditFormDataTransformer());
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addProductConcreteSubForm(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PRODUCT_CONCRETE, ProductConcreteForm::class, [
            'constraints' => [
                $this->getFactory()->createProductConcreteOwnedByMerchantConstraint(),
                new NotBlank(),
            ],
            'label' => false,
        ]);

        /** @var \Generated\Shared\Transfer\ProductConcreteTransfer $productConcreteTransfer */
        $productConcreteTransfer = $builder->getData()[static::BLOCK_PREFIX_PRODUCT_CONCRETE_FORM];
        $priceProductTransformer = $this->getFactory()
            ->createPriceProductTransformer()
            ->setIdProductConcrete($productConcreteTransfer->getIdProductConcreteOrFail());

        $builder->get(static::FIELD_PRODUCT_CONCRETE)->get(ProductConcreteTransfer::PRICES)->addModelTransformer(
            $priceProductTransformer
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUseAbstractProductPricesField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_USE_ABSTRACT_PRODUCT_PRICES, CheckboxType::class, [
            'required' => false,
            'label' => static::LABEL_USE_ABSTRACT_PRODUCT_PRICES,
        ]);

        return $this;
    }

    /**
     * @phpstan-param \Symfony\Component\Form\FormBuilderInterface<mixed> $builder
     * @phpstan-param array<mixed> $options
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return $this
     */
    protected function addSearchabilityField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            static::FIELD_SEARCHABILITY,
            ChoiceType::class,
            [
                'choices' => $options[static::OPTION_SEARCHABILITY_CHOICES],
                'multiple' => true,
                'label' => static::LABEL_SEARCHABILITY,
                'required' => false,
                'attr' => [
                    'placeholder' => static::PLACEHOLDER_SEARCHABILITY,
                ],
            ]
        );

        return $this;
    }
}
