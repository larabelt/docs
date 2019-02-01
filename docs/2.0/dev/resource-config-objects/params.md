# Params

[[toc]]

## Creating a Param

```php
<?php
namespace App\Resources\Params\Text;
use Belt;
/**
 * Class DefaultText
 * @package App\Resources\Params\Text
 */
class DefaultText extends Belt\Core\Resources\Params\Text
{
    protected $key = 'default_text';
    protected $label = 'Default Text';
    protected $description = 'Text to describe your param';
}
```

## Using A Param

## Available Base Params

### Attachment

Extends `Belt\Content\Resources\Params\BaseAttachment`

Pick an attachment to add that id to the param value

### Block

Extends `Belt\Content\Resources\Params\BaseBlock`

Pick a block to add that id to the param value

### Checkbox

Extends `Belt\Core\Resources\Params\Checkbox` 

Will give a boolean in the param value field

### Dropdown

Extends `Belt\Core\Resources\Params\DropDown`

Provides a select dropdown to add the option indexes to the param value field.
```php
    protected $options = [
        ':value' => 'Label',
    ];
```

### Editor

Extends `Belt\Core\Resources\Params\Editor`

Provides a wysiwyg editor to create html value

### Lyst

Extends `Belt\Content\Resources\Params\BaseList`

Pick a list to add that id to the param value

### Page

Extends `Belt\Content\Resources\Params\BasePage`

Pick a page to add that id to the param value

### Place

Extends `BBelt\Spot\Resources\Params\BasePlace`

Pick a place to add that id to the param value

### Text

Extends `Belt\Core\Resources\Params\Text`

Provides a text field to create param value

### Textarea

Extends `Belt\Core\Resources\Params\TextArea`

Provides a textarea field to create param value