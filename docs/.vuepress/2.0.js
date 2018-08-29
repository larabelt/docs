module.exports = [
    {
        title: 'The Basics',
        collapsable: false,
        children: prefix('basics', [
            'releases',
            'installation',
            'upgrade',
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
    }
 ]

function prefix(prefix, children) {
    return children.map(child => `${prefix}/${child}`)
}