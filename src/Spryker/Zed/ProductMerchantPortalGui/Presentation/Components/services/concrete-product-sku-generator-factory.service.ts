import { inject, Injectable, Injector } from '@angular/core';
import { ConcreteProductSkuGeneratorProviderToken, ConcreteProductSkuGeneratorToken } from './tokens';
import { ConcreteProductSkuGeneratorFactory, IdGenerator } from './types';

@Injectable()
export class ConcreteProductSkuGeneratorFactoryService implements ConcreteProductSkuGeneratorFactory {
    private injector = inject(Injector);
    private concreteProductSkuGeneratorProvider = inject(ConcreteProductSkuGeneratorProviderToken);

    create(): IdGenerator<string> {
        const concreteProductSkuGeneratorInjector = Injector.create({
            name: 'ConcreteProductSkuGeneratorInjector',
            providers: [this.concreteProductSkuGeneratorProvider],
            parent: this.injector,
        });

        return concreteProductSkuGeneratorInjector.get(ConcreteProductSkuGeneratorToken);
    }
}
