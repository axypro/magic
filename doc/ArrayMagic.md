# `ArrayMagic`

If a class has magic fields then you can add access to them using array syntax.

```php
use axy\magic\ArrayMagic;

class MyContainer implements \ArrayAccess
{
    use ArrayMagic;

    public function __get($key) {/* ... */};

    public function __isset($key) {/* ... */};

    public function __set($key, $value) {/* ... */};

    public function __unset($key) {/* ... */};
}

$container = new MyContainer();

/* Access by magic method */
$container->field = 10; 
echo $container->field;

/* Access to "array" */
$container['field'] = 10;
echo $container['field'];
```

Note: you still need `implements ArrayAccess`.

## Convert an array index to a magic key 

Index of "array" converts to a magic key by the method `magicConvertIndexToKey(string $key):string`.
By default, it does not change.

For example, the array index can contain a "-", and in the properties is used instead an underscore:

```php
use axy\magic\ArrayMagic;

class MyContainer implements \ArrayAccess
{
    use ArrayMagic;

    public function __get($key) {/* ... */};

    public function __isset($key) {/* ... */};

    public function __set($key, $value) {/* ... */};

    public function __unset($key) {/* ... */};

    protected function magicConvertIndexToKey($key)
    {
        return \str_replace('-', '_', $key);
    }
}
```

Using:

```php
$css['padding-top'] = 10;
echo $css->padding_top; // 10
```

## Combination

This can be combined with any other trait:

```php
class MyContainer implements \ArrayAccess
{
    use ArrayMagic;
    use ReadOnly;
}

$container = new MyContainer();

$container['field'] = 10; // error
```
