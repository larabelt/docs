# Upgrade Guide
[[toc]]

## General Upgrade Instructions

Before following the specific upgrade instructions, be sure to also take these preliminary steps:

```bash
php artisan belt publish
php artisan migrate
composer clear

```

## Release Upgrades

### Upgrading to 1.2.*

Run `php artisan belt publish`

Add `"uri-js": "^3.0.2"` to the `dependencies` array in your `package.json` configuration file.

In `webpack.mix.js`, replace:

```js
mix.js('resources/assets/js/belt-all.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

```

with:


```js
mix.js('resources/assets/js/belt-all.js', 'public/js').version();
mix.sass('resources/assets/sass/app.scss', 'public/css').version();

```

Replace `resources/assets/js/belt-bootstrap.js` with:

```js
import lodash from 'lodash';
import jQuery from 'jquery';
import vue from 'vue';
import axios from 'axios';
import VueRouter from 'vue-router';
import VueResource from 'vue-resource';
import Vuex from 'vuex';

window._ = lodash;

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */
//
window.$ = jQuery;
window.jQuery = window.$;

require('admin-lte');
require('belt/core/js/adminlte/helper');
require('bootstrap-sass');

/**
 * Vue is a modern JavaScript library for building interactive web interfaces
 * using reactive data binding and reusable components. Vue's API is clean
 * and simple, leaving you to focus on building your next great project.
 */

window.Vue = vue;
window.VueRouter = VueRouter;
window.Vuex = Vuex;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios;

window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest'
};

Vue.use(Vuex);
Vue.use(VueResource);
Vue.use(VueRouter);
Vue.config.devtools = true;
```

In `config/scout.php`, add/replace the following:

```php
'driver' => env('SCOUT_DRIVER', 'null'),
```

### Upgrading to 1.3.*

The following are optional elastic-related updates.

Replace (and adjust accordingly) `config/belt/elastic/index.php` with:

```php
$host = env('ELASTIC_HOST');

return [
    'name' => env('ELASTIC_INDEX', false),
    'hosts' => $host ? [$host] : [],
    'types' => 'pages,places,events'
];
```

Add the `analysis` below to the array in `config/belt/elastic/settings.php` configuration file.

```php
'analysis' => [
        'analyzer' => [],
        'normalizer' => [
            'lower_asciifolding' => \Belt\Content\Elastic\ElasticConfigHelper::normalizer('lower_asciifolding'),
        ],
    ],
```

Replace (and adjust accordingly for applicable data types) `config/belt/mappings/pages.php` with:

```php
return [
    'properties' => [
        'id' => \Belt\Content\Elastic\ElasticConfigHelper::property('primary_key'),
        'is_active' => \Belt\Content\Elastic\ElasticConfigHelper::property('boolean'),
        'name' => \Belt\Content\Elastic\ElasticConfigHelper::property('name'),
        'slug' => \Belt\Content\Elastic\ElasticConfigHelper::property('string'),
        'template' => \Belt\Content\Elastic\ElasticConfigHelper::property('string'),
        'body' => \Belt\Content\Elastic\ElasticConfigHelper::property('text'),
        'meta_description' => \Belt\Content\Elastic\ElasticConfigHelper::property('text'),
        'meta_keywords' => \Belt\Content\Elastic\ElasticConfigHelper::property('text'),
        'meta_title' => \Belt\Content\Elastic\ElasticConfigHelper::property('text'),
        'rating' => \Belt\Content\Elastic\ElasticConfigHelper::property('float'),
        'searchable' => \Belt\Content\Elastic\ElasticConfigHelper::property('text'),
        'created_at' => \Belt\Content\Elastic\ElasticConfigHelper::property('datetime'),
        'updated_at' => \Belt\Content\Elastic\ElasticConfigHelper::property('datetime'),
    ],
];
```

Create new elastic service provider `app\Providers\BeltElasticServiceProvider.php`, and apply the desired modifiers for your project.

