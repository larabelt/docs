module.exports = [
    {
        title: 'Prologue',
        collapsable: false,
        children: prefix('prologue', [
            'releases',
            'installation',
            'upgrade',
        ])
    },
    {
        title: 'The Basics',
        collapsable: false,
        children: prefix('basics', [
            'commands',
        ])
    },
    {
        title: 'Templating',
        collapsable: false,
        children: prefix('templates', [
            'configuration',
            'params',
            'builder'
        ])
    },
    {
        title: 'Forms',
        collapsable: false,
        children: prefix('forms', [
            'general',
        ])
    },
    {
        title: 'Content',
        collapsable: false,
        children: prefix('content', [
            'attachments',
        ])
    }
 ]

function prefix(prefix, children) {
    return children.map(child => `${prefix}/${child}`)
}