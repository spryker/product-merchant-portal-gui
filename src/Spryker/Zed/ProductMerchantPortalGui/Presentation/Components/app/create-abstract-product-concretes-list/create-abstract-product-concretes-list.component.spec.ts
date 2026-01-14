import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CreateAbstractProductConcretesListComponent } from './create-abstract-product-concretes-list.component';

const mockForm = {
    notificationMessage: 'Test notification message',
    errorMessage: 'Test error',
    value: '',
    name: 'test_name',
    choices: [
        {
            label: 'Test 1',
            value: '1',
            hasNotificationMessage: true,
            hasError: true,
        },
        {
            label: 'Test 2',
            value: '0',
            hasNotificationMessage: false,
            hasError: true,
        },
    ],
};

@Component({
    standalone: false,
    template: `
        <mp-create-abstract-product-concretes-list [form]="form">
            <span class="default-slot"></span>
        </mp-create-abstract-product-concretes-list>
    `,
})
class TestHostComponent {
    @Input() form: any;
}

describe('CreateAbstractProductConcretesListComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [CreateAbstractProductConcretesListComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.componentRef.setInput('form', mockForm);
        hostFixture.detectChanges();
    });

    it('should render <spy-form-item> component', () => {
        const formItemComponent = hostFixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent).toBeTruthy();
    });

    it('should render <spy-radio-group> component', () => {
        const radioGroupComponent = hostFixture.debugElement.query(By.css('spy-radio-group'));

        expect(radioGroupComponent).toBeTruthy();
    });

    it('should render <spy-radio> components', () => {
        const radioComponents = hostFixture.debugElement.queryAll(By.css('spy-radio-group spy-radio'));

        expect(radioComponents).toBeTruthy();
        expect(radioComponents.length).toBe(mockForm.choices.length);
    });

    it('should render `.mp-create-abstract-product-concretes-list__notification` element', () => {
        const radioGroupComponent = hostFixture.debugElement.query(By.css('spy-radio-group'));

        radioGroupComponent.triggerEventHandler('selected', mockForm.choices[0].value);
        hostFixture.detectChanges();

        const notificationElement = hostFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification'),
        );
        const notificationIconElement = hostFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification-icon'),
        );
        const notificationMessageElement = hostFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification-message'),
        );

        expect(notificationElement).toBeTruthy();
        expect(notificationIconElement).toBeTruthy();
        expect(notificationMessageElement).toBeTruthy();
        expect(notificationMessageElement.nativeElement.textContent.trim()).toBe(mockForm.notificationMessage);
    });

    it('should render default slot', () => {
        const defaultSlot = hostFixture.debugElement.query(By.css('.default-slot'));

        expect(defaultSlot).toBeTruthy();
    });

    it('should toggle `.mp-create-abstract-product-concretes-list__notification` element visibility by <spy-radio> change event', () => {
        const radioGroupComponent = hostFixture.debugElement.query(By.css('spy-radio-group'));

        radioGroupComponent.triggerEventHandler('selected', mockForm.choices[0].value);
        hostFixture.detectChanges();

        const visibleNotificationElement = hostFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification'),
        );

        expect(visibleNotificationElement).toBeTruthy();

        radioGroupComponent.triggerEventHandler('selected', mockForm.choices[1].value);
        hostFixture.detectChanges();

        const hiddenNotificationElement = hostFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification'),
        );

        expect(hiddenNotificationElement).toBeFalsy();
    });

    it('should show `.mp-create-abstract-product-concretes-list__notification` element on init if <spy-radio> is active and `hasNotificationMessage` is true', () => {
        const mockUpdatedForm = {
            notificationMessage: mockForm.notificationMessage,
            name: mockForm.name,
            value: '1',
            choices: [...mockForm.choices],
        };
        const localFixture = TestBed.createComponent(TestHostComponent);
        localFixture.componentRef.setInput('form', mockUpdatedForm);
        localFixture.detectChanges();

        const notificationElement = localFixture.debugElement.query(
            By.css('.mp-create-abstract-product-concretes-list__notification'),
        );

        expect(notificationElement).toBeTruthy();
    });

    it('should bound `errorMessage` to the `error` input of <spy-form-item> component', () => {
        const formItemComponent = hostFixture.debugElement.query(By.css('spy-form-item'));

        expect(formItemComponent.properties.error).toBe(mockForm.errorMessage);
    });

    it('should bound `value` and `name` to the appropriate inputs of <spy-radio-group> component', () => {
        const radioGroupComponent = hostFixture.debugElement.query(By.css('spy-radio-group'));

        expect(radioGroupComponent.properties.value).toBe(mockForm.value);
        expect(radioGroupComponent.properties.name).toBe(mockForm.name);
    });

    it('should bound `value` and `hasError` to the appropriate inputs of <spy-radio> components', () => {
        const radioComponents = hostFixture.debugElement.queryAll(By.css('spy-radio-group spy-radio'));

        expect(radioComponents[0].properties.value).toBe(mockForm.choices[0].value);
        expect(radioComponents[0].properties.hasError).toBe(mockForm.choices[0].hasError);
        expect(radioComponents[0].nativeElement.textContent.trim()).toBe(mockForm.choices[0].label);

        expect(radioComponents[1].properties.value).toBe(mockForm.choices[1].value);
        expect(radioComponents[1].properties.hasError).toBe(mockForm.choices[1].hasError);
        expect(radioComponents[1].nativeElement.textContent.trim()).toBe(mockForm.choices[1].label);
    });
});
