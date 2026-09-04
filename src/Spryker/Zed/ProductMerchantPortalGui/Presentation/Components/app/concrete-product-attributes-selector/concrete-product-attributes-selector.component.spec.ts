import { NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { InvokeModule } from '@spryker/utils';
import { ConcreteProductAttributesSelectorComponent } from './concrete-product-attributes-selector.component';

const mockName = 'Name';
const mockPlaceholder = 'Placeholder';
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
const mockAttributeErrors = [
    {
        error: 'attribute error',
    },
];

describe('ConcreteProductAttributesSelectorComponent', () => {
    let fixture: ComponentFixture<ConcreteProductAttributesSelectorComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ConcreteProductAttributesSelectorComponent],
            imports: [InvokeModule],
            schemas: [NO_ERRORS_SCHEMA],
        });
        fixture = TestBed.createComponent(ConcreteProductAttributesSelectorComponent);
        fixture.componentRef.setInput('attributes', mockAttributes);
        fixture.componentRef.setInput('selectedAttributes', []);
        fixture.detectChanges();
    });

    it(`should render <spy-form-item> component with '${mockAttributes[0].name}' text`, () => {
        const formItemComponent = fixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent.nativeElement.textContent.trim()).toBe(mockAttributes[0].name);
    });

    it(`should render ${mockAttributes.length} <spy-form-item> components with <spy-select> component inside`, () => {
        const selectComponents = fixture.debugElement.queryAll(By.css('spy-form-item spy-select'));

        expect(selectComponents.length).toBe(mockAttributes.length);
    });

    describe('<spy-select>', () => {
        it(`should have 'multiple' and 'control' attributes`, () => {
            const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

            expect('multiple' in selectComponent.attributes).toBeTruthy();
            expect('control' in selectComponent.attributes).toBeTruthy();
        });

        it(`should have 'options' attribute with '${mockAttributes[0].attributes.length}' items`, () => {
            const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

            expect(selectComponent.properties.options.length).toBe(mockAttributes[0].attributes.length);
        });

        it(`should have 'value' attribute with '${mockSelectedAttributes[0].attributes[0].value}'`, () => {
            fixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
            fixture.detectChanges();
            const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

            expect(selectComponent.properties.value[0]).toBe(mockSelectedAttributes[0].attributes[0].value);
        });

        it(`should have 'placeholder' attribute with '${mockPlaceholder}'`, () => {
            fixture.componentRef.setInput('placeholder', mockPlaceholder);
            fixture.detectChanges();
            const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

            expect(selectComponent.properties.placeholder).toBe(mockPlaceholder);
        });
    });

    it(`should render hidden <input> element with serialized selected attributes if '@Input(name) exists'`, () => {
        fixture.componentRef.setInput('selectedAttributes', mockSelectedAttributes);
        fixture.componentRef.setInput('name', mockName);
        fixture.detectChanges();
        const hiddenInputElem = fixture.debugElement.query(By.css('input[type=hidden]'));

        expect(hiddenInputElem).toBeTruthy();
        expect(hiddenInputElem.properties.name).toBe(mockName);
        expect(JSON.parse(hiddenInputElem.properties.value)[0]).toStrictEqual(mockSelectedAttributes[0]);
    });

    it('should bound `@Input(errors)` to the `error` input of <spy-form-item> component', () => {
        fixture.componentRef.setInput('errors', mockAttributeErrors);
        fixture.detectChanges();
        const formItemComponent = fixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent.properties.error).toBe(mockAttributeErrors[0].error);
    });

    it('should remove `error` property of <spy-form-item> component after update select changing', () => {
        fixture.componentRef.setInput('errors', mockAttributeErrors);
        fixture.detectChanges();
        const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

        selectComponent.triggerEventHandler('valueChange', [mockSelectedAttributes[0].attributes[0].value]);
        fixture.detectChanges();

        const formItemComponent = fixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent.properties.error).toBeFalsy();
    });

    it(`should emit 'selectedAttributesChange' output by select change`, () => {
        const expectedSelectedAttributes = [
            mockSelectedAttributes[0],
            {
                name: 'name2',
                value: 'value2',
                attributes: [],
            },
        ];
        fixture.componentRef.setInput('name', mockName);
        fixture.detectChanges();
        const selectComponent = fixture.debugElement.query(By.css('spy-form-item spy-select'));

        const spy = jest.fn();
        fixture.componentInstance.selectedAttributesChange.subscribe(spy);
        selectComponent.triggerEventHandler('valueChange', [mockSelectedAttributes[0].attributes[0].value]);
        fixture.detectChanges();

        expect(spy).toHaveBeenCalledWith(expectedSelectedAttributes);
    });
});
