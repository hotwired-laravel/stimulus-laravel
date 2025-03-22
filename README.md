<p align="center" style="margin-top: 2rem; margin-bottom: 2rem;"><img src="/art/stimulus-laravel-logo.svg" alt="Logo Stimulus Laravel" /></p>

<p align="center">
    <a href="https://packagist.org/packages/hotwired-laravel/stimulus-laravel">
        <img src="https://img.shields.io/packagist/v/hotwired-laravel/stimulus-laravel" alt="Latest Stable Version">
    </a>
    <a href="https://packagist.org/packages/hotwired-laravel/stimulus-laravel">
        <img src="https://img.shields.io/github/license/hotwired-laravel/stimulus-laravel" alt="License">
    </a>
</p>

<a name="introduction"></a>
## Introduction

[Stimulus](https://stimulus.hotwired.dev/) is a JavaScript framework with modest ambitions. It doesn’t seek to take over your entire front-end in fact, it’s not concerned with rendering HTML at all. Instead, it’s designed to augment your HTML with just enough behavior to make it shine. Stimulus pairs beautifully with Turbo to provide a complete solution for fast, compelling applications with a minimal amount of effort. Together they form the core of [Hotwire](https://hotwired.dev/).

Stimulus for Laravel makes it easy to use this modest framework with both import-mapped and JavaScript-bundled apps. It relies on either [Importmap Laravel](https://github.com/tonysm/importmap-laravel) to make Stimulus available via ESM or a Node-capable [Laravel using Vite](https://laravel.com/docs/9.x/vite) to include Stimulus in the bundle. Make sure to install one of these first!

#### Inspiration

This package was inspired by the [stimulus-rails gem](https://github.com/hotwired/stimulus-rails).

## Installation Steps

Stimulus Laravel may be installed via composer:

```bash
composer require hotwired-laravel/stimulus-laravel
```

Next, if you're on a fresh Laravel app (see the [#manual-installation](#manual-installation) if you're not), you may run install command:

```bash
php artisan stimulus:install
```

That's it. The install command will automatically detect if you're using [Importmap Laravel](https://github.com/tonysm/importmap-laravel) or [Vite](https://vitejs.dev/) to manage your JavaScript dependencies. If you're using Importmap Laravel, we're pinning the Stimulus dependency and publishing a local dependency to your `public/vendor` folder and pinning it so you don't have to register Stimulus controllers. If you're using Vite, we'll add the Stimulus dependecy to your `package.json`.

The install command generates a `resources/js/libs/stimulus.js` file that installs Stimulus. It will also create a `resources/js/libs/index.js` that ensures the `resources/js/controllers/index.js` module is imported.

When using Importmap Laravel, the `resources/js/controllers/index.js` will use the published `stimulus-loading` dependency to either eager load or lazy load your Stimulus controller registrations automatically, so you don't have to manually register them. When using Vite, that file will be auto-generated whenever you make a new Stimulus controller or whenever you run the `php artisan stimulus:manifest` manually.

### Making a New Controller

To make a new Stimulus controller, run:

```bash
php artisan stimulus:make hello_controller
```

This should create the controller for you. When using Vite, it will also regenerate the `resources/js/controllers/index.js` file to register your newly created Stimulus controller automatically.

There's also a hint comment on how you may use the controller in the DOM, something like this:

```js
import { Controller } from "@hotwired/stimulus"

// Connects to data-controller="hello"
export default class extends Controller {
    connect() {
    }
}
```

### Making a new Hotwire Native Bridge Component

You may use the same `stimulus:make` command to generate a Hotwire Native Bridge component by passing the `--bridge=` option with the name of the native component. For instance, if you're working on a native Toast component, you may create it like:

```bash
php artisan stimulus:make bridge/toast_controller --bridge=toast
```

This should create a file for you using the bridge scaffolding. When using Vite, it will also generate the `resources/js/controllers/index.js` file to register your newly created Stimulus Bridge Component automatically.

Like regular Stimulus controllers, there's also a hint comment on how you may use the controller in the DOM:

```js
import { BridgeComponent, BridgeElement } from "@hotwired/hotwire-native-bridge"

// Connects to data-controller="bridge--toast"
export default class extends BridgeComponent {
    static component = "toast"

    //
}
```

### Regenerate the Manifest

The `stimulus:make` command will regenerate the `resources/js/controllers/index.js` file for you, registering all your controllers. If you want to manually trigger a regeneration, you may run:

```bash
php artisan stimulus:manifest
```

## Manual Installation

If you're installing the package on an pre-existing Laravel app, it may be useful to manually install it step by step.

If you're using Importmap Laravel, follow the [Importmap Steps](#importmap-steps), otherwise follow the [Vite steps](#vite-steps).

1. Either way, you need to install the lib via composer first:

```bash
composer require hotwired-laravel/stimulus-laravel
```

### Importmap Steps

2. Create `resources/js/controllers/index.js` and load your controllers like this:

```js
import { Stimulus } from 'libs/stimulus'

// Eager load all controllers defined in the import map under controllers/**/*_controller
import { eagerLoadControllersFrom } from '@hotwired/stimulus-loading'
eagerLoadControllersFrom('controllers', Stimulus)
```

3. Create a `resources/js/libs/stimulus.js` with the following content:

```js
import { Application } from '@hotwired/stimulus'

const Stimulus = Application.start()

// Configure Stimulus development experience
Stimulus.debug = false

window.Stimulus = Stimulus

export { Stimulus }
```

4. Create a `resources/js/libs/index.js` file with the following content (or add it to an existing file if you have one):

```js
import 'controllers'
```

5. Add the following line to your `resources/js/app.js` file:

```js
import 'libs'
```

6. Publish the vendor dependencies:

```bash
php artisan vendor:publish --tag=stimulus-laravel-assets
```

7. Pin the Stimulus dependency:

```bash
php artisan importmap:pin @hotwired/stimulus
```

8. Finally, pin the `stimulus-loading` dependency on your `routes/importmap.php` file:

```php
Importmap::pin("@hotwired/stimulus-loading", to: "vendor/stimulus-laravel/stimulus-loading.js", preload: true);
```

### Vite Steps

1. Create a `resources/js/controllers/index.js` and chose if you want to register your controllers manually or not:

    #### Register controllers manually
  
    ```js
    // This file is auto-generated by `php artisan stimulus:install`
    // Run that command whenever you add a new controller or create them with
    // `php artisan stimulus:make controllerName`

    import { Stimulus } from '../libs/stimulus'

    import HelloController from './hello_controller'
    Stimulus.register('hello', HelloController)
    ```

    #### Register controllers automatically
   
    If you prefer to automatially register your controllers you can use the [`stimulus-vite-helpers`](https://www.npmjs.com/package/stimulus-vite-helpers) NPM package.

    ```js
    // resources/js/controllers/index.js

    import { Stimulus } from '../libs/stimulus'
    import { registerControllers } from 'stimulus-vite-helpers'

    const controllers = import.meta.glob('./**/*_controller.js', { eager: true })

    registerControllers(Stimulus, controllers)
    ```

    And install the NPM package:

    ```bash
    npm install stimulus-vite-helpers
    ```

2. Create `resources/js/libs/stimulus.js` with the following content:

```js
import { Application } from '@hotwired/stimulus'

const Stimulus = Application.start()

// Configure Stimulus development experience
Stimulus.debug = false

window.Stimulus = Stimulus

export { Stimulus }
```

3. Create a `resources/js/libs/index.js` file (if it doesn't exist) and add the following line to it:

```js
import '../controllers'
```

4. Add the following line to your `resources/js/app.js` file:

```js
import './libs';
```

5. Finally, add the Stimulus package to NPM:

```bash
npm install @hotwired/stimulus
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Drop me an email at [tonysm@hey.com](mailto:tonysm@hey.com?subject=Security%20Vulnerability) if you want to report
security vulnerabilities.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- [Tony Messias](https://github.com/tonysm)
- [All Contributors](./CONTRIBUTORS.md)
