module.exports = [
    {
        title: 'Prologue',
        collapsable: true,
        children: prefix('prologue', [
            'releases',
            'installation',
            'upgrade',
        ])
    },
    {
        title: 'The Basics',
        collapsable: true,
        children: prefix('basics', [
            'commands',
        ])
    },
    {
        title: 'Templating',
        collapsable: true,
        children: prefix('templates', [
            'configuration',
            'params',
            'builder'
        ])
    },
    {
        title: 'Forms',
        collapsable: true,
        children: prefix('forms', [
            'general',
        ])
    },
    {
        title: 'Content',
        collapsable: true,
        children: prefix('content', [
            'attachments',
        ])
    },
    {
        title: 'API',
        collapsable: true,
        children: prefix('api', [
            'overview',
            'abilities',
            'alerts',
            'amenities',
            'attachments',
            'blocks',
            'config',
            'deals',
            'events',
            'forms',
            'handles',
            'lists',
            'menu-groups',
            'overview',
            'pages',
            'places',
            'posts',
            'roles',
            'search',
            'teams',
            'terms',
            'user-favorites',
            'users',
            'work-requests',
            'workflows'
        ])
    }
 ]

function prefix(prefix, children) {
    return children.map(child => `${prefix}/${child}`)
}