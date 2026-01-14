import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CreateSingleConcreteProductComponent } from './create-single-concrete-product.component';

@Component({
    standalone: false,
    template: `
        <mp-create-single-concrete-product>
            <span title></span>
            <span action></span>
            <span class="default-slot"></span>
        </mp-create-single-concrete-product>
    `,
})
class TestHostComponent {}

describe('CreateSingleConcreteProductComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [CreateSingleConcreteProductComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();
    });

    it('should render <spy-headline> component', () => {
        const headlineComponent = hostFixture.debugElement.query(By.css('spy-headline'));

        expect(headlineComponent).toBeTruthy();
    });

    it('should render `title` slot to the `.mp-create-single-concrete-product__header` element', () => {
        const titleSlot = hostFixture.debugElement.query(By.css('.mp-create-single-concrete-product__header [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `action` slot to the `.mp-create-single-concrete-product__header` element', () => {
        const actionSlot = hostFixture.debugElement.query(
            By.css('.mp-create-single-concrete-product__header [action]'),
        );

        expect(actionSlot).toBeTruthy();
    });

    it('should render default slot to the `.mp-create-single-concrete-product__content` element', () => {
        const defaultSlot = hostFixture.debugElement.query(
            By.css('.mp-create-single-concrete-product__content .default-slot'),
        );

        expect(defaultSlot).toBeTruthy();
    });
});
