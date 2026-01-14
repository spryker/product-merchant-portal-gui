import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { jsonAttribute } from '@spryker/utils';
import { ConcreteProductPreview, ConcreteProductPreviewErrors, ProductAttribute } from '../../services/types';
import { Level } from '@spryker/headline';

@Component({
    standalone: false,
    selector: 'mp-create-multi-concrete-product',
    templateUrl: './create-multi-concrete-product.component.html',
    styleUrls: ['./create-multi-concrete-product.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: { class: 'mp-create-multi-concrete-product' },
})
export class CreateMultiConcreteProductComponent {
    @Input({ transform: jsonAttribute }) attributes: ProductAttribute[] = [];
    @Input({ transform: jsonAttribute }) selectedAttributes?: ProductAttribute[];
    @Input({ transform: jsonAttribute }) generatedProducts?: ConcreteProductPreview[];
    @Input({ transform: jsonAttribute }) generatedProductErrors?: ConcreteProductPreviewErrors[];
    @Input() productsName = '';
    @Input() attributesName = '';
    @Input() attributesPlaceholder = '';
    @Input() valuesPlaceholder = '';
    @Input() skuPlaceholder = '';
    @Input() namePlaceholder = '';
    titleLevel = Level.H5;
}
