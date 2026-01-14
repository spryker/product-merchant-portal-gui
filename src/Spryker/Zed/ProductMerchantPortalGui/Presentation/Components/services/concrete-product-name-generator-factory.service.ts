import { inject, Injectable, Injector } from '@angular/core';
import { ConcreteProductNameGeneratorProviderToken, ConcreteProductNameGeneratorToken } from './tokens';
import { ConcreteProductNameGeneratorFactory, IdGenerator } from './types';

@Injectable()
export class ConcreteProductNameGeneratorFactoryService implements ConcreteProductNameGeneratorFactory {
    private injector = inject(Injector);
    private concreteProductNameGeneratorProvider = inject(ConcreteProductNameGeneratorProviderToken);

    create(): IdGenerator<string> {
        const concreteProductNameGeneratorInjector = Injector.create({
            name: 'ConcreteProductNameGeneratorInjector',
            providers: [this.concreteProductNameGeneratorProvider],
            parent: this.injector,
        });

        return concreteProductNameGeneratorInjector.get(ConcreteProductNameGeneratorToken);
    }
}
