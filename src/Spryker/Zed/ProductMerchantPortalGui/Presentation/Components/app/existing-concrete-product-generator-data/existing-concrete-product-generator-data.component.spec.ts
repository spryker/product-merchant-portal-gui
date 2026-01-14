import { NO_ERRORS_SCHEMA } from '@angular/core';
import { ExistingConcreteProductGeneratorDataComponent } from './existing-concrete-product-generator-data.component';
import { ComponentFixture, TestBed } from '@angular/core/testing';

describe('ExistingConcreteProductGeneratorDataComponent', () => {
    let fixture: ComponentFixture<ExistingConcreteProductGeneratorDataComponent>;

    beforeEach(() => {
        TestBed.configureTestingModule({
            declarations: [ExistingConcreteProductGeneratorDataComponent],
            schemas: [NO_ERRORS_SCHEMA],
        });

        fixture = TestBed.createComponent(ExistingConcreteProductGeneratorDataComponent);
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

    it('`getExistingProducts` method should return value from `@Input(existingProducts)`', () => {
        const expectedExistingProducts = [
            {
                name: '',
                sku: '',
                superAttributes: [
                    {
                        name: 'name1',
                        value: 'value1',
                        attribute: {
                            name: 'name12',
                            value: 'value12',
                        },
                    },
                    {
                        name: 'name2',
                        value: 'value2',
                        attribute: {
                            name: 'name21',
                            value: 'value21',
                        },
                    },
                ],
            },
        ];
        fixture.componentRef.setInput('existingProducts', expectedExistingProducts);
        fixture.detectChanges();

        expect(fixture.componentInstance.getExistingProducts()).toEqual(expectedExistingProducts);
    });
});
