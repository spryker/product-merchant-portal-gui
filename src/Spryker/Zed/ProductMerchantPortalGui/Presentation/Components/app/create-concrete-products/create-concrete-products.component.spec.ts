import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { ScrollingModule } from '@angular/cdk/scrolling';
import { InvokeModule } from '@spryker/utils';
import { By } from '@angular/platform-browser';
import { CreateConcreteProductsComponent } from './create-concrete-products.component';
import { ConcreteProductAttributesSelectorComponent } from '../concrete-product-attributes-selector/concrete-product-attributes-selector.component';
import { ConcreteProductsPreviewComponent } from '../concrete-products-preview/concrete-products-preview.component';
import { ConcreteProductGeneratorDataService } from '../../services/concrete-product-generator-data.service';

const mockProductsName = 'Products Name';
const mockAttributesName = 'Attributes Name';
const mockAttributesPlaceholder = 'Attributes Placeholder';
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
const mockAttributeErrors = [
    {
        error: 'attribute error',
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
const mockUpdatedSelectedAttributes = [
    ...mockSelectedAttributes,
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
const mockExistingProducts = [
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
        <mp-create-concrete-products
            [attributes]="attributes"
            [selectedAttributes]="selectedAttributes"
            [attributeErrors]="attributeErrors"
            [existingProducts]="existingProducts"
            [generatedProducts]="generatedProducts"
            [generatedProductErrors]="generatedProductErrors"
            [productsName]="productsName"
            [attributesName]="attributesName"
            [attributesPlaceholder]="attributesPlaceholder"
        >
            <span preview-text></span>
            <span preview-total-text></span>
            <span preview-auto-sku-text></span>
            <span preview-auto-name-text></span>
            <span preview-col-attr-name></span>
            <span preview-col-sku-name></span>
            <span preview-col-name-name></span>
            <span preview-no-data-text></span>
        </mp-create-concrete-products>
    `,
})
class TestHostComponent {
    @Input() attributes: any;
    @Input() selectedAttributes: any;
    @Input() attributeErrors: any;
    @Input() existingProducts: any;
    @Input() generatedProducts: any;
    @Input() generatedProductErrors: any;
    @Input() productsName: any;
    @Input() attributesName: any;
    @Input() attributesPlaceholder: any;
}

describe('CreateConcreteProductsComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [ScrollingModule, InvokeModule],
            declarations: [
                CreateConcreteProductsComponent,
                ConcreteProductAttributesSelectorComponent,
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

        it('should render <mp-concrete-product-attributes-selector> component', () => {
            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );

            expect(concreteProductAttributesSelectorComponent).toBeTruthy();
        });

        it('should render `preview-text` slot to the `.mp-create-concrete-products__preview-title` element', () => {
            const previewTextSlot = hostFixture.debugElement.query(
                By.css('.mp-create-concrete-products__preview-title [preview-text]'),
            );

            expect(previewTextSlot).toBeTruthy();
        });

        it('should render <mp-concrete-products-preview> component', () => {
            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent).toBeTruthy();
        });

        describe('<mp-concrete-products-preview> component', () => {
            let localHostFixture: ComponentFixture<TestHostComponent>;

            beforeEach(() => {
                localHostFixture = TestBed.createComponent(TestHostComponent);
                localHostFixture.componentRef.setInput('attributes', mockAttributes);
                localHostFixture.componentRef.setInput('selectedAttributes', mockUpdatedSelectedAttributes);
                localHostFixture.detectChanges();
            });

            it('should render `preview-total-text` slot', () => {
                const previewTotalTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-total-text]'),
                );

                expect(previewTotalTextSlot).toBeTruthy();
            });

            it('should render `preview-auto-sku-text` slot', () => {
                const previewAutoSkuTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-auto-sku-text]'),
                );

                expect(previewAutoSkuTextSlot).toBeTruthy();
            });

            it('should render `preview-auto-name-text` slot', () => {
                const previewAutoNameTextSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-auto-name-text]'),
                );

                expect(previewAutoNameTextSlot).toBeTruthy();
            });

            it('should render `preview-col-attr-name` slot', () => {
                const previewColAttrNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-attr-name]'),
                );

                expect(previewColAttrNameSlot).toBeTruthy();
            });

            it('should render `preview-col-sku-name` slot', () => {
                const previewColSkuNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-sku-name]'),
                );

                expect(previewColSkuNameSlot).toBeTruthy();
            });

            it('should render `preview-col-name-name` slot', () => {
                const previewColNameNameSlot = localHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-col-name-name]'),
                );

                expect(previewColNameNameSlot).toBeTruthy();
            });

            it('should render `preview-no-data-text` slot', () => {
                const noDataHostFixture = TestBed.createComponent(TestHostComponent);
                noDataHostFixture.componentRef.setInput('attributes', []);
                noDataHostFixture.componentRef.setInput('selectedAttributes', []);
                noDataHostFixture.detectChanges();

                const previewNoDataTextSlot = noDataHostFixture.debugElement.query(
                    By.css('mp-concrete-products-preview [preview-no-data-text]'),
                );

                expect(previewNoDataTextSlot).toBeTruthy();
            });
        });
    });

    describe('@Inputs', () => {
        it('should bound `@Input(attributes)` to the `attributes` input of <mp-concrete-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );

            expect(concreteProductAttributesSelectorComponent.componentInstance.attributes).toBe(mockAttributes);
        });

        it('should bound `@Input(attributeErrors)` to the `errors` input of <mp-concrete-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributeErrors', mockAttributeErrors);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );

            expect(concreteProductAttributesSelectorComponent.componentInstance.errors).toBe(mockAttributeErrors);
        });

        it('should bound `@Input(selectedAttributes)` to the `selectedAttributes` input of <mp-concrete-product-attributes-selector> component and to the `attributes` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );
            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
            );

            expect(concreteProductAttributesSelectorComponent.componentInstance.selectedAttributes[0]).toStrictEqual(
                mockSelectedAttributes[0],
            );
            expect(concreteProductsPreviewComponent.componentInstance.attributes[0]).toStrictEqual(
                mockSelectedAttributes[0],
            );
        });

        it('should bound `@Input(existingProducts)` to the `existingProducts` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('existingProducts', mockExistingProducts);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.existingProducts).toBe(mockExistingProducts);
        });

        it('should bound `@Input(generatedProducts)` to the `generatedProducts` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('generatedProducts', mockGeneratedProducts);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
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
                By.css('mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.errors).toBe(mockGeneratedProductErrors);
        });

        it('should bound `@Input(productsName)` to the `name` input of <mp-concrete-products-preview> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('productsName', mockProductsName);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
            );

            expect(concreteProductsPreviewComponent.componentInstance.name).toBe(mockProductsName);
        });

        it('should bound `@Input(attributesName)` to the `name` input of <mp-concrete-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributesName', mockAttributesName);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );

            expect(concreteProductAttributesSelectorComponent.componentInstance.name).toBe(mockAttributesName);
        });

        it('should bound `@Input(attributesPlaceholder)` to the `placeholder` input of <mp-concrete-product-attributes-selector> component', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributesPlaceholder', mockAttributesPlaceholder);
            hostFixture.componentRef.setInput('attributes', []);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );

            expect(concreteProductAttributesSelectorComponent.componentInstance.placeholder).toBe(
                mockAttributesPlaceholder,
            );
        });

        it('should update <mp-concrete-products-preview> component `attributes` input when `selectedAttributesChange` event emitted', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const concreteProductAttributesSelectorComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-product-attributes-selector'),
            );
            const concreteProductsPreviewComponent = hostFixture.debugElement.query(
                By.css('mp-concrete-products-preview'),
            );

            concreteProductAttributesSelectorComponent.triggerEventHandler(
                'selectedAttributesChange',
                mockSelectedAttributes,
            );
            hostFixture.detectChanges();

            expect(concreteProductsPreviewComponent.componentInstance.attributes).toBe(mockSelectedAttributes);
        });
    });
});
