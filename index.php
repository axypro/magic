<?php
/**
 * Work with magic fields
 *
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 * @license https://raw.github.com/axypro/magic/master/LICENSE MIT
 * @link https://github.com/axypro/magic repository
 * @link https://github.com/axypro/magic/wiki documentation
 * @link https://packagist.org/packages/axy/magic on packagist.org
 * @uses PHP5.4+
 */

namespace axy\magic;

if (!\is_file(__DIR__.'/vendor/autoload.php')) {
    throw new \LogicException('Please: composer.phar install');
}

require_once(__DIR__.'/vendor/autoload.php');
