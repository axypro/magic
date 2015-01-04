# `Named`

With the help of `axy\magic\Named` can be set object name. 
The name is used primarily for debug.
For example, is displayed in the message of the exception.

You should either define a variable $ magichName:

```php
class MyClass
{
    use \axy\magic\Named;
    use \axy\magic\ReadOnly;

    protected $magicName = 'MyObject';
}

$instance = new MyClass();

$instance->x = 10; // ContainerReadOnly: MyObject is read-only
```

or override `magicGetName()`:
```php
class MyClass
{
    private $id;

    protected function magicGetName()
    {
        return 'MyObject#'.$this->id;
    }
}

$instance = new MyClass();

$instance->x = 10; // ContainerReadOnly: MyObject#10 is read-only
```

It also redefined `__toString ()`:

```php
echo $instance; // MyObject#10
```

By default, if trait `Named` is used, but `$magicName` and `$magicGetNamed` are not defined then the class name use as the name. 
