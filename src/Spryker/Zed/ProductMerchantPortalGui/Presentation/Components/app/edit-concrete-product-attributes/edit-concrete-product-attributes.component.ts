import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { TableConfig } from '@spryker/table';
import { jsonAttribute } from '@spryker/utils';

@Component({
    standalone: false,
    selector: 'mp-edit-concrete-product-attributes',
    templateUrl: './edit-concrete-product-attributes.component.html',
    styleUrls: ['./edit-concrete-product-attributes.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
})
export class EditConcreteProductAttributesComponent {
    @Input({ transform: jsonAttribute }) tableConfig: TableConfig;
    @Input() tableId?: string;
}
