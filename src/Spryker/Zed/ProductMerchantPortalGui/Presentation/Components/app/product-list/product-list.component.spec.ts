import { Component, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { ProductListComponent } from './product-list.component';

@Component({
    standalone: false,
    template: `
        <mp-product-list [tableConfig]="tableConfig" [tableId]="tableId">
            <span title></span>
            <span button-action></span>
        </mp-product-list>
    `,
})
class TestHostComponent {
    tableConfig: unknown = {};
    tableId = '';
}

describe('ProductListComponent', () => {
    let fixture: ComponentFixture<TestHostComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ProductListComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(TestHostComponent);
    });

    it('should render <mp-product-list-table> component', () => {
        fixture.detectChanges();
        const productListTableComponent = fixture.debugElement.query(By.css('mp-product-list-table'));

        expect(productListTableComponent).toBeTruthy();
    });

    it('should render <spy-headline> component', () => {
        fixture.detectChanges();
        const headlineComponent = fixture.debugElement.query(By.css('spy-headline'));

        expect(headlineComponent).toBeTruthy();
    });

    it('should render `title` slot to the <spy-headline> component', () => {
        fixture.detectChanges();
        const titleSlot = fixture.debugElement.query(By.css('spy-headline [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render `button-action` slot to the <spy-headline> component', () => {
        fixture.detectChanges();
        const buttonActionSlot = fixture.debugElement.query(By.css('spy-headline [button-action]'));

        expect(buttonActionSlot).toBeTruthy();
    });

    it('should bound `@Input(tableConfig)` to the `config` input of <mp-product-list-table> component', () => {
        const mockTableConfig = {
            config: 'config',
            data: 'data',
            columns: 'columns',
        };
        fixture.componentInstance.tableConfig = mockTableConfig;
        fixture.detectChanges();
        const productListTableComponent = fixture.debugElement.query(By.css('mp-product-list-table'));

        expect(productListTableComponent.nativeElement.config).toEqual(mockTableConfig);
    });

    it('should bound `@Input(tableId)` to the `tableId` input of <mp-product-list-table> component', () => {
        const mockTableId = 'mockTableId';
        fixture.componentInstance.tableId = mockTableId;
        fixture.detectChanges();
        const productListTableComponent = fixture.debugElement.query(By.css('mp-product-list-table'));

        expect(productListTableComponent.nativeElement.tableId).toEqual(mockTableId);
    });
});
