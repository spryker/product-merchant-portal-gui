import { ChangeDetectionStrategy, Component, Input, ViewEncapsulation } from '@angular/core';
import { TableConfig } from '@spryker/table';
import { jsonAttribute } from '@spryker/utils';

@Component({
    standalone: false,
    selector: 'mp-edit-concrete-product-prices',
    templateUrl: './edit-concrete-product-prices.component.html',
    styleUrls: ['./edit-concrete-product-prices.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: { class: 'mp-edit-concrete-product-prices' },
})
export class EditConcreteProductPricesComponent {
    @Input({ transform: jsonAttribute }) tableConfig: TableConfig;
    @Input() tableId?: string;
}
