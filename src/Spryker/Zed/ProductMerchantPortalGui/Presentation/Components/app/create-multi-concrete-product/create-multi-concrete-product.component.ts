import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { ToJson } from '@spryker/utils';
import { ProductAttribute } from '../product-attributes-selector/types';
import { ConcreteProductPreview, ConcreteProductPreviewErrors } from '../concrete-products-preview/types';

@Component({
    selector: 'mp-create-multi-concrete-product',
    templateUrl: './create-multi-concrete-product.component.html',
    styleUrls: ['./create-multi-concrete-product.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: { class: 'mp-create-multi-concrete-product' },
})
export class CreateMultiConcreteProductComponent {
    @Input() @ToJson() attributes: ProductAttribute[];
    @Input() @ToJson() selectedAttributes?: ProductAttribute[];
    @Input() @ToJson() generatedProducts?: ConcreteProductPreview[];
    @Input() @ToJson() generatedProductErrors?: ConcreteProductPreviewErrors[];
    @Input() productsName: string;
    @Input() attributesName: string;
}