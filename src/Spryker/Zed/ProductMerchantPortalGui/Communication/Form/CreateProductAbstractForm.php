<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint\SkuRegexConstraint;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint\UniqueAbstractSkuConstraint;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Persistence\ProductMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 */
class CreateProductAbstractForm extends AbstractType
{
    public const FIELD_NAME = 'name';
    public const FIELD_SKU = 'sku';
    public const FIELD_IS_SINGLE_CONCRETE = 'isSingleConcrete';

    protected const LABEL_SKU = 'SKU Prefix';
    protected const LABEL_NAME = 'Name';
    protected const LABEL_IS_SINGLE_CONCRETE = 'Concrete products';

    protected const PLACEHOLDER_SKU = 'Enter SKU prefix';
    protected const PLACEHOLDER_NAME = 'Enter name';

    protected const CHOICES_IS_SINGLE_CONCRETE = [
        'Abstract product has 1 concrete product' => true,
        'Abstract product has multiple concrete products' => false,
    ];

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
        $this->addSkuField($builder)
            ->addNameField($builder)
            ->addIsSingleConcreteField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSkuField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_SKU, TextType::class, [
            'label' => static::LABEL_SKU,
            'required' => true,
            'constraints' => [
                new NotBlank(),
                new SkuRegexConstraint(),
                new UniqueAbstractSkuConstraint(),
            ],
            'attr' => [
                'placeholder' => static::PLACEHOLDER_SKU,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_NAME, TextType::class, [
            'label' => static::LABEL_NAME,
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
            'attr' => [
                'placeholder' => static::PLACEHOLDER_NAME,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addIsSingleConcreteField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_IS_SINGLE_CONCRETE, ChoiceType::class, [
            'label' => static::LABEL_IS_SINGLE_CONCRETE,
            'choices' => static::CHOICES_IS_SINGLE_CONCRETE,
            'required' => true,
            'expanded' => true,
            'multiple' => false,
        ]);

        return $this;
    }
}
