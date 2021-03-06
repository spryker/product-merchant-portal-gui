import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HeadlineModule } from '@spryker/headline';
import { CreateMultiConcreteProductComponent } from './create-multi-concrete-product.component';
import { ProductAttributesSelectorModule } from '../product-attributes-selector/product-attributes-selector.module';
import { ConcreteProductsPreviewModule } from '../concrete-products-preview/concrete-products-preview.module';

@NgModule({
    imports: [CommonModule, HeadlineModule, ProductAttributesSelectorModule, ConcreteProductsPreviewModule],
    declarations: [CreateMultiConcreteProductComponent],
    exports: [CreateMultiConcreteProductComponent],
})
export class CreateMultiConcreteProductModule {}
