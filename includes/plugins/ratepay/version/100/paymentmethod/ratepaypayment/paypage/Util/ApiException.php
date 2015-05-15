<?php

/**
 * PayIntelligent APIException Class
 *
 * @category PayIntelligent
 * @package Pi_Util
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Util_ApiException extends Exception
{

    /**
     * Constructor
     *
     * @param array $array
     */
    public function __construct(array $array = null)
    {
        if (!is_null($array)) {
            $this->_setExceptionMessage($array);
        }
    }

    /**
     * Create an Exception with the given Array.
     *
     * @param array $array
     */
    private function _setExceptionMessage(array $array)
    {
        $message = "APIException:";

        foreach ($array as $key => $value) {
            $message .= "$key - Message: $value\n";
        }

        $this->message = $message;
    }

}
