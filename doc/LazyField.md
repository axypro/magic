# `LazyField`

The trait `axy\magic\LazyField` can be used to create a container with lazy fields.
Value of a lazy field is calculated at the time of first access.

Trait allows you to influence the behavior of methods `__get()` and `__isset()`.
`isset` can be supported or not, depending on the requirements of the object.

## `magicCreateField()` и `magicExistsField()`

These methods are used when other methods have failed (see below).

For example, the object fields correspond to the contents of the same name files from a specific directory:

```php
use axy\magic\LazyField;

class MyContainer
{
    use LazyField;

    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    protected function magicCreateField($key)
    {
        $filename = $this->dir.'/'.$key.'.txt';
        if (!is_file($filename)) {
            return $this->magicErrorFieldNotExist($key);
        }
        return file_get_contents($filename);
    }

    protected function magicExistsField($key)
    {
        $filename = $this->dir.'/'.$key.'.txt';
        return is_file($filename);
    }

    private $dir;
}

$instance = new MyContainer(__DIR__);

if (isset($instance->one)) { // If the file one.txt is exists
    echo $instance->one; // The content of one.txt
}
echo $instance->two; // The content of two.txt
echo $instance->one; // The content of one.txt again (from the cache)

/* The file three.txt not exists */
echo $instance->three; // FieldNotExist: 'Field "three" is not exist in "MyContainer"
```

The method `magicCreateField()` gets the field key and must return the value of it.

If the presence of this field is not implied in the object then

* Returns a default value
* Or throws a exception
* But recommended call `magicErrorFieldNotExists()` (see below)

The method `magicExistsField()` gets the key and returns whether this field exists or not.

Results of both methods are cached.
In the example, the file to be read only once.

## `$magicFields`: the current context

The protected properties `$magicFields` is an associative array with following fields:

* `fields` - a dictionary with already loaded fields.
* `exists` - the cache of requests to the `isset()`
* `loaders` - loaders for fields (see below)

If during the execution require change a property value or add new, you can do so

```php
class MyContainer
{
    // ...

    public function setX($value)
    {
        $this->magicInit();
        $this->magicFields['fields']['x'] = $value;
        $this->magicFields['exists']['x'] = true;
    }
}

$instance = new MyContainer();

if (!isset($instaince->x)) {
    $instance->setX(10);
    if (isset($instance->x)) {
        echo $instance->x; // 10
    }
}
```

It should consider the following:

* `magicInit()`. When requesting initialization properties automatically. But here require call it manualy.
* And do not forget about the cache of `exists`.

## `$magicDefaults`: preset properties

The protected property `$magicDefaults` sets the initial value for `$magicFields`.
It can be used to specify the loaders and preset values.

Example with preset (loaders see below):

```php
class MyContainer
{
    protected $magicDefault = [
        'fields' => [
            'one' => 1,
        ],
        'exists' => [
            'one' => true,
            'two' => true,
        ],
    ];
}
```

The field `one` will be taken from the cache immediately.
If the fields list is known it can be noted in `exists`.
In this case `magicExistsField()` is not twitch once again.

In this case override `magicExistsField()` is not necessarily.
By default it returns `FALSE`.

```php
if (isset($instance->two)) { // gets from cache
    echo $instance->two; // start loading
}
```

## Loaders of fields

For a concrete field you can specify the loader.

```php
class MyContainer
{
    protected $magicDefault = [
        'loaders' => [
            'x' => ['ClassCreator', 'methodCreator', [1, 2]],
            'y' => '::createY',
        ],
    ];
}
```

The key is a field name.
The value is a callback that is called to create value.

As the callback can be used

* [Standard callback](http://ru2.php.net/manual/en/language.types.callable.php)
* [Extended from axy/callbacks](https://github.com/axypro/callbacks/blob/master/doc/format.md)
* A string `::methodName` (the name of the method from this container)

The callback gets a field key as the only argument.

```php
$instance->x; // ClassCreator::methodCreator(1, 2, 'x');
$instance->y; // $instance->createY('y');
```

Field that is created using the loader is cached as well as other.

If the field is not found in the cache then primarily sought loader.
Only then the method `magicCreateField` is called.

Similarly, `isset()` first of all looks is not defined whether the loader. 
If defined then the property exists. 
If it is not defined then ask `magicExistsField()`.

## `magicGetDefaults()`

If `$magicDefaults` is not enough for your needs then you can override `magicGetDefaults()`.

```php
/**
 * MyContainer defined fields $x and $y
 */
class MyContainer
{
    protected $magicDefaults = [
        'fields' => [
            'x' => 1,
            'y' => 2,
        ],
    ];
}

/**
 * MyChild defines additional field $z and removes $y
 */
class MyChild extends MyContainer
{
    protected function magicGetDefaults()
    {
        $defaults = parent::magicGetDefaults();
        unset($defaults['fields']['y']);
        $defaults['fields']['z'] = 3;
        return $defaults;
    }
}

$instance = new MyChild(__DIR__);

echo $instance->x; // 1 - inherited
echo $instance->z; // 3 - added
echo $instance->y; // NotFound
```

## Dynamic fields with `__get()`

`__get()` and `__isset()` forwards requests to `magicGet()` and `magicIsset()`.

If you want top of the mechanism of the lazy fields add some other dynamic, it can be done as follows:

```php
class MyContainer
{
    // ...

    public function __get($key)
    {
        if ($key === 'rnd') {
            return mt_rand(10, 100);
        }
        return $this->magicGet($key);
    }

    public function __isset($key)
    {
        return ($key === 'rnd') ? true : $this->magicIsset($key);
    }
}

$instance = new MyContainer(__DIR__);

if (isset($instance->rnd)) {
    echo $instance->rnd;
    echo $instance->rnd;
    echo $instance->rnd;
}
```

## `magicErrorFieldNotExist(string $key)`

This method is called when the key is not found.
By default the exception `axy\magic\errors\FieldNotExists` will be thrown.
It can be overriden by one of the following ways:

* Throw your custom exception (recommended inherit it from `FieldNotExists`).
* Return default value (`NULL` for example).

```php
class MyContainer
{
    // ...
    protected function magicErrorFieldNotExist($key)
    {
        return '';
    }
}

$instance = new MyContainer(__DIR__);

echo $instance->three; // Well, no file - just an empty string.
```

## Combining with other traits

Example:

```php
class MyContainer implements \ArrayAccess
{
    use \axy\magic\LazyField;
    use \axy\magic\Named;
    use \axy\magic\ReadOnly;
    use \axy\magic\ArrayMagic;

    protected $magicName = 'Super-Puper-Container';
}
```

Now you can use array syntax, and attempt to write to the fields will be strongly suppressed:

```php
echo $instance['one']; // echo $instance->one;

$instance['one'] = 'new value'; // ContainerReadOnly: Super-Puper-Container is read-only
```
