# Templates

[[toc]]

## Configuration

A templateable object needs a corresponding config file. For example, to define a default template for 
`\Belt\Content\Page`, add a config file to `config\belt\templates\pages\default.php`:

```
<?php

return [

    // Required. A blade view path to the main template layout.
    'path' => 'belt-content::pages.templates.default',

    // A blade view path that can be extended by the layout found in :path.
    'extends' => 'belt-content::pages.web.show',

    // The human-readable name of your template.
    'label' => '',

    // A short description of template.
    'description' => '',

    // A builder class that extends \Belt\Content\Builders\BaseBuilder,
    // that will run custom code when a new templatable object is created.
    'builder' => \App\Builders\DefaultBuilder::class,

    // A blade layout that show can show a snapshot of what the templates structure and/or style will look like when compiled.
    'preview' => '',


    // By default, compiled views are cached. Set the value below to false, to avoid this behavior.
    'force_compile' => false,

    /*
    | A set of custom parameters that belong to the templatable object.
    |
    | Each parameters has the following configuration options:
    |
    | @type:        Required. The type of input to be used in the admin UX,
    |               ie: text, textarea, select, editor or other properly added custom values.
    |
    | @label:       The human-readable name of the parameter.
    |
    | @description: A short description of parameter.
    |
    | @options:     The list of available options where type="select". Option keys are machine-readable.
    |               Option values will be used as human-readable labels.
    */

    'params' => [
        'attachment' => [
            'type' => 'attachments',
            'label' => 'Cool Attachment',
            'description' => 'cool description',
        ],
        'body' => [
            'type' => 'editor',
            'label' => 'Body',
            'description' => 'Enter main content of page here.',
        ],
        'class' => [
            'type' => 'select',
            'options' => [
                'col-md-3' => 'default',
                'col-md-12' => 'wide',
            ],
        ],
    ],

];

```

## Parameters

As noted above in the template config examples, `params` can be added to a template.

Standard values for `type` by package, include:

```
// core:
text
textarea
select
editor

// clip:
attachments
albums

// content:
blocks
touts

// spot:
itineraries
```

## Builder

You can specify a builder class that extends `\Belt\Content\Builders\BaseBuilder`, that will run custom code when a 
new templatable object is created. For example: 

```
namespace App\Builders;

use Belt\Content\Builders\BaseBuilder;
use Belt\Clip\Attachment;

/**
 * Class DefaultBuilder
 *
 * Example class to add some sections automatically to a new sectionable item
 *
 * @package App\Builders
 */
class DefaultBuilder extends BaseBuilder
{
    public function build()
    {
        // execute custom logic here
    }

}
```