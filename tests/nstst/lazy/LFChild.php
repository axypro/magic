<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst\lazy;

class LFChild extends LF
{

    public function __get($key)
    {
        if ($key === 'child') {
            return 'value child';
        }
        return parent::__get($key);
    }

    public function __isset($key)
    {
        return ($key === 'child') ? true : parent::__isset($key);
    }

    protected function magicGetDefaults()
    {
        $defaults = parent::magicGetDefaults();
        $defaults['fields']['new_static'] = 'nsv';
        $defaults['loaders']['three'] = function () {
            return 'v three';
        };
        unset($defaults['loaders']['two']);
        return $defaults;
    }

    protected function magicErrorFieldNotExist($key)
    {
        return null;
    }

    protected function magicCreateField($key)
    {
        if ($key === 'qwe') {
            return 'rty';
        }
        return parent::magicCreateField($key);
    }

    protected function magicExistsField($key)
    {
        if ($key === 'qwe') {
            return true;
        }
        return parent::magicExistsField($key);
    }
}
