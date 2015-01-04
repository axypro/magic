# `ReadOnly`

```php
use axy\magic\ReadOnly;

class MyContainer
{
    use ReadOnly;

    public function __get($key) 
    {
        // custom implementation
    }
}

$container = new MyContainer();

echo $container->field; // Field can be read

$container->field = 5; // Exception axy\magic\errors\ContainerReadOnly
unset($container->filed); // Similarly
```

All children of `MyContainer` will be read-only.
If you want to change this behavior then just override methods `__set()` and `__unset()`.
