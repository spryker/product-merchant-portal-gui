import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { EditAbstractProductComponent } from './edit-abstract-product.component';

const mockProduct = {
    name: 'test name',
    sku: 'test sku',
};

@Component({
    standalone: false,
    template: `
        <mp-edit-abstract-product [product]="product">
            <span title></span>
            <span action></span>
            <span class="default-slot"></span>
        </mp-edit-abstract-product>
    `,
})
class TestHostComponent {
    @Input() product: any;
}

describe('EditAbstractProductComponent', () => {
    let hostFixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [EditAbstractProductComponent, TestHostComponent],
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

    it('should render `title` slot to the `.mp-edit-abstract-product__title` element', () => {
        const titleSlot = hostFixture.debugElement.query(By.css('.mp-edit-abstract-product__title [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `action` slot to the <spy-headline> component', () => {
        const actionSlot = hostFixture.debugElement.query(By.css('spy-headline [action]'));

        expect(actionSlot).toBeTruthy();
    });

    it('should render default slot to the `.mp-edit-abstract-product__content` element', () => {
        const defaultSlot = hostFixture.debugElement.query(By.css('.mp-edit-abstract-product__content .default-slot'));

        expect(defaultSlot).toBeTruthy();
    });

    it('should render `@Input(product)` data to the `.mp-edit-abstract-product__sub-title` element', () => {
        const subTitleElem = hostFixture.debugElement.query(By.css('.mp-edit-abstract-product__sub-title'));

        expect(subTitleElem.nativeElement.textContent).toContain(`${mockProduct.sku}, ${mockProduct.name}`);
    });
});
