<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Spryker Marketplace License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\ProductMerchantPortalGui\Communication\Form;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint\SkuRegexConstraint;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint\UniqueAbstractSkuConstraint;
use Spryker\Zed\ProductMerchantPortalGui\Communication\Form\Constraint\UniqueConcreteSkuConstraint;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @method \Spryker\Zed\ProductMerchantPortalGui\ProductMerchantPortalGuiConfig getConfig()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Persistence\ProductMerchantPortalGuiRepositoryInterface getRepository()
 * @method \Spryker\Zed\ProductMerchantPortalGui\Communication\ProductMerchantPortalGuiCommunicationFactory getFactory()
 */
class CreateProductAbstractWithSingleConcreteForm extends AbstractType
{
    protected const FIELD_NAME = 'name';
    protected const FIELD_SKU = 'sku';
    protected const FIELD_CONCRETE_NAME = 'concreteName';
    protected const FIELD_CONCRETE_SKU = 'concreteSku';
    protected const FIELD_AUTOGENERATE_SKU = 'autogenerateSku';
    protected const FIELD_USE_ABSTRACT_PRODUCT_NAME = 'useAbstractProductName';

    protected const LABEL_CONCRETE_SKU = 'Concrete Product SKU';
    protected const LABEL_CONCRETE_NAME = 'Concrete Product Name';
    protected const LABEL_AUTOGENERATE_SKU = 'Autogenerate SKU';
    protected const LABEL_USE_ABSTRACT_PRODUCT_NAME = 'Same as Abstract Product';

    protected const PLACEHOLDER_CONCRETE_SKU = 'Enter concrete product SKU';
    protected const PLACEHOLDER_CONCRETE_NAME = 'Enter concrete product name';

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
            ->addConcreteSkuField($builder)
            ->addConcreteNameField($builder)
            ->addAutogenerateSkuField($builder)
            ->addUseAbstractProductNameField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addSkuField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_SKU, HiddenType::class, [
            'required' => true,
            'constraints' => [
                new NotBlank(),
                new SkuRegexConstraint(),
                new UniqueAbstractSkuConstraint(),
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
        $builder->add(static::FIELD_NAME, HiddenType::class, [
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addConcreteSkuField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONCRETE_SKU, TextType::class, [
            'label' => static::LABEL_CONCRETE_SKU,
            'required' => true,
            'constraints' => [
                new NotBlank(),
                new SkuRegexConstraint(),
                new UniqueConcreteSkuConstraint(),
            ],
            'attr' => [
                'placeholder' => static::PLACEHOLDER_CONCRETE_SKU,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addConcreteNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_CONCRETE_NAME, TextType::class, [
            'label' => static::LABEL_CONCRETE_NAME,
            'required' => true,
            'constraints' => [
                new NotBlank(),
            ],
            'attr' => [
                'placeholder' => static::PLACEHOLDER_CONCRETE_NAME,
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addAutogenerateSkuField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_AUTOGENERATE_SKU, CheckboxType::class, [
            'required' => false,
            'label' => static::LABEL_AUTOGENERATE_SKU,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addUseAbstractProductNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_USE_ABSTRACT_PRODUCT_NAME, CheckboxType::class, [
            'required' => false,
            'label' => static::LABEL_USE_ABSTRACT_PRODUCT_NAME,
        ]);

        return $this;
    }
}
