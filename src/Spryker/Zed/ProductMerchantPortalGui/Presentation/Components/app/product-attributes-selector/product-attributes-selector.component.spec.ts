import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { InvokeModule } from '@spryker/utils';
import { ProductAttributesSelectorComponent } from './product-attributes-selector.component';

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

@Component({
    standalone: false,
    template: `
        <mp-product-attributes-selector
            [attributes]="attributes"
            [selectedAttributes]="selectedAttributes"
            [name]="name"
            (selectedAttributesChange)="selectedAttributesChange($event)"
        >
            <span col-attr-name></span>
            <span col-attr-values-name></span>
            <span btn-attr-add-name></span>
        </mp-product-attributes-selector>
    `,
})
class TestHostComponent {
    @Input() attributes: unknown;
    @Input() selectedAttributes: unknown;
    @Input() name: unknown;
    selectedAttributesChange = jest.fn();
}

describe('ProductAttributesSelectorComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [InvokeModule],
            declarations: [ProductAttributesSelectorComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });
    });

    describe('Slots and components', () => {
        let hostFixture: ComponentFixture<TestHostComponent>;

        beforeEach(() => {
            hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();
        });

        it('should render `col-attr-name` slot to the `.mp-product-attributes-selector__header` element', () => {
            const colAttrNameSlot = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__header [col-attr-name]'),
            );

            expect(colAttrNameSlot).toBeTruthy();
        });

        it('should render `col-attr-values-name` slot to the `.mp-product-attributes-selector__header` element', () => {
            const colAttrValuesNameSlot = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__header [col-attr-values-name]'),
            );

            expect(colAttrValuesNameSlot).toBeTruthy();
        });

        it('should render `btn-attr-add-name` slot to the `.mp-product-attributes-selector__button-add` element', () => {
            const btnAttrAddNameSlot = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__button-add [btn-attr-add-name]'),
            );

            expect(btnAttrAddNameSlot).toBeTruthy();
        });

        it('should render <spy-select> component to the `.mp-product-attributes-selector__content-row-name` element', () => {
            const localHostFixture = TestBed.createComponent(TestHostComponent);
            localHostFixture.componentRef.setInput('attributes', mockAttributes);
            localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            localHostFixture.detectChanges();

            const selectComponent = localHostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(selectComponent).toBeTruthy();
        });

        it('should render <spy-select> component to the `.mp-product-attributes-selector__content-row-values-name` element', () => {
            const localHostFixture = TestBed.createComponent(TestHostComponent);
            localHostFixture.componentRef.setInput('attributes', mockAttributes);
            localHostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            localHostFixture.detectChanges();

            const selectComponent = localHostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-select'),
            );

            expect(selectComponent).toBeTruthy();
        });

        it('should render <spy-button-icon> component to the `.mp-product-attributes-selector__content-row-values-name` element', () => {
            const localHostFixture = TestBed.createComponent(TestHostComponent);
            localHostFixture.componentRef.setInput('attributes', mockAttributes);
            localHostFixture.componentRef.setInput('selectedAttributes', [...mockSelectedAttributes, {}]);
            localHostFixture.detectChanges();

            const buttonIconComponent = localHostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-button-icon'),
            );

            expect(buttonIconComponent).toBeTruthy();
        });
    });

    describe('Host functionality', () => {
        it('should render hidden <input> element with serialized selected attributes if `@Input(name)` exists', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            hostFixture.componentRef.setInput('name', mockName);
            hostFixture.detectChanges();

            const hiddenInputElem = hostFixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInputElem).toBeTruthy();
            expect(hiddenInputElem.properties.name).toBe(mockName);
            expect(JSON.parse(hiddenInputElem.properties.value)).toEqual(mockSelectedAttributes);
        });

        it('should add a new attribute row by `Add` button click', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.detectChanges();

            const buttonComponent = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__button-add spy-button'),
            );
            const selectComponents = hostFixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(selectComponents.length).toBe(1);

            buttonComponent.triggerEventHandler('click', null);
            hostFixture.detectChanges();

            const updatedSelectComponents = hostFixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(updatedSelectComponents.length).toBe(2);
        });

        it('should remove attribute row by `Delete` button click', () => {
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', [...mockSelectedAttributes, {}]);
            hostFixture.componentRef.setInput('name', mockName);
            hostFixture.detectChanges();

            const buttonIconComponents = hostFixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-button-icon'),
            );
            const selectComponents = hostFixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(selectComponents.length).toBe(2);

            buttonIconComponents[0].triggerEventHandler('click', 0);
            hostFixture.detectChanges();

            const updatedSelectComponents = hostFixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(updatedSelectComponents.length).toBe(1);
        });

        it('should update selected attributes by `Super attribute` select change', () => {
            const expectedValue = 'value1';
            const expectedSelectedSuperAttribute = [
                {
                    name: 'name1',
                    value: expectedValue,
                    attributes: [],
                    isDisabled: false,
                },
            ];
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.componentRef.setInput('name', mockName);
            hostFixture.detectChanges();

            const selectComponent = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );
            const hiddenInputElem = hostFixture.debugElement.query(By.css('input[type=hidden]'));

            expect(JSON.parse(hiddenInputElem.properties.value)).toEqual([{}]);

            hostFixture.componentInstance.selectedAttributesChange = jest.fn();
            selectComponent.triggerEventHandler('valueChange', expectedValue);
            hostFixture.detectChanges();

            expect(JSON.parse(hiddenInputElem.properties.value)).toEqual(expectedSelectedSuperAttribute);
            expect(hostFixture.componentInstance.selectedAttributesChange).toHaveBeenCalledWith(
                expectedSelectedSuperAttribute,
            );
        });

        it('should update selected attributes by `Values` select change', () => {
            const expectedValue = 'value1';
            const expectedValues = {
                name: 'name11',
                value: 'value11',
            };
            const expectedSelectedSuperAttribute = [
                {
                    name: 'name1',
                    value: expectedValue,
                    attributes: [expectedValues],
                    isDisabled: false,
                },
            ];
            const hostFixture = TestBed.createComponent(TestHostComponent);
            hostFixture.componentRef.setInput('attributes', mockAttributes);
            hostFixture.componentRef.setInput('selectedAttributes', []);
            hostFixture.componentRef.setInput('name', mockName);
            hostFixture.detectChanges();

            const selectComponent = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );
            const hiddenInputElem = hostFixture.debugElement.query(By.css('input[type=hidden]'));

            hostFixture.componentInstance.selectedAttributesChange = jest.fn();
            selectComponent.triggerEventHandler('valueChange', expectedValue);
            hostFixture.detectChanges();

            const valuesSelectComponent = hostFixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-select'),
            );

            valuesSelectComponent.triggerEventHandler('valueChange', [expectedValues.value]);
            hostFixture.detectChanges();

            expect(JSON.parse(hiddenInputElem.properties.value)).toEqual(expectedSelectedSuperAttribute);
            expect(hostFixture.componentInstance.selectedAttributesChange).toHaveBeenCalledWith(
                expectedSelectedSuperAttribute,
            );
        });
    });
});
