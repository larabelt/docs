# Builder

You can specify a builder class that extends `\Belt\Content\Builders\BaseBuilder`, that will run custom code when a 
new templatable object is created. For example: 

```php
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