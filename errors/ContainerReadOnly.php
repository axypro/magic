<?php
/**
 * @package axy\magic
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\magic\errors;

/**
 * Attempt to change the read-only object
 */
class ContainerReadOnly extends \axy\errors\ContainerReadOnly implements Error
{
}
