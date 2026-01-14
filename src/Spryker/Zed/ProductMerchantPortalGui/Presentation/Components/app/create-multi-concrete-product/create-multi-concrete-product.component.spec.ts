import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ScrollingModule } from '@angular/cdk/scrolling';
import { InvokeModule } from '@spryker/utils';
import { By } from '@angular/platform-browser';
import { CreateMultiConcreteProductComponent } from './create-multi-concrete-product.component';
import { ConcreteProductsPreviewComponent } from '../concrete-products-preview/concrete-products-preview.component';
import { ProductAttributesSelectorComponent } from '../product-attributes-selector/product-attributes-selector.component';
import { ConcreteProductGeneratorDataService } from '../../services/concrete-product-generator-data.service';

const mockAttributesName = 'attributesName';
const mockProductsName = 'productsName';
const mockAttributes = [
    {
        name: 'name1',
        value: 'value1',
        attributes: [
            {
                name: 'name11',
                value: 'value11',
            },
            {
                name: 'name12',
                value: 'value12',
            },
        ],
    },
    {
        name: 'name2',
        value: 'value2',
        attributes: [
            {
                name: 'name21',
                value: 'value21',
            },
        ],
    },
];
const mockSelectedAttributes = [
    {
        name: 'name1',
        value: 'value1',
        attributes: [
            {
                name: 'name11',
                value: 'value11',
            },
        ],
    },
];
const mockGeneratedProducts = [
    {
        name: '',
        sku: '',
        superAttributes: [
            {
                name: 'name1',
                value: 'value1',
                attribute: {
                    name: 'name11',
                    value: 'value11',
                },
            },
            {
                name: 'name2',
                value: 'value2',
                attribute: {
                    name: 'name21',
                    value: 'value21',
                },
            },
        ],
    },
    {
        name: '',
        sku: '',
        superAttributes: [
            {
                name: 'name1',
                value: 'value1',
                attribute: {
                    name: 'name12',
                    value: 'value12',
                },
            },
            {
                name: 'name2',
                value: 'value2',
                attribute: {
                    name: 'name21',
                    value: 'value21',
                },
            },
        ],
    },
];
const mockGeneratedProductErrors = [
    {
        fields: {
            name: '',
            sku: '123',
        },
        errors: {
            name: 'This value should not be blank.',
            sku: 'SKU Prefix already exists',
        },
    },
    {},
];

@Component({
    standalone: false,
    template: `
        <mp-create-multi-concrete-product
            [attributes]="attributes"
            [selectedAttributes]="selectedAttributes"
            [attributesName]="attributesName"
            [productsName]="productsName"
            [generatedProducts]="generatedProducts"
            [generatedProductErrors]="generatedProductErrors"
        >
            <span title></span>
            <span action></span>
            <span selector-col-attr-name></span>
            <span selector-col-attr-values-name></span>
            <span selector-btn-attr-add-name></span>
            <span preview-text></span>
            <span preview-total-text></span>
            <span preview-auto-sku-text></span>
            <span preview-auto-name-text></span>
            <span preview-col-attr-name></span>
            <span preview-col-sku-name></span>
            <span preview-col-name-name></span>
            <span preview-no-data-text></span>
        </mp-create-multi-concrete-product>
    `,
})
class TestHostComponent {
    @Input() attributes: any;
    @Input() selectedAttributes: any;
    @Input() attributesName: any;
    @Input() productsName: any;
    @Input() generatedProducts: any;
    @Input() generatedProductErrors: any;
}

describe('CreateMultiConcreteProductComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [ScrollingModule, InvokeModule],
            declarations: [
                CreateMultiConcreteProductComponent,
                ProductAttributesSelectorComponent,
                ConcreteProductsPreviewComponent,
                TestHostComponent,
            ],
            providers: [ConcreteProductGeneratorDataService],
            schemas: [NO_ERRORS_SCHEMA],
        });
    });

    describe('Slots and Components', () => {
        let hostFixture: ComponentFixture<TestHostComponent>;

        beforeEach(() => {
            hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();
        });

        it('should render <spy-headline> component', () => {
            const headlineComponent = hostFixture.debugElement.query(By.css('spy-headline'));

            expect(headlineComponent).toBeTruthy();
        });

        it('should render `title` slot to the `.mp-create-multi-concrete-product__header` element', () => {
            const titleSlot = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__header [title]'),
            );

            expect(titleSlot).toBeTruthy();
        });

        it('should render `action` slot to the `.mp-create-multi-concrete-product__header` element', () => {
            const actionSlot = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__header [action]'),
            );

            expect(actionSlot).toBeTruthy();
        });

        describe('<mp-product-attributes-selector> component', () => {
            it('should render <mp-product-attributes-selector> component to the `.mp-create-multi-concrete-product__content` element', () => {
                const productAttributesSelectorComponent = hostFixture.debugElement.query(
                    By.css('.mp-create-multi-concrete-product__content mp-product-attributes-selector'),
                );

                expect(productAttributesSelectorComponent).toBeTruthy();
            });

            it('should render `selector-col-attr-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const selectorColAttrNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-product-attributes-selector [selector-col-attr-name]'),
                );

                expect(selectorColAttrNameSlot).toBeTruthy();
            });

            it('should render `selector-col-attr-values-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const selectorColAttrValuesNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-product-attributes-selector [selector-col-attr-values-name]'),
                );

                expect(selectorColAttrValuesNameSlot).toBeTruthy();
            });

            it('should render `selector-btn-attr-add-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const selectorBtnAttrAddNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-product-attributes-selector [selector-btn-attr-add-name]'),
                );

                expect(selectorBtnAttrAddNameSlot).toBeTruthy();
            });
        });

        it('should render `preview-text` slot to the `.mp-create-multi-concrete-product__preview-title` element', () => {
            const previewTextSlot = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__preview-title [preview-text]'),
            );

            expect(previewTextSlot).toBeTruthy();
        });

        describe('<mp-concrete-products-preview> component', () => {
            it('should render <mp-concrete-products-preview> component to the `.mp-create-multi-concrete-product__content` element', () => {
                const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                    By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
                );

                expect(concreteProductsPreviewComponent).toBeTruthy();
            });

            it('should render `preview-total-text` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewTotalTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-total-text]'),
                );

                expect(previewTotalTextSlot).toBeTruthy();
            });

            it('should render `preview-auto-sku-text` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewAutoSkuTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-auto-sku-text]'),
                );

                expect(previewAutoSkuTextSlot).toBeTruthy();
            });

            it('should render `preview-auto-name-text` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewAutoNameTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-auto-name-text]'),
                );

                expect(previewAutoNameTextSlot).toBeTruthy();
            });

            it('should render `preview-col-attr-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewColAttrNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-attr-name]'),
                );

                expect(previewColAttrNameSlot).toBeTruthy();
            });

            it('should render `preview-col-sku-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewColSkuNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-sku-name]'),
                );

                expect(previewColSkuNameSlot).toBeTruthy();
            });

            it('should render `preview-col-name-name` slot', () => {
                const localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
                localHostFixture.detectChanges();

                const previewColNameNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-name-name]'),
                );

                expect(previewColNameNameSlot).toBeTruthy();
            });

            it('should render `preview-no-data-text` slot', () => {
                const previewNoDataTextSlot = hostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-no-data-text]'),
                );

                expect(previewNoDataTextSlot).toBeTruthy();
            });
        });
    });

    describe('@Inputs', () => {
        it('should bound `@Input(attributesName)` to the `name` input of <mp-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributesName', mockAttributesName);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const productAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-product-attributes-selector'),
            );

            expect(productAttributesSelectorComponent.componentInstance.name).toBe(mockAttributesName);
        });

        it('should bound `@Input(attributes)` to the `attributes` input of <mp-product-attributes-selector> component', () => {
            const updatedMockAttributes = mockAttributes.map((item) =>
                Object.assign({}, { ...item, isDisabled: false }),
            );
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const productAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-product-attributes-selector'),
            );

            expect(productAttributesSelectorComponent.componentInstance.attributes).toStrictEqual(
                updatedMockAttributes,
            );
        });

        it('should bound `@Input(selectedAttributes)` to the `selectedAttributes` input of <mp-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            hostFixture.detectChanges();

            const productAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-product-attributes-selector'),
            );

            expect(productAttributesSelectorComponent.componentInstance.selectedAttributes).toBe(
                mockSelectedAttributes,
            );
        });

        it('should bound `@Input(productsName)` to the `name` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('productsName', mockProductsName);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.name).toBe(mockProductsName);
        });

        it('should bound `@Input(selectedAttributes)` to the `attributes` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.attributes).toBe(mockSelectedAttributes);
        });

        it('should bound `@Input(generatedProducts)` to the `generatedProducts` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('generatedProducts', mockGeneratedProducts);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.generatedProducts).toStrictEqual(
                mockGeneratedProducts,
            );
        });

        it('should bound `@Input(generatedProductErrors)` to the `errors` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('generatedProductErrors', mockGeneratedProductErrors);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.errors).toBe(mockGeneratedProductErrors);
        });

        it('should update `attributes` input of <mp-concrete-products-preview> component when `selectedAttributesChange` event emitted', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const productAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-product-attributes-selector'),
            );
            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('.mp-create-multi-concrete-product__content mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.attributes).toStrictEqual([]);

            productAttributesSelectorComponent.triggerEventHandler('selectedAttributesChange', mockSelectedAttributes);
            hostFixture.detectChanges();

            expect(concreteProductsPreviewComponent.componentInstance.attributes).toBe(mockSelectedAttributes);
        });
    });
});
