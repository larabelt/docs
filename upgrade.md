# Upgrade Guide

- [v 1.3.*](#v-1.3)
- [v 1.2.*](#v-1.2)

<a name="v-1.3"></a>
## Upgrading to 1.3.*

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