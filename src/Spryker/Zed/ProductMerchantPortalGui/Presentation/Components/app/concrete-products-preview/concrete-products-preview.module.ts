import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ScrollingModule } from '@angular/cdk/scrolling';
import { ChipsModule } from '@spryker/chips';
import { CheckboxModule } from '@spryker/checkbox';
import { InputModule } from '@spryker/input';
import { IconModule } from '@spryker/icon';
import { ButtonModule } from '@spryker/button';
import { FormItemModule } from '@spryker/form-item';
import { InvokeModule } from '@spryker/utils';
import { ConcreteProductsPreviewComponent } from './concrete-products-preview.component';

@NgModule({
    imports: [
        CommonModule,
        ChipsModule,
        CheckboxModule,
        InputModule,
        ScrollingModule,
        IconModule,
        ButtonModule,
        FormItemModule,
        InvokeModule,
    ],
    declarations: [ConcreteProductsPreviewComponent],
    exports: [ConcreteProductsPreviewComponent],
})
export class ConcreteProductsPreviewModule {}