```php
namespace App\Providers;

use Belt;
use Illuminate\Support\ServiceProvider;

class BeltElasticServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $global = [
            Belt\Content\Elastic\Modifiers\IsActiveQueryModifier::class,
            Belt\Content\Elastic\Modifiers\NameSortModifier::class,
            Belt\Content\Elastic\Modifiers\NeedleQueryModifier::class,
        ];

        $modifiers = [
            'events' => [
                Belt\Spot\Elastic\Modifiers\RatingSortModifier::class,
            ],
            'pages' => [],
            'posts' => [],
            'places' => [
                Belt\Spot\Elastic\Modifiers\RatingSortModifier::class,
            ]
        ];

        # elastic
        foreach ($modifiers as $type => $classes) {
            Belt\Content\Elastic\ElasticEngine::addModifiers($type, array_merge($global, $classes));
        }
    }

}
```

Add `App\Providers\BeltElasticServiceProvider::class` to the `providers` array in your `config/app.php` configuration file.

Define `default_engine` in your `config/belt/search.php` configuration file, such as (`local` or `elastic`).

Find and replace `Belt\Content\Search\Elastic` with `Belt\Content\Elastic`.

Run `php artisan belt-content:elastic replace-index`

Run `php artisan belt-content:elastic import`

### Upgrading to 1.4.*

Add the following to your belt sass file `resources/assets/sass/belt.scss`:

```scss
@import "~belt/clip/sass/base";
@import "~belt/spot/sass/base";
```

Optional. For catch-all route handling, add the following to end of the `map` method in `app/Providers/RouteServiceProvider.php` file.

```php
public function map() {
    //..

    // catch-all route
    Route::middleware('web')
        ->any('{any?}', Belt\Content\Http\Controllers\CatchAllController::class . '@web')
        ->where('any', '(.*)');
}
```

Optional. To allow public user registration, modify `config/belt/core.php`:

```php
// ...
'users' => [
    'allow_public_signup' => true,
    // ...
],
```

Optional. To allow public team registration, modify `config/belt/core.php`:

```php
// ...
'users' => [
    'allow_public_signup' => true,
    // ...
],
'teams' => [
    'allow_public_signup' => true,
    // ...
],
```

Optional. To send welcome emails to users and/or teams modify `config/belt/core.php`, accordingl:.

```php
// ...
'users' => [
    'send_welcome_email' => true,
    // ...
],
'teams' => [
    'send_welcome_email' => true,
    // ...
],
```

Optional. To update welcome email content, locally overwrite these vendor views:

```
vendor/larabelt/core/resources/views/teams/emails/welcome.blade.php
vendor/larabelt/core/resources/views/teams/emails/welcome_plain.blade.php
vendor/larabelt/core/resources/views/users/emails/welcome.blade.php
vendor/larabelt/core/resources/views/users/emails/welcome_plain.blade.php
```

Optional. To add user and/or team web routes, modify `app/Providers/RouteServiceProvider.php`:

```php

    // ...
    
    public function map()
    {
        // ...

        include base_path('vendor/larabelt/core/routes/web/teams.php');
        include base_path('vendor/larabelt/core/routes/web/users.php');

        // ...
    }
    
    // ...

```

Optional. To use the front-end vuejs components for user and/or team signups, incorporate the following:

```js
import UserSignup from 'belt/core/js/users/signup';
import TeamSignup from 'belt/core/js/teams/signup';
```

### Upgrading to 1.5.*

On server, run `sudo apt-get install libpng16-dev`.

In tables that use the boolean `is_active`, ensure that any rows where `is_active=0` should in fact be inactive. 
Possible tables include categories, events, itineraries, pages, places and posts.

#### Configuration

In `.env`, incorporate:

```
MIX_LARABELT_EDITOR=tinymce
MIX_VUEJS_DEBUG=false
```

Delete `.babelrc`.

Delete `resources/js/belt-bootstrap.js`. In `resources/js/belt-all.js` incorporate:

```js
import BeltCore from 'belt/core/js/core';
import BeltClip from 'belt/clip/js/clip';
import BeltContent from 'belt/content/js/content';
import BeltGlue from 'belt/glue/js/glue';
import BeltMenu from 'belt/menu/js/menu';
import BeltSpot from 'belt/spot/js/spot';

/**
 * Additional config options
 */
window.larabelt.clip.accept = 'image/*,application/pdf,text/plain';

Vue.config.devtools = process.env.MIX_VUEJS_DEBUG;

$(document).ready(function () {
    new BeltCore([
        BeltClip,
        BeltContent,
        BeltGlue,
        BeltMenu,
        BeltSpot
    ]);
});
```

