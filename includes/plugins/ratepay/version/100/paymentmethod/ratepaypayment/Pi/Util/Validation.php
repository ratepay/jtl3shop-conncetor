<?php

/**
 * PayIntelligent Validation Class
 *
 * @category PayIntelligent
 * @package Pi_Util
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class Pi_Util_Validation
{

    /**
     * Wrapper method for PHP's own is_string method.
     *
     * @param string $test
     * @return boolean
     */
    public function validateIsString($test)
    {
        return is_string($test);
    }

    /**
     * Validates if given String starts with http:// or https://
     *
     * @param string $test
     * @return boolean
     */
    public function validateStartsWithHttp($test)
    {
        return $this->validateIsString($test)
            && $this->validateWithRegex('^http[s]{0,1}:\/\/', $test);
    }

    /**
     * Wrapper method for PHP's own is_nummeric method.
     *
     * @param float $test
     * @return boolean
     */
    public function validateIsNumeric($test)
    {
        return is_numeric($test);
    }

    /**
     * Wrapper method for PHP's own is_integer method.
     *
     * @param integer $test
     * @return boolean
     */
    public function validateIsInteger($test)
    {
        return is_integer($test);
    }

    /**
     * preg_match wrapper method. Adds / at the start and the end of the
     * pattern string. Returns real boolean.
     *
     * @param string $pattern
     * @param string $test
     * @return boolean
     */
    public function validateWithRegex($pattern, $test)
    {
        return preg_match("/$pattern/", $test) === 1;
    }

    /**
     * Checks the class of an given object
     * @param object $object
     * @param string $className
     */
    public function validateObject($object, $className)
    {
        return is_a($object, $className);
    }




}
