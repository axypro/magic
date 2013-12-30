<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class LF implements \ArrayAccess
{
    use \axy\magic\LazyField;
    use \axy\magic\ReadOnly;
    use \axy\magic\ArrayMagic;
    use \axy\magic\Named;

    protected $magicName = 'TestLF';

    public $requests = [];
    public $issetRequests = [];

    /**
     * {@inheritdoc}
     */
    protected function magicCreateField($key)
    {
        $this->requests[] = $key;
        if (!\preg_match('~^prop_(\d+)$~s', $key, $matches)) {
            $this->magicErrorFieldNotFound($key);
        }
        $val = (int)$matches[1];
        if ($val === 0) {
            return null;
        }
        return $val * 2;
    }

    /**
     * {@inheritdoc}
     */
    protected function magicExistsField($key)
    {
        if (!\preg_match('~^prop_(\d+)$~s', $key)) {
            return false;
        }
        $this->issetRequests[] = $key;
        return true;
    }
}
