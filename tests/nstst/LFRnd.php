<?php
/**
 * @package axy\magic
 */

namespace axy\magic\tests\nstst;

class LFRnd
{
    use \axy\magic\LazyField;

    /**
     * @var int
     */
    private $rnd = 0;

    public function __construct()
    {
        $this->magicFieldsExists = [
            'one' => true,
            'two' => true,
        ];
        $this->magicFieldsStorage = [
            'one' => 1,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        if ($key === 'rnd') {
            $this->rnd++;
            return $this->rnd;
        }
        return $this->magicGet($key);
    }

    /**
     * {@inheritdoc}
     */
    public function __isset($key)
    {
        if ($key === 'rnd') {
            return true;
        }
        return $this->magicIsset($key);
    }

    /**
     * {@inheritdoc}
     */
    protected function magicCreateField($key)
    {
        switch ($key) {
            case 'two':
                return 2;
        }
        $this->magicErrorFieldNotFound($key);
    }
}
