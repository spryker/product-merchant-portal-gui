import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { EditConcreteProductComponent } from './edit-concrete-product.component';

@Component({
    standalone: false,
    template: `
        <mp-edit-concrete-product>
            <span title></span>
            <span name></span>
            <span action></span>
            <span sub-title></span>
            <span class="default-slot"></span>
        </mp-edit-concrete-product>
    `,
})
class TestHostComponent {}

describe('EditConcreteProductComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [EditConcreteProductComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();
    });

    it('should render <spy-headline> component', () => {
        const headlineComponent = hostFixture.debugElement.query(By.css('spy-headline'));

        expect(headlineComponent).toBeTruthy();
    });

    it('should render `title` slot to the <spy-headline> component', () => {
        const titleSlot = hostFixture.debugElement.query(By.css('spy-headline [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `name` slot to the <spy-headline> component', () => {
        const nameSlot = hostFixture.debugElement.query(By.css('spy-headline [name]'));

        expect(nameSlot).toBeTruthy();
    });

    it('should render `action` to the <spy-headline> component', () => {
        const actionSlot = hostFixture.debugElement.query(By.css('spy-headline [action]'));

        expect(actionSlot).toBeTruthy();
    });

    it('should render `sub-title` slot to the `.mp-edit-concrete-product__header` element', () => {
        const subTitleSlot = hostFixture.debugElement.query(By.css('.mp-edit-concrete-product__header [sub-title]'));

        expect(subTitleSlot).toBeTruthy();
    });

    it('should render default slot to the `.mp-edit-concrete-product__content` element', () => {
        const defaultSlot = hostFixture.debugElement.query(By.css('.mp-edit-concrete-product__content .default-slot'));

        expect(defaultSlot).toBeTruthy();
    });
});
