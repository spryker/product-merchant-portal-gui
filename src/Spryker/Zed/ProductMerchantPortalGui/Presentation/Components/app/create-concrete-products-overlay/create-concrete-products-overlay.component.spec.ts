import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CreateConcreteProductsOverlayComponent } from './create-concrete-products-overlay.component';

const mockProduct = {
    name: 'test name',
    sku: 'test sku',
};

@Component({
    standalone: false,
    template: `
        <mp-create-concrete-products-overlay [product]="product">
            <span title></span>
            <span action></span>
            <span class="default-slot"></span>
        </mp-create-concrete-products-overlay>
    `,
})
class TestHostComponent {
    @Input() product: unknown;
}

describe('CreateConcreteProductsOverlayComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [CreateConcreteProductsOverlayComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.componentRef.setInput('product', mockProduct);
        hostFixture.detectChanges();
    });

    it('should render <spy-headline> component', () => {
        const headlineComponent = hostFixture.debugElement.query(By.css('spy-headline'));

        expect(headlineComponent).toBeTruthy();
    });

    it('should render `title` slot to the `.mp-create-concrete-products-overlay__title` element', () => {
        const titleSlot = hostFixture.debugElement.query(By.css('.mp-create-concrete-products-overlay__title [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `action` slot to the <spy-headline> component', () => {
        const actionSlot = hostFixture.debugElement.query(By.css('spy-headline [action]'));

        expect(actionSlot).toBeTruthy();
    });

    it('should render default slot to the `.mp-create-concrete-products-overlay__content` element', () => {
        const defaultSlot = hostFixture.debugElement.query(
            By.css('.mp-create-concrete-products-overlay__content .default-slot'),
        );

        expect(defaultSlot).toBeTruthy();
    });

    it('should render `@Input(product)` data to the `.mp-create-concrete-products-overlay__sub-title` element', () => {
        const subTitleElem = hostFixture.debugElement.query(By.css('.mp-create-concrete-products-overlay__sub-title'));

        expect(subTitleElem.nativeElement.textContent).toContain(`${mockProduct.sku}, ${mockProduct.name}`);
    });
});
