import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { jsonAttribute } from '@spryker/utils';

export interface EditConcreteProductImage {
    src: string;
    alt?: string;
}

@Component({
    standalone: false,
    selector: 'mp-edit-concrete-product-image-sets',
    templateUrl: './edit-concrete-product-image-sets.component.html',
    styleUrls: ['./edit-concrete-product-image-sets.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: {
        class: 'mp-edit-concrete-product-image-sets',
    },
})
export class EditConcreteProductImageSetsComponent {
    @Input({ transform: jsonAttribute }) images: EditConcreteProductImage[];
}
