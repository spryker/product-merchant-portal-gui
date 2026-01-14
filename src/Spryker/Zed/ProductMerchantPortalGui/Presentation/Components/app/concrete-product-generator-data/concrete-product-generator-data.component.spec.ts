import { NO_ERRORS_SCHEMA } from '@angular/core';
import { ConcreteProductGeneratorDataComponent } from './concrete-product-generator-data.component';
import { ComponentFixture, TestBed } from '@angular/core/testing';

describe('ConcreteProductGeneratorDataComponent', () => {
    let fixture: ComponentFixture<ConcreteProductGeneratorDataComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ConcreteProductGeneratorDataComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(ConcreteProductGeneratorDataComponent);
    });

    it('`getAbstractName` method should return value from `@Input(abstractName)`', () => {
        const expectedAbstractName = 'AbstractName';
        fixture.componentRef.setInput('abstractName', expectedAbstractName);
        fixture.detectChanges();
        expect(fixture.componentInstance.getAbstractName()).toEqual(expectedAbstractName);
    });

    it('`getAbstractSku` method should return value from `@Input(abstractSku)`', () => {
        const expectedAbstractSku = 'AbstractSku';
        fixture.componentRef.setInput('abstractSku', expectedAbstractSku);
        fixture.detectChanges();
        expect(fixture.componentInstance.getAbstractSku()).toEqual(expectedAbstractSku);
    });
});
