import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { AutogenerateInputComponent } from './autogenerate-input.component';

@Component({
    standalone: false,
    template: `
        <mp-autogenerate-input>
            <span class="default-slot"></span>
        </mp-autogenerate-input>
    `,
})
class TestHostComponent {}

describe('AutogenerateInputComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [AutogenerateInputComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });
        hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();
    });

    it('should render <spy-form-item> component', () => {
        const formItemComponent = hostFixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent).toBeTruthy();
    });

    it('should render <spy-input> component to the `control` slot of <spy-form-item> component', () => {
        const inputComponent = hostFixture.debugElement.query(By.css('spy-form-item [control] spy-input'));

        expect(inputComponent).toBeTruthy();
    });

    it('should render <spy-checkbox> component', () => {
        const checkboxComponent = hostFixture.debugElement.query(By.css('spy-checkbox'));

        expect(checkboxComponent).toBeTruthy();
    });

    it('should render default slot to the <spy-checkbox> component', () => {
        const defaultSlot = hostFixture.debugElement.query(By.css('spy-checkbox .default-slot'));

        expect(defaultSlot).toBeTruthy();
    });

    describe('Component behavior', () => {
        let fixture: ComponentFixture<AutogenerateInputComponent>;

        beforeEach(() => {
            fixture = TestBed.createComponent(AutogenerateInputComponent);
        });

        it('should render hidden input if `@Input(isAutogenerate)` is true', () => {
            fixture.componentRef.setInput('isAutogenerate', true);
            fixture.detectChanges();
            const hiddenInputElem = fixture.debugElement.query(By.css('input[type=hidden]'));

            expect(hiddenInputElem).toBeTruthy();
        });

        it('should disable <spy-input> component when <spy-checkbox> component is checked', () => {
            fixture.componentRef.setInput('isAutogenerate', false);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-checkbox'));
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            expect(inputComponent.properties.disabled).toBe(false);

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(inputComponent.properties.disabled).toBe(true);
        });

        it('should change <spy-input> component value to initial `@Input(value)` when <spy-checkbox> component is checked', () => {
            const mockValue = 'Value';
            const mockNewValue = 'NewValue';
            fixture.componentRef.setInput('value', mockValue);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-checkbox'));
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            inputComponent.triggerEventHandler('valueChange', mockNewValue);
            fixture.detectChanges();

            expect(inputComponent.properties.value).toBe(mockNewValue);

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(inputComponent.properties.value).toBe(mockValue);
        });
    });

    describe('@Inputs', () => {
        let fixture: ComponentFixture<AutogenerateInputComponent>;

        beforeEach(() => {
            fixture = TestBed.createComponent(AutogenerateInputComponent);
        });

        it('should bound `@Input(name)` to the `name` input of <spy-input> component', () => {
            const mockName = 'Name';
            fixture.componentRef.setInput('name', mockName);
            fixture.detectChanges();
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            expect(inputComponent.properties.name).toBe(mockName);
        });

        it('should bound `@Input(value)` to the `value` input of <spy-input> component', () => {
            const mockValue = 'Value';
            fixture.componentRef.setInput('value', mockValue);
            fixture.detectChanges();
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            expect(inputComponent.properties.value).toBe(mockValue);
        });

        it('should bound `@Input(placeholder)` to the `placeholder` input of <spy-input> component', () => {
            const mockPlaceholder = 'Placeholder';
            fixture.componentRef.setInput('placeholder', mockPlaceholder);
            fixture.detectChanges();
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            expect(inputComponent.properties.placeholder).toBe(mockPlaceholder);
        });

        it('should bound `@Input(isAutogenerate)` to the `disabled` input of <spy-input> component', () => {
            fixture.componentRef.setInput('isAutogenerate', true);
            fixture.detectChanges();
            const inputComponent = fixture.debugElement.query(By.css('spy-input'));

            expect(inputComponent.properties.disabled).toBe(true);
        });

        it('should bound `@Input(isAutogenerate)` to the `checked` input of <spy-checkbox> component', () => {
            fixture.componentRef.setInput('isAutogenerate', true);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-checkbox'));

            expect(checkboxComponent.properties.checked).toBe(true);
        });

        it('should bound `@Input(checkboxName)` to the `name` input of <spy-checkbox> component', () => {
            const mockCheckboxName = 'checkboxName';
            fixture.componentRef.setInput('checkboxName', mockCheckboxName);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-checkbox'));

            expect(checkboxComponent.properties.name).toBe(mockCheckboxName);
        });

        it('should bound `@Input(error)` to the `error` input of <spy-form-item> component', () => {
            const mockError = 'Error';
            fixture.componentRef.setInput('error', mockError);
            fixture.detectChanges();
            const formItemComponent = fixture.debugElement.query(By.css('spy-form-item'));

            expect(formItemComponent.properties.error).toBe(mockError);
        });

        it('should add `mp-autogenerate-input--half-width` class to the component if `@Input(isFieldHasHalfWidth)` is true', () => {
            fixture.componentRef.setInput('isFieldHasHalfWidth', true);
            fixture.detectChanges();
            const componentElem = fixture.debugElement.nativeElement;

            expect(componentElem.classList.contains('mp-autogenerate-input--half-width')).toBe(true);
        });
    });
});
