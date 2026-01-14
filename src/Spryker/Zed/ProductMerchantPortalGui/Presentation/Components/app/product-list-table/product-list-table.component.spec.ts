import { NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { ProductListTableComponent } from './product-list-table.component';

describe('ProductListTableComponent', () => {
    let fixture: ComponentFixture<ProductListTableComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ProductListTableComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(ProductListTableComponent);
    });

    it('should render <spy-table> component', () => {
        fixture.detectChanges();
        const tableComponent = fixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent).toBeTruthy();
    });

    it('should bound `@Input(config)` to the `config` input of <spy-table> component', () => {
        const mockTableConfig = {
            config: 'config',
            data: 'data',
            columns: 'columns',
        };
        fixture.componentRef.setInput('config', mockTableConfig);
        fixture.detectChanges();
        const tableComponent = fixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent.nativeElement.config).toEqual(mockTableConfig);
    });

    it('should bound `@Input(tableId)` to the `tableId` input of <spy-table> component', () => {
        const mockTableId = 'mockTableId';
        fixture.componentRef.setInput('tableId', mockTableId);
        fixture.detectChanges();
        const tableComponent = fixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent.nativeElement.tableId).toEqual(mockTableId);
    });
});
