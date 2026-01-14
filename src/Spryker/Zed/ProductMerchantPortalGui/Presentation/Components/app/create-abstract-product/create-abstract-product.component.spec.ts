import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CreateAbstractProductComponent } from './create-abstract-product.component';

@Component({
    standalone: false,
    template: `
        <mp-create-abstract-product>
            <span title></span>
            <span action></span>
            <span class="default-slot"></span>
        </mp-create-abstract-product>
    `,
})
class TestHostComponent {}

describe('CreateAbstractProductComponent', () => {
    let fixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [CreateAbstractProductComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(TestHostComponent);
    });

    it('should render <spy-headline> component', () => {
        fixture.detectChanges();
        const headlineComponent = fixture.debugElement.query(By.css('spy-headline'));

        expect(headlineComponent).toBeTruthy();
    });

    it('should render `title` slot to the `.mp-create-abstract-product__header` element', () => {
        fixture.detectChanges();
        const titleSlot = fixture.debugElement.query(By.css('.mp-create-abstract-product__header [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `action` slot to the `.mp-create-abstract-product__header` element', () => {
        fixture.detectChanges();
        const actionSlot = fixture.debugElement.query(By.css('.mp-create-abstract-product__header [action]'));

        expect(actionSlot).toBeTruthy();
    });

    it('should render default slot to the `.mp-create-abstract-product__content` element', () => {
        fixture.detectChanges();
        const defaultSlot = fixture.debugElement.query(By.css('.mp-create-abstract-product__content .default-slot'));

        expect(defaultSlot).toBeTruthy();
    });
});