In `webpack.mix.js`, incorporate:

```js
const { mix } = require('laravel-mix');
const path = require('path');

mix.autoload({
    'axios': ['axios'],
    'jquery': ['jQuery', '$'],
    'lodash': ['_'],
    'vue': ['Vue']
})

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'resources'),
            path.resolve(__dirname, 'vendor/larabelt/core/resources'),
            path.resolve(__dirname, 'vendor/larabelt/clip/resources'),
            path.resolve(__dirname, 'vendor/larabelt/content/resources'),
            path.resolve(__dirname, 'vendor/larabelt/glue/resources'),
            path.resolve(__dirname, 'vendor/larabelt/menu/resources'),
            path.resolve(__dirname, 'vendor/larabelt/spot/resources'),
            'node_modules'
        ]
    }
});

mix.copy("node_modules/admin-lte", 'public/plugins/admin-lte', false);
mix.copy("node_modules/tinymce", 'public/plugins/tinymce', false);

/**
 * Admin JS
 */
mix.js('resources/assets/js/belt-all.js', 'public/js').version();
mix.extract(['axios', 'jquery', 'lodash', 'vue']);

/**
 * Sass
 */
mix.sass('resources/assets/sass/app.scss', 'public/css').version();mix.sass('resources/assets/sass/belt.scss', 'public/css').version();
```

In `resources/sass/belt.scss`, incorporate:

```scss
@import "~belt/core/sass/base";
@import "~belt/clip/sass/base";
@import "~belt/content/sass/base";
@import "~belt/spot/sass/base";

$fa-font-path:"~font-awesome/fonts";
@import "node_modules/font-awesome/scss/font-awesome";
```

In `package.json`, incorporate:

```json
{
  "private": true,
  "scripts": {
    "dev": "NODE_ENV=development node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "watch": "NODE_ENV=development node_modules/webpack/bin/webpack.js --watch --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js",
    "hot": "NODE_ENV=development webpack-dev-server --inline --hot --config=node_modules/laravel-mix/setup/webpack.config.js",
    "production": "NODE_ENV=production node_modules/webpack/bin/webpack.js --progress --hide-modules --config=node_modules/laravel-mix/setup/webpack.config.js"
  },
  "devDependencies": {},
  "dependencies": {
    "admin-lte": "^2.3.11",
    "axios": "^0.15.2",
    "bootstrap-sass": "^3.3.7",
    "cross-env": "^5.1.1",
    "dateformat": "^2.0.0",
    "font-awesome": "^4.7.0",
    "ionicons": "^3.0.0",
    "jquery": "^3.2.0",
    "js-cookie": "^2.1.4",
    "laravel-mix": "^1.6.1",
    "load-google-maps-api": "^1.0.0",
    "lodash": "^4.17.4",
    "moment": "^2.18.1",
    "slugify": "^1.1.0",
    "tinymce": "^4.5.5",
    "uri-js": "^3.0.2",
    "vue": "^2.5.3",
    "vue-codemirror": "^4.0.3",
    "vue-loader": "^13.5.0",
    "vue-mce": "^1.3.6",
    "vue-resource": "^1.3.4",
    "vue-router": "^3.0.1",
    "vue-tinymce-editor": "^1.4.4",
    "vuex": "^3.0.1"
  }
}

```

Replace references to `import './belt-bootstrap';` with `import 'belt/core/js/belt-bootstrap';`;

In classes that extend `Belt\Core\Policies\BaseAdminPolicy` where `create()` function exists, add 2nd argument to match base class.

Replace references to the `hasRole()` method of user objects. Replace with `can()`, as appropriate. See here for more information: 

https://github.com/JosephSilber/bouncer#cheat-sheet

#### Index Table

An index service has been added that will redundantly save select data to a common table `index`. This can be used to 
conveniently populate auto-complete data where multiple types of data are allowed. In the future, this will power a
replacement for the local search capability.

In `\App\Providers\AppServiceProvider`, add the model classes you want to synchronized in the `index` table:

