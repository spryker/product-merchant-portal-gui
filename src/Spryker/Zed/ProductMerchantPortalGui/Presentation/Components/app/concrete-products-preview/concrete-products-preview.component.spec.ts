import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, fakeAsync, TestBed, tick } from '@angular/core/testing';
import { ScrollingModule } from '@angular/cdk/scrolling';
import { By } from '@angular/platform-browser';
import { InvokeModule } from '@spryker/utils';
import { ConcreteProductsPreviewComponent } from './concrete-products-preview.component';
import { ConcreteProductSkuGeneratorFactoryService } from '../../services/concrete-product-sku-generator-factory.service';
import { ConcreteProductNameGeneratorFactoryService } from '../../services/concrete-product-name-generator-factory.service';
import { ProductAttributesFinderService } from '../../services/product-attributes-finder.service';
import { IdGenerator } from '../../services/types';

const mockName = 'Name';
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

class MockGenerator implements IdGenerator {
    index = 0;
    generate = jest.fn().mockImplementation(() => {
        return `mockId-${this.index++}`;
    });
}

class MockGeneratorFactory {
    generator = new MockGenerator();
    create() {
        return this.generator;
    }
}

@Component({
    standalone: false,
    template: `
        <mp-concrete-products-preview [attributes]="attributes">
            <span total-text></span>
            <span auto-sku-text></span>
            <span auto-name-text></span>
            <span col-attr-name></span>
            <span col-sku-name></span>
            <span col-name-name></span>
            <span no-data-text></span>
        </mp-concrete-products-preview>
    `,
})
class TestHostComponent {
    @Input() attributes: unknown;
}

describe('ConcreteProductsPreviewComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ConcreteProductsPreviewComponent, TestHostComponent],
            imports: [ScrollingModule, InvokeModule],
            schemas: [NO_ERRORS_SCHEMA],
        }).overrideComponent(ConcreteProductsPreviewComponent, {
            set: {
                providers: [
                    {
                        provide: ConcreteProductSkuGeneratorFactoryService,
                        useClass: MockGeneratorFactory,
                    },
                    {
                        provide: ConcreteProductNameGeneratorFactoryService,
                        useClass: MockGeneratorFactory,
                    },
                    ProductAttributesFinderService,
                ],
            },
        });
    });

    describe('Slots and components', () => {
        it('should render `noData` element with `no-data-text` slot if `@Input(attributes)` not exists', () => {
            const fixture = TestBed.createComponent(TestHostComponent);
            fixture.componentRef.setInput('attributes', []);
            fixture.detectChanges();
            const noDataElem = fixture.debugElement.query(By.css('.mp-concrete-products-preview__no-data'));
            const noDataTextSlot = fixture.debugElement.query(
                By.css('.mp-concrete-products-preview__no-data [no-data-text]'),
            );

            expect(noDataElem).toBeTruthy();
            expect(noDataTextSlot).toBeTruthy();
        });

        let hostFixture: ComponentFixture<TestHostComponent>;

        beforeEach(fakeAsync(() => {
            hostFixture = TestBed.createComponent(TestHostComponent);

            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.detectChanges();
            tick();
            hostFixture.detectChanges();
        }));

        it('should render <spy-chips> component with `total-text` slot to the `.mp-concrete-products-preview__header` element', () => {
            const chipsComponent = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header spy-chips'),
            );
            const totalTextSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header spy-chips [total-text]'),
            );

            expect(chipsComponent).toBeTruthy();
            expect(totalTextSlot).toBeTruthy();
        });

        it('should render <spy-checkbox> component with `auto-sku-text` slot to the `.mp-concrete-products-preview__header-checkboxes` element', () => {
            const checkboxComponent = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header-checkboxes spy-checkbox'),
            );
            const autoSkuTextSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header spy-checkbox [auto-sku-text]'),
            );

            expect(checkboxComponent).toBeTruthy();
            expect(autoSkuTextSlot).toBeTruthy();
        });

        it('should render <spy-checkbox> component with `auto-name-text` slot to the `.mp-concrete-products-preview__header-checkboxes` element', () => {
            const checkboxComponent = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header-checkboxes spy-checkbox'),
            );
            const autoNameTextSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__header spy-checkbox [auto-name-text]'),
            );

            expect(checkboxComponent).toBeTruthy();
            expect(autoNameTextSlot).toBeTruthy();
        });

        it('should render `col-attr-name` slot to the `.mp-concrete-products-preview__table-header` element', () => {
            const colAttrNameSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__table-header [col-attr-name]'),
            );

            expect(colAttrNameSlot).toBeTruthy();
        });

        it('should render `col-sku-name` slot to the `.mp-concrete-products-preview__table-header` element', () => {
            const colSkuNameSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__table-header [col-sku-name]'),
            );

            expect(colSkuNameSlot).toBeTruthy();
        });

        it('should render `col-name-name` slot to the `.mp-concrete-products-preview__table-header` element', () => {
            const colNameSlot = hostFixture.debugElement.query(
                By.css('.mp-concrete-products-preview__table-header [col-name-name]'),
            );

            expect(colNameSlot).toBeTruthy();
        });

        it('should render <cdk-virtual-scroll-viewport> component', () => {
            const cdkVirtualScrollViewportComponent = hostFixture.debugElement.query(
                By.css('cdk-virtual-scroll-viewport'),
            );

            expect(cdkVirtualScrollViewportComponent).toBeTruthy();
        });

        it('should render <spy-input> component to the `.mp-concrete-products-preview__table-row-sku` element', fakeAsync(() => {
            tick();
            hostFixture.detectChanges();

            const inputComponent = hostFixture.debugElement.query(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-sku spy-input'),
            );

            expect(inputComponent).toBeTruthy();
        }));

        it('should render <spy-input> component to the `.mp-concrete-products-preview__table-row-name` element', fakeAsync(() => {
            tick();
            hostFixture.detectChanges();

            const inputComponent = hostFixture.debugElement.query(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-name spy-input'),
            );

            expect(inputComponent).toBeTruthy();
        }));

        it('should render <spy-button-icon> component to the `.mp-concrete-products-preview__table-row-name` element', fakeAsync(() => {
            tick();
            hostFixture.detectChanges();

            const buttonIconComponent = hostFixture.debugElement.query(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-name spy-button-icon'),
            );

            expect(buttonIconComponent).toBeTruthy();
        }));
    });

    describe('Host functionality', () => {
        let fixture: ComponentFixture<ConcreteProductsPreviewComponent>;

        beforeEach(() => {
            fixture = TestBed.createComponent(ConcreteProductsPreviewComponent);
            fixture.componentRef.setInput('attributes', mockAttributes);
            fixture.detectChanges();
        });

        it('should render hidden <input> element with serialized generated products if `@Input(name)` exists', () => {
            fixture.componentRef.setInput('name', mockName);
            fixture.detectChanges();
            const hiddenInputElem = fixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInputElem).toBeTruthy();
            expect(hiddenInputElem.properties.name).toBe(mockName);
            expect(JSON.parse(hiddenInputElem.properties.value)).toEqual(mockGeneratedProducts);
        });

        it('should render attribute names of generated products', fakeAsync(() => {
            const expectedAttrNames = {
                firstRow: 'name11  /  name21',
                secondRow: 'name12  /  name21',
            };

            tick();
            fixture.detectChanges();

            const tableRowAttrElems = fixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-attr'),
            );

            expect(tableRowAttrElems[0].nativeElement.textContent.trim()).toBe(expectedAttrNames.firstRow);
            expect(tableRowAttrElems[1].nativeElement.textContent.trim()).toBe(expectedAttrNames.secondRow);
        }));

        it('`Autogenerate SKUs` checkbox should set generated value to inputs', fakeAsync(() => {
            const expectedSkuValues = {
                firstRow: 'mockId-0',
                secondRow: 'mockId-1',
            };

            tick();
            fixture.detectChanges();

            const checkboxComponents = fixture.debugElement.queryAll(
                By.css('.mp-concrete-products-preview__header-checkboxes spy-checkbox'),
            );
            const inputComponents = fixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-sku spy-input'),
            );
            const skuGeneratorFactory = fixture.debugElement.injector.get(
                ConcreteProductSkuGeneratorFactoryService,
            ) as unknown as MockGeneratorFactory;

            checkboxComponents[0].triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(inputComponents[0].properties.value).toBe(expectedSkuValues.firstRow);
            expect(skuGeneratorFactory.generator.generate).toHaveBeenCalledWith(expectedSkuValues.firstRow);
            expect(skuGeneratorFactory.generator.generate).not.toHaveBeenCalledWith(expectedSkuValues.secondRow);
            expect(inputComponents[1].properties.value).toBe(expectedSkuValues.secondRow);

            checkboxComponents[0].triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            const updatedInputComponents = fixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-sku spy-input'),
            );

            expect(updatedInputComponents[0].properties.value).toBe('');
            expect(updatedInputComponents[1].properties.value).toBe('');
        }));

        it('`Same Name as Abstract Product` checkbox should set generated value to inputs', fakeAsync(() => {
            const expectedNameValues = {
                firstRow: 'mockId-0',
                secondRow: 'mockId-1',
            };

            tick();
            fixture.detectChanges();

            const checkboxComponents = fixture.debugElement.queryAll(
                By.css('.mp-concrete-products-preview__header-checkboxes spy-checkbox'),
            );
            const inputComponents = fixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-name spy-input'),
            );
            const nameGeneratorFactory = fixture.debugElement.injector.get(
                ConcreteProductNameGeneratorFactoryService,
            ) as unknown as MockGeneratorFactory;

            checkboxComponents[1].triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(inputComponents[0].properties.value).toBe(expectedNameValues.firstRow);
            expect(nameGeneratorFactory.generator.generate).toHaveBeenCalledWith(expectedNameValues.firstRow);
            expect(nameGeneratorFactory.generator.generate).not.toHaveBeenCalledWith(expectedNameValues.secondRow);
            expect(inputComponents[1].properties.value).toBe(expectedNameValues.secondRow);

            checkboxComponents[1].triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            const updatedInputComponents = fixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-name spy-input'),
            );

            expect(updatedInputComponents[0].properties.value).toBe('');
            expect(updatedInputComponents[1].properties.value).toBe('');
        }));

        it('should bound `@Input(errors)` to the `error` input of <spy-form-item> component', fakeAsync(() => {
            fixture.componentRef.setInput('generatedProducts', mockGeneratedProducts);
            fixture.componentRef.setInput('errors', mockGeneratedProductErrors);
            fixture.detectChanges();

            tick();
            fixture.detectChanges();

            const skuFormItemComponents = fixture.debugElement.queryAll(
                By.css('.mp-concrete-products-preview__table-row-sku spy-form-item'),
            );
            const nameFormItemComponents = fixture.debugElement.queryAll(
                By.css('.mp-concrete-products-preview__table-row-name spy-form-item'),
            );

            expect(skuFormItemComponents[0].properties.error).toBe(mockGeneratedProductErrors[0].errors.sku);
            expect(nameFormItemComponents[0].properties.error).toBe(mockGeneratedProductErrors[0].errors.name);
        }));

        it('should update `@Input(errors)` after removing item with errors', fakeAsync(() => {
            fixture.componentRef.setInput('generatedProducts', mockGeneratedProducts);
            fixture.componentRef.setInput('errors', mockGeneratedProductErrors);
            fixture.detectChanges();

            tick();
            fixture.detectChanges();

            const tableRowButtonElem = fixture.debugElement.query(
                By.css('.mp-concrete-products-preview__table-row-button'),
            );

            tableRowButtonElem.triggerEventHandler('click', null);
            fixture.detectChanges();

            const formItemComponent = fixture.debugElement.query(By.css('spy-form-item'));

            expect(formItemComponent.properties.error).toBeFalsy();
        }));

        it('should excludes existing products according to `@Input(existingProducts)`', fakeAsync(() => {
            const localFixture = TestBed.createComponent(ConcreteProductsPreviewComponent);

            localFixture.componentRef.setInput('existingProducts', mockExistingProducts);
            localFixture.componentRef.setInput('attributes', mockAttributes);
            localFixture.detectChanges();

            tick();
            localFixture.detectChanges();

            const existVariant = `${mockExistingProducts[0].superAttributes[0].attribute.name}  /  ${mockExistingProducts[0].superAttributes[1].attribute.name}`;
            const tableRowAttrElems = localFixture.debugElement.queryAll(
                By.css('cdk-virtual-scroll-viewport .mp-concrete-products-preview__table-row-attr'),
            );

            expect(
                tableRowAttrElems.some((item) => item.nativeElement.textContent.trim() === existVariant),
            ).toBeFalsy();
        }));
    });
});
