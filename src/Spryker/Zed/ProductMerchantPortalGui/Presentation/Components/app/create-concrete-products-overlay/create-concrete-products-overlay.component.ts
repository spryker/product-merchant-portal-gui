import { ChangeDetectionStrategy, Component, ViewEncapsulation, Input } from '@angular/core';
import { jsonAttribute } from '@spryker/utils';

interface ProductDetails {
    name: string;
    sku: string;
}

@Component({
    standalone: false,
    selector: 'mp-create-concrete-products-overlay',
    templateUrl: './create-concrete-products-overlay.component.html',
    styleUrls: ['./create-concrete-products-overlay.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: {
        class: 'mp-create-concrete-products-overlay',
    },
})
export class CreateConcreteProductsOverlayComponent {
    @Input({ transform: jsonAttribute }) product?: ProductDetails;
}
