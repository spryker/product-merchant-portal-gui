import { NO_ERRORS_SCHEMA } from '@angular/core';
import { EditAbstractProductAttributesComponent } from './edit-abstract-product-attributes.component';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';

describe('EditAbstractProductAttributesComponent', () => {
    let fixture: ComponentFixture<EditAbstractProductAttributesComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [EditAbstractProductAttributesComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(EditAbstractProductAttributesComponent);
    });

    it('should render <spy-table> component', () => {
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

        expect(tableComponent.properties.config).toEqual(mockTableConfig);
    });

    it('should bound `@Input(tableId)` to the `tableId` input of <spy-table> component', () => {
        const mockTableId = 'mockTableId';
        fixture.componentRef.setInput('tableId', mockTableId);
        fixture.detectChanges();
        const tableComponent = fixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent.properties.tableId).toEqual(mockTableId);
    });
});
