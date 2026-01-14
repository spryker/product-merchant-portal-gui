import { ChangeDetectionStrategy, Component, ViewEncapsulation, Input } from '@angular/core';
import { jsonAttribute } from '@spryker/utils';
import {
    ConcreteProductPreview,
    ConcreteProductPreviewErrors,
    ProductAttribute,
    ProductAttributeError,
} from '../../services/types';

@Component({
    standalone: false,
    selector: 'mp-create-concrete-products',
    templateUrl: './create-concrete-products.component.html',
    styleUrls: ['./create-concrete-products.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: {
        class: 'mp-create-concrete-products',
    },
})
export class CreateConcreteProductsComponent {
    @Input({ transform: jsonAttribute }) attributes: ProductAttribute[] = [];
    @Input({ transform: jsonAttribute }) selectedAttributes: ProductAttribute[] = [];
    @Input({ transform: jsonAttribute }) attributeErrors?: ProductAttributeError[];
    @Input({ transform: jsonAttribute }) existingProducts?: ConcreteProductPreview[];
    @Input({ transform: jsonAttribute }) generatedProducts?: ConcreteProductPreview[];
    @Input({ transform: jsonAttribute }) generatedProductErrors?: ConcreteProductPreviewErrors[];
    @Input() productsName?: string;
    @Input() attributesName?: string;
    @Input() attributesPlaceholder?: string;
}
