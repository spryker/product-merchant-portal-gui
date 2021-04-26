import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { ProductAttributesSelectorComponent } from './product-attributes-selector.component';

const mockName = 'Name';
const mockAttributes = [
    {
        title: 'name1',
        value: 'value1',
        values: [
            {
                title: 'name11',
                value: 'value11',
            },
            {
                title: 'name12',
                value: 'value12',
            },
        ],
    },
    {
        title: 'name2',
        value: 'value2',
        values: [
            {
                title: 'name21',
                value: 'value21',
            },
        ],
    },
];
const mockSelectedAttributes = [
    {
        title: 'name1',
        value: 'value1',
        values: [
            {
                title: 'name11',
                value: 'value11',
            },
        ],
    },
];

@Component({
    selector: 'spy-test',
    template: `
        <mp-product-attributes-selector
            [attributes]="attributes"
            [selectedAttributes]="selectedAttributes"
            [name]="name"
            (selectedAttributesChange)="changeEvent($event)"
        >
            <span col-attr-name>Super Attribute</span>
            <span col-attr-values-name>Values</span>
            <span btn-attr-add-name>Add</span>
        </mp-product-attributes-selector>
    `,
})
class TestComponent {
    attributes: any;
    selectedAttributes: any;
    name: string;
    changeEvent = jest.fn();
}

describe('ProductAttributesSelectorComponent', () => {
    let component: TestComponent;
    let fixture: ComponentFixture<TestComponent>;

    beforeEach(async(() => {
        TestBed.configureTestingModule({
            declarations: [ProductAttributesSelectorComponent, TestComponent],
            schemas: [NO_ERRORS_SCHEMA],
        }).compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(TestComponent);
        component = fixture.componentInstance;
    });

    describe('Slots and components', () => {
        it('should render default `col-attr-name` slot to the `.mp-product-attributes-selector__header` element', () => {
            const colAttrName = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__header [col-attr-name]'),
            );

            expect(colAttrName.nativeElement.textContent).toBe('Super Attribute');
        });

        it('should render default `col-attr-values-name` slot to the `.mp-product-attributes-selector__header` element', () => {
            const colAttrValuesName = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__header [col-attr-values-name]'),
            );

            expect(colAttrValuesName.nativeElement.textContent).toBe('Values');
        });

        it('should render default `btn-attr-add-name` slot to the `.mp-product-attributes-selector__button-add` element', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = [];
            fixture.detectChanges();

            const btnAttrAddName = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__button-add [btn-attr-add-name]'),
            );

            expect(btnAttrAddName.nativeElement.textContent).toBe('Add');
        });

        it('should render <spy-select> component to the `.mp-product-attributes-selector__content-row-name` element', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = mockSelectedAttributes;
            fixture.detectChanges();

            const rowNameSelect = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(rowNameSelect).toBeTruthy();
        });

        it('should render <spy-select> component to the `.mp-product-attributes-selector__content-row-values-name` element', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = mockSelectedAttributes;
            fixture.detectChanges();

            const rowValuesNameSelect = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-select'),
            );

            expect(rowValuesNameSelect).toBeTruthy();
        });

        it('should render <spy-button> with <spy-icon> components to the `.mp-product-attributes-selector__content-row-values-name` element', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = mockSelectedAttributes;
            fixture.detectChanges();

            const rowValuesNameButton = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-button'),
            );
            const rowValuesNameButtonIcon = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-button spy-icon'),
            );

            expect(rowValuesNameButton).toBeTruthy();
            expect(rowValuesNameButtonIcon).toBeTruthy();
        });
    });

    describe('Host functionality', () => {
        it('should render <input type="hidden"> element if `@Input(name) exists`', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = mockSelectedAttributes;
            component.name = mockName;
            fixture.detectChanges();

            const hiddenInput = fixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInput).toBeTruthy();
            expect(hiddenInput.properties.name).toBe(mockName);
            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(
                JSON.stringify([...mockSelectedAttributes, {}]),
            );
        });

        it('should add a new attribute row by `Add` button click', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = [];
            fixture.detectChanges();

            const buttonAddElem = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__button-add spy-button'),
            );
            const selectElems = fixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(selectElems.length).toBe(1);

            buttonAddElem!.triggerEventHandler('click', null);
            fixture.detectChanges();

            const updatedSelectElems = fixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );

            expect(updatedSelectElems.length).toBe(2);
        });

        it('should remove attribute row by `Delete` button click', () => {
            component.attributes = mockAttributes;
            component.selectedAttributes = [...mockSelectedAttributes, {}];
            component.name = mockName;
            fixture.detectChanges();

            const buttonDeleteElems = fixture.debugElement.queryAll(
                By.css('.mp-product-attributes-selector__content-row-button'),
            );
            const hiddenInput = fixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(
                JSON.stringify([...mockSelectedAttributes, {}, {}]),
            );

            buttonDeleteElems[0].triggerEventHandler('click', 0);
            fixture.detectChanges();

            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(JSON.stringify([{}, {}]));
        });

        it('should update selected attributes by `Super attribute` select change', () => {
            const mockValue = 'value1';
            const mockSelectedSuperAttribute = [
                {
                    title: 'name1',
                    value: mockValue,
                    values: [],
                },
            ];

            component.attributes = mockAttributes;
            component.selectedAttributes = [];
            component.name = mockName;
            fixture.detectChanges();

            const selectElem = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );
            const hiddenInput = fixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(JSON.stringify([{}]));

            selectElem.triggerEventHandler('valueChange', mockValue);
            fixture.detectChanges();

            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(JSON.stringify(mockSelectedSuperAttribute));
            expect(component.changeEvent).toHaveBeenCalledWith(mockSelectedSuperAttribute);
        });

        it('should update selected attributes by `Values` select change', () => {
            const mockValue = 'value1';
            const mockValues = {
                title: 'name11',
                value: 'value11',
            };
            const mockSelectedSuperAttribute = [
                {
                    title: 'name1',
                    value: mockValue,
                    values: [mockValues],
                },
            ];

            component.attributes = mockAttributes;
            component.selectedAttributes = [];
            component.name = mockName;
            fixture.detectChanges();

            const attrSelectElem = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-name spy-select'),
            );
            const hiddenInput = fixture.debugElement.query(By.css('input[type=hidden]'));

            attrSelectElem.triggerEventHandler('valueChange', mockValue);
            fixture.detectChanges();

            const attrValuesSelectElem = fixture.debugElement.query(
                By.css('.mp-product-attributes-selector__content-row-values-name spy-select'),
            );

            attrValuesSelectElem.triggerEventHandler('valueChange', [mockValues.value]);
            fixture.detectChanges();

            expect(hiddenInput.properties.value.replace(/\s/g, '')).toBe(JSON.stringify(mockSelectedSuperAttribute));
            expect(component.changeEvent).toHaveBeenCalledWith(mockSelectedSuperAttribute);
        });
    });
});