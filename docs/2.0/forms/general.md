# General Forms
[[toc]]

## Single Step Forms
Create the form extension class (example App\Forms\Contact\Extension::class)
```php
<?php

namespace Belt\Core\Forms\Contact;

use Belt;

/**
 * Class Template
 * @package Belt\Core\Forms\Contact
 */
class Extension extends Belt\Core\Forms\BaseForm
{

    /**
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'email' => '',
        'comments' => '',
    ];

    /**
     * @var array
     */
    protected $rules = [
        'store' => [
            'name' => 'required',
            'email' => 'required|email',
            'comments' => 'required',
        ],
    ];

}
```

Create subtype in config>belt>subtypes>forms
```php
<?php

return [
    'autoresponder' => [
        'from' => [
            'email' => env('FORMS_CONTACT_AUTORESPONDER_FROM_EMAIL', env('MAIL_FROM_ADDRESS')),
            'name' => env('FORMS_CONTACT_AUTORESPONDER_FROM_NAME', env('MAIL_FROM_NAME')),
        ]
    ],
    'extension' => \Belt\Core\Forms\Contact\Extension::class,
];
```

Register Event Listeners.
```php
    protected $listen = [
        'forms.created.contact' => [
            App\Forms\Contact\AutoResponderListener::class,
            App\Forms\Contact\NotificationListener::class,
        ],
    ];
```
The form api will automatically broadcast events for forms `forms.:event.:subtype`

Current events broadcasted are `created` and `updated`

`:subtype` can be overwritten by adding an `_event` field to your payload.



Api route: `api/v1/forms` for both post and put

## Multistep Forms