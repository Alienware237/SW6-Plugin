// <plugin root>/src/Resources/app/administration/src/module/swag-example/index.js
import './page/swag-example-list';
import './page/swag-example-detail';
import './page/swag-example-create';
import deDE from './snippet/de-DE/de-DE.json';
import enGB from './snippet/en-GB/en-GB.json';

Shopware.Module.register('swag-example', {
    type: 'plugin',
    name: 'Customer operations Log',
    title: 'Customer operations Log',
    description: 'Module to manage multiple items in shopping cart',
    color: '#ff3d58',
    icon: 'default-shopping-paper-bag-product',

    snippets: {
        'de-DE': deDE,
        'en-GB': enGB
    },

    routes: {
        list: {
            component: 'swag-example-list',
            path: 'list'
        }
    },

    navigation:[{
	id: 'swag-custummodule-list',
        label: 'swag-example.general.mainMenuItemGeneral',
        color: '#ff3d58',
        path: 'swag.example.list',
        icon: 'default-shopping-paper-bag-product',
	parent: 'sw-catalogue',
        position: 100
    }]
});