```php

    // ...
    
    public function boot()
    {
        // ...

        Belt\Spot\Deal::observe(Belt\Core\Observers\IndexObserver::class);
        Belt\Spot\Event::observe(Belt\Core\Observers\IndexObserver::class);
        Belt\Spot\Place::observe(Belt\Core\Observers\IndexObserver::class);

        // ...
    }
    
    // ...

```

Optional. To update the schema of `index` to include additional columns from other types, run:

```bash
php artisan belt-core:index merge-schema --type=:type   
```

Optional. To do a batch upsert of all data of a single type, run:

```bash
php artisan belt-core:index batch-upsert --type=:type   
```

#### Admin Access

Optional. Pre-populate roles and abilities via a seeder, for example:

```php
use Belt\Core\Ability;
use Belt\Core\Role;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade;

class PermissibleSeeds extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ability::unguard();
        $abilities = [
            // core
            '*' => '*',
            '' => [
                'admin-dashboard',
            ],
            'alerts',
            'teams',
            'users',
            // clip
            'albums',
            'attachments',
            // content
            'blocks',
            'favorites',
            'handles',
            'pages',
            'posts',
            'touts',
            // glue
            'categories',
            'tags',
            // menu
            'menu-groups',
            'menu-items',
            // spot
            'amenities',
            'deals',
            'events',
            'itineraries',
            'places',
        ];
        foreach ($abilities as $entity_type => $set) {
            if (is_numeric($entity_type)) {
                $entity_type = $set;
                $set = ['*', 'create', 'view', 'update', 'delete'];
            }
            $set = is_array($set) ? $set : [$set];
            foreach ($set as $ability) {
                Ability::firstOrCreate([
                    'entity_type' => $entity_type ?: null,
                    'name' => $ability,
                    'entity_id' => null,
                ]);
            }
        }

        Role::firstOrCreate(['name' => 'super']);
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'editor']);

        BouncerFacade::allow('super')->everything();
        BouncerFacade::allow('editor')->to('admin-dashboard');
    }
}
```

Optional. Run the following, to update roles (and role assignments):

```bash
php artisan belt-core:update --v=1.5.0
```

### Upgrading to 1.6.*

In `resources/assets/sass/belt.scss`, remove:

```scss
$fa-font-path: "/fonts";
@import "node_modules/font-awesome/scss/font-awesome";
```

#### Templates

Run update commands to update template-related config files:

```bash
// Create reorganized template config directory structure in temporary folder:
php artisan belt-core:update templates create

// Updated template config files in temporary folder per new format:
php artisan belt-core:update templates update

// Move old template files into archived path, and move temporary folder in:
php artisan belt-core:update templates move

// Update blade files
php artisan belt-core:update templates views

// Update database per new templating strategies:
php artisan belt-core:update templates db

```

#### Admin Access

Replace the following event references:

```php
\Belt\Spot\Events\DealCreated::class
\Belt\Spot\Events\EventCreated::class
\Belt\Spot\Events\PlaceCreated::class

```
with: 

```php
'deals.created'
'events.created' 
'created.created' 

```

#### Welcome Emails

Remove the following configuration values:

```php
belt.core.teams.send_welcome_email
belt.core.users.send_welcome_email
```

The following listeners still exist, but cannot be enabled via configuration. Instead, add them manually to your 
`\App\Providers\EventServiceProvider`:

```php
\Belt\Core\Listeners\SendTeamWelcomeEmail::class
\Belt\Core\Listeners\SendUserWelcomeEmail::class
```

### Upgrading to 2.0.*

Follow these guides to upgrade your app to Laravel 5.5 and then Laravel 5.6:

https://laravel.com/docs/5.5/upgrade

https://laravel.com/docs/5.6/upgrade

In `composer.json`, update all larabelt packages to `2.0.*`, then:

```json
// remove from "require":

"larabelt/glue"

// optionally add to "require"

"larabelt/alert": "2.0.*",
"larabelt/elastic": "2.0.*",
"larabelt/workflow": "2.0.*"

```

Seach and Replace:

```
belt/core/js/alerts/ctlr/dismissal belt/convo/js/alerts/ctlr/dismissal
Belt\Core\Http\ViewComposers\AlertsComposer Belt\Convo\Http\ViewComposers\AlertsComposer
Belt\Content\Elastic\Modifiers Belt\Elastic\Modifiers
```