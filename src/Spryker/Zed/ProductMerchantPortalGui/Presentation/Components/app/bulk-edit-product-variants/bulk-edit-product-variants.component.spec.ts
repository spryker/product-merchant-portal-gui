import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CardModule } from '@spryker/card';
import { BulkEditProductVariantsComponent } from './bulk-edit-product-variants.component';

const mockStatusSection = {
    status: {
        title: 'Status',
        activationName: 'status_activationName',
        name: 'status_name',
        placeholder: 'Active',
    },
};
const mockValiditySection = {
    validity: {
        title: 'Validity Dates & Time',
        activationName: 'validity_activationName',
        name: {
            from: 'validity_formName',
            to: 'validity_toName',
        },
        placeholder: {
            from: 'formPlaceholder',
            to: 'toPlaceholder',
        },
    },
};

@Component({
    standalone: false,
    template: `
        <mp-bulk-edit-product-variants>
            <span title></span>
            <span action></span>
            <span notification></span>
        </mp-bulk-edit-product-variants>
    `,
})
class TestHostComponent {}

describe('BulkEditProductVariantsComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [BulkEditProductVariantsComponent, TestHostComponent],
            imports: [CardModule],
            schemas: [NO_ERRORS_SCHEMA],
        });
    });

    it('should render `title` slot to the <spy-headline> component', () => {
        const fixture = TestBed.createComponent(TestHostComponent);
        fixture.detectChanges();
        const titleSlot = fixture.debugElement.query(By.css('spy-headline [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `action` slot to the <spy-headline> component', () => {
        const fixture = TestBed.createComponent(TestHostComponent);
        fixture.detectChanges();
        const actionSlot = fixture.debugElement.query(By.css('spy-headline [action]'));

        expect(actionSlot).toBeTruthy();
    });

    it('should render `notification` slot to the `.mp-bulk-edit-product-variants__content` element', () => {
        const fixture = TestBed.createComponent(TestHostComponent);
        fixture.detectChanges();
        const notificationSlot = fixture.debugElement.query(
            By.css('.mp-bulk-edit-product-variants__content [notification]'),
        );

        expect(notificationSlot).toBeTruthy();
    });

    describe('Status section', () => {
        it('should render <spy-toggle> component if `sections.status` exist', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));

            expect(toggleComponent).toBeTruthy();
        });

        it('should render <spy-checkbox> component if `sections.status` exist', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent).toBeTruthy();
        });

        it('should render `sections.status.placeholder` to the <spy-toggle> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));

            expect(toggleComponent.nativeElement.textContent).toContain(mockStatusSection.status.placeholder);
        });

        it('should bound `sections.status.name` to the `name` input of <spy-toggle> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));

            expect(toggleComponent.properties.name).toBe(mockStatusSection.status.name);
        });

        it('should bound `true` to the `disabled` input of <spy-toggle> component by default', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));

            expect(toggleComponent.properties.disabled).toBe(true);
        });

        it('should render `sections.status.title` to the <spy-checkbox> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent.nativeElement.textContent).toContain(mockStatusSection.status.title);
        });

        it('should bound `sections.status.activationName` to the `name` input of <spy-checkbox> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent.properties.name).toBe(mockStatusSection.status.activationName);
        });

        it('should change <spy-toggle> component `disabled` property if `checkedChange` event of <spy-checkbox> component has been called', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(toggleComponent.properties.disabled).toBe(true);

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(toggleComponent.properties.disabled).toBe(false);

            checkboxComponent.triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            expect(toggleComponent.properties.disabled).toBe(true);
        });

        it('should reset <spy-toggle> component `value` property if `checkedChange` event of <spy-checkbox> component has been called with `false`', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockStatusSection);
            fixture.detectChanges();
            const toggleComponent = fixture.debugElement.query(By.css('spy-card spy-toggle'));
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();
            toggleComponent.triggerEventHandler('valueChange', true);
            fixture.detectChanges();

            expect(toggleComponent.properties.value).toBe(true);

            checkboxComponent.triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            expect(toggleComponent.properties.value).toBe(false);
        });
    });

    describe('Validity section', () => {
        it('should render <spy-date-range-picker> component if `sections.validity` exist', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent).toBeTruthy();
        });

        it('should render <spy-checkbox> component if `sections.status` exist', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent).toBeTruthy();
        });

        it('should bound `sections.validity.name.to` to the `nameTo` input of <spy-date-range-picker> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.nameTo).toContain(mockValiditySection.validity.name.to);
        });

        it('should bound `sections.validity.name.from` to the `nameFrom` input of <spy-date-range-picker> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.nameFrom).toContain(mockValiditySection.validity.name.from);
        });

        it('should bound `sections.validity.placeholder.to` to the `placeholderTo` input of <spy-date-range-picker> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.placeholderTo).toContain(
                mockValiditySection.validity.placeholder.to,
            );
        });

        it('should bound `sections.validity.placeholder.from` to the `placeholderFrom` input of <spy-date-range-picker> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.placeholderFrom).toContain(
                mockValiditySection.validity.placeholder.from,
            );
        });

        it('should bound `true` to the `disabled` input of <spy-date-range-picker> component by default', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.disabled).toBe(true);
        });

        it('should render `sections.validity.title` to the <spy-checkbox> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent.nativeElement.textContent).toContain(mockValiditySection.validity.title);
        });

        it('should bound `sections.validity.activationName` to the `name` input of <spy-checkbox> component', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));

            expect(checkboxComponent.properties.name).toBe(mockValiditySection.validity.activationName);
        });

        it('should change <spy-date-range-picker> component `disabled` property if `checkedChange` event of <spy-checkbox> component has been called', () => {
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            expect(dateRangePickerComponent.properties.disabled).toBe(true);

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();

            expect(dateRangePickerComponent.properties.disabled).toBe(false);

            checkboxComponent.triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            expect(dateRangePickerComponent.properties.disabled).toBe(true);
        });

        it('should reset <spy-date-range-picker> component `value` property if `checkedChange` event of <spy-checkbox> component has been called with `false`', () => {
            const mockDates = {
                from: 'from',
                to: 'to',
            };
            const fixture = TestBed.createComponent(BulkEditProductVariantsComponent);
            fixture.componentRef.setInput('sections', mockValiditySection);
            fixture.detectChanges();
            const checkboxComponent = fixture.debugElement.query(By.css('spy-card spy-checkbox'));
            const dateRangePickerComponent = fixture.debugElement.query(By.css('spy-card spy-date-range-picker'));

            checkboxComponent.triggerEventHandler('checkedChange', true);
            fixture.detectChanges();
            dateRangePickerComponent.triggerEventHandler('datesChange', mockDates);
            fixture.detectChanges();

            expect(dateRangePickerComponent.properties.dates).toEqual(mockDates);

            checkboxComponent.triggerEventHandler('checkedChange', false);
            fixture.detectChanges();

            expect(dateRangePickerComponent.properties.dates).toEqual({});
        });
    });
});
