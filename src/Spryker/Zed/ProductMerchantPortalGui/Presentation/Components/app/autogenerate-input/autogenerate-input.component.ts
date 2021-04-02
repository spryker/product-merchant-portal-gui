import {
    ChangeDetectionStrategy,
    Component,
    Input,
    OnInit,
    ViewEncapsulation
} from '@angular/core';

@Component({
    selector: 'mp-autogenerate-input',
    templateUrl: './autogenerate-input.component.html',
    styleUrls: ['./autogenerate-input.component.less'],
    changeDetection: ChangeDetectionStrategy.OnPush,
    encapsulation: ViewEncapsulation.None,
    host: { class: 'mp-autogenerate-input' },
})
export class AutogenerateInputComponent implements OnInit {
    @Input() name: string;
    @Input() value: string;
    @Input() placeholder: string;
    @Input() isAutogenerate: boolean;

    defaultValue: string;

    ngOnInit(): void {
        this.defaultValue = this.value;
    }

    onCheckboxChange(checked: boolean): void {
        if (checked && this.value !== this.defaultValue) {
            this.value = this.defaultValue;
        }
    }
}