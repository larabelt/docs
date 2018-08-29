module.exports = {
    dest: 'public',
    title: 'Larabelt',
    description: 'Larabelt DeveloperDocumentation',
    themeConfig: {
        displayAllHeaders: true,
        sidebarDepth: 1,

        nav: [
            {
                text: 'Docs',
                link: '/2.0/',
            },
            {
                text: 'Version 1.5',
                link: '/1.5/'
            }
        ],

        sidebar: {
            '/1.5/': require('./1.5'),
            '/2.0/': require('./2.0'),
        },
    },
}