# Upgrade Guide

- [General Instructions](#misc)
- [v 1.2.*](#v-1.2)
- [v 1.3.*](#v-1.3)
- [v 1.4.*](#v-1.4)

<a name="misc"></a>
## General Upgrade Instructions

Before following the specific upgrade instructions, be sure to also take these preliminary steps:

```
php artisan belt publish
php artisan migrate
composer clear

```

<a name="v-1.2"></a>
## Upgrading to 1.2.*

Run `php artisan belt publish`

Add `"uri-js": "^3.0.2"` to the `dependencies` array in your `package.json` configuration file.

In `webpack.mix.js`, replace:

```
mix.js('resources/assets/js/belt-all.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');

```

with:


```
mix.js('resources/assets/js/belt-all.js', 'public/js').version();
mix.sass('resources/assets/sass/app.scss', 'public/css').version();

```

Replace `resources/assets/js/belt-bootstrap.js` with:

```
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

```
'driver' => env('SCOUT_DRIVER', 'null'),

```

<a name="v-1.3"></a>
## Upgrading to 1.3.*

The following are optional elastic-related updates.

Replace (and adjust accordingly) `config/belt/elastic/index.php` with:

```
$host = env('ELASTIC_HOST');

return [
    'name' => env('ELASTIC_INDEX', false),
    'hosts' => $host ? [$host] : [],
    'types' => 'pages,places,events'
];
```

Add the `analysis` below to the array in `config/belt/elastic/settings.php` configuration file.

```
'analysis' => [
        'analyzer' => [],
        'normalizer' => [
            'lower_asciifolding' => \Belt\Content\Elastic\ElasticConfigHelper::normalizer('lower_asciifolding'),
        ],
    ],
```

Replace (and adjust accordingly for applicable data types) `config/belt/mappings/pages.php` with:

```
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

```
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

<a name="v-1.4"></a>
## Upgrading to 1.4.*
Add the following to your belt sass file `resources/assets/sass/belt.scss`.

```
@import "~belt/spot/sass/base";
```

Optionally, for catch-all route handling, add the following to end of the `map` method in `app/Providers/RouteServiceProvider.php` file.

```
public function map() {
    //..

    // catch-all route
    Route::middleware('web')
        ->any('{any?}', Belt\Content\Http\Controllers\CatchAllController::class . '@web')
        ->where('any', '(.*)');
}
```