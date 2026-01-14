import { Component, Input, NO_ERRORS_SCHEMA } from '@angular/core';
import { ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { CardModule } from '@spryker/card';
import { EditAbstractProductVariantsComponent } from './edit-abstract-product-variants.component';

@Component({
    standalone: false,
    template: `
        <mp-edit-abstract-product-variants [config]="config" [tableId]="tableId">
            <span title></span>
            <span class="default-slot"></span>
        </mp-edit-abstract-product-variants>
    `,
})
class TestHostComponent {
    @Input() config: any;
    @Input() tableId: any;
}

describe('EditAbstractProductVariantsComponent', () => {
    beforeEach(() => {
        TestBed.configureTestingModule({
            imports: [CardModule],
            declarations: [EditAbstractProductVariantsComponent, TestHostComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });
    });

    it('should render <spy-card> component', () => {
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();

        const cardComponent = hostFixture.debugElement.query(By.css('spy-card'));

        expect(cardComponent).toBeTruthy();
    });

    it('should render `title` slot to the `.ant-card-head-title` element', () => {
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();

        const titleSlot = hostFixture.debugElement.query(By.css('.ant-card-head-title [title]'));

        expect(titleSlot).toBeTruthy();
    });

    it('should render default slot to the `.ant-card-extra` element', () => {
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();

        const defaultSlot = hostFixture.debugElement.query(By.css('.ant-card-extra .default-slot'));

        expect(defaultSlot).toBeTruthy();
    });

    it('should render <spy-table> component to the <spy-card> component', () => {
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.detectChanges();

        const tableComponent = hostFixture.debugElement.query(By.css('spy-card spy-table'));

        expect(tableComponent).toBeTruthy();
    });

    it('should bound `@Input(config)` to the `config` input of <spy-table> component', () => {
        const mockTableConfig = {
            config: 'config',
            data: 'data',
            columns: 'columns',
        };
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.componentRef.setInput('config', mockTableConfig);
        hostFixture.detectChanges();

        const tableComponent = hostFixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent.properties.config).toEqual(mockTableConfig);
    });

    it('should bound `@Input(tableId)` to the `tableId` input of <spy-table> component', () => {
        const mockTableId = 'mockTableId';
        const hostFixture = TestBed.createComponent(TestHostComponent);
        hostFixture.componentRef.setInput('tableId', mockTableId);
        hostFixture.detectChanges();

        const tableComponent = hostFixture.debugElement.query(By.css('spy-table'));

        expect(tableComponent.properties.tableId).toEqual(mockTableId);
    });
});
