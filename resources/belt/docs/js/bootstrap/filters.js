import terms from 'belt/content/js/filters/terms/default';
import termsAttached from 'belt/content/js/filters/terms/attached';
import termsDetached from 'belt/content/js/filters/terms/detached';

Vue.component('filter-terms', terms);
Vue.component('filter-terms-attached', termsAttached);
Vue.component('filter-terms-detached', termsDetached);