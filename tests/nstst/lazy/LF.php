<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst\lazy;

use \axy\magic\LazyField;
use \axy\magic\ArrayMagic;
use \axy\magic\Named;
use \axy\magic\ReadOnly;

class LF implements \ArrayAccess
{
    use LazyField;
    use ArrayMagic;
    use Named;
    use ReadOnly;

    protected $magicDefaults = [
        'fields' => [
            'static_f' => 'value of static',
        ],
        'exists' => [
            'static_f' => true,
            'one' => true,
            'first' => true,
            'unkn' => false,
        ],
        'loaders' => [
            'one' => [
                'class' => __CLASS__,
                'method' => 'getSelfArgs',
                'args' => [1, 2],
            ],
            'two' => '::createTwo',
        ],
    ];

    public static $calls = [];
    private $clicks = 0;

    protected $magicName = 'TestLF';

    public function __get($key)
    {
        if ($key === 'click') {
            $this->clicks++;
            return $this->clicks;
        }
        return $this->magicGet($key);
    }

    public function __isset($key)
    {
        return ($key === 'click') ? true : $this->magicIsset($key);
    }

    public static function getSelfArgs($a, $b, $key)
    {
        self::$calls[] = 'getSelfArgs:'.$key;
        return \func_get_args();
    }

    private function createTwo($key)
    {
        self::$calls[] = 'createTwo:'.$key;
        return 'k'.$key;
    }

    public function setStatic($value)
    {
        $this->magicInit();
        $this->magicFields['fields']['static_f'] = $value;
        $this->magicFields['exists']['static_f'] = true;
    }


    protected function magicCreateField($key)
    {
        self::$calls[] = 'load:'.$key;
        $filename = __DIR__.'/'.$key.'.txt';
        if (!is_file($filename)) {
            return $this->magicErrorFieldNotExist($key);
        }
        return trim(file_get_contents($filename));
    }

    protected function magicExistsField($key)
    {
        self::$calls[] = 'isset:'.$key;
        $filename = __DIR__.'/'.$key.'.txt';
        return is_file($filename);
    }
}
