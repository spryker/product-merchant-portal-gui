import { ChangeDetectionStrategy, Component, ViewEncapsulation, Input } from '@angular/core';
import { jsonAttribute } from '@spryker/utils';

interface ProductDetails {
    name: string;
    sku: string;
}

@Component({
    standalone: false,
    selector: 'mp-edit-abstract-product',
    templateUrl: './edit-abstract-product.component.html',
    styleUrls: ['./edit-abstract-product.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: {
        class: 'mp-edit-abstract-product',
    },
})
export class EditAbstractProductComponent {
    @Input({ transform: jsonAttribute }) product?: ProductDetails;
}
