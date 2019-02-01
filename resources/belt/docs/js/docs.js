import 'belt/content/js/bootstrap/inputs';
import 'belt/content/js/bootstrap/filters';
import 'belt/content/js/bootstrap/functions';
import 'belt/content/js/bootstrap/misc';
import 'belt/content/js/bootstrap/mixins';
import 'belt/content/js/bootstrap/tiles';

import attachments from 'belt/content/js/attachments/routes';
import blocks from 'belt/content/js/blocks/routes';
import handles from 'belt/content/js/handles/routes';
import lists from 'belt/content/js/lists/routes';
import pages from 'belt/content/js/pages/routes';
import posts from 'belt/content/js/posts/routes';
import store from 'belt/core/js/store/index';
import terms from 'belt/content/js/terms/routes';
import translatableStrings from 'belt/content/js/translatable-strings/routes';

window.larabelt.content = _.get(window, 'larabelt.content', {});

export default class BeltContent {

    constructor() {

        if ($('#belt-content').length > 0) {

            const router = new VueRouter({
                mode: 'history',
                base: '/admin/belt/content',
                routes: []
            });

            router.addRoutes(attachments);
            router.addRoutes(blocks);
            router.addRoutes(handles);
            router.addRoutes(lists);
            router.addRoutes(pages);
            router.addRoutes(posts);
            router.addRoutes(terms);
            router.addRoutes(translatableStrings);

            new Vue({router, store}).$mount('#belt-content');
        }
    }

}