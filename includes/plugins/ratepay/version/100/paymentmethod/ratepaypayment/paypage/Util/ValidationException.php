<?php

/**
 * PayIntelligent ValidationException Class
 *
 * @category PayIntelligent
 * @package Pi_Util
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Util_ValidationException extends Exception
{

    /**
     * A list of all exception-messages for the validation
     *
     * @var array
     */
    protected $code = array(
        100 => "The parameter profileId was not submitted as string",
        101 => "The parameter securityCode was not submitted as string",
        102 => "The parameter mobile was not submitted as string",
        103 => "The parameter companyName was not submitted as string",
        104 => "The parameter vatId was not submitted as string",
        105 => "The parameter nationality was not submitted as string",
        106 => "The parameter orderId was not submitted as string",
        107 => "The parameter name was not submitted as string",
        108 => "The parameter street was not submitted as string",
        109 => "The parameter zip was not submitted as string",
        110 => "The parameter city was not submitted as string",
        111 => "The parameter phone was not submitted as string",
        112 => "The parameter fax was not submitted as string",
        113 => "The parameter factorBank was not submitted as string",
        114 => "The parameter bankLocation was not submitted as string",
        115 => "The parameter articleNumber was not submitted as string.",
        116 => "The parameter articleName was not submitted as string.",
        117 => "The parameter firstname was not submitted as string",
        118 => "The parameter lastName was not submitted as string",
        119 => "The parameter title was not submitted as string",
        120 => "The parameter country was not submitted as string",
        121 => "The parameter id was not submitted as string",
        200 => "The parameter tax was not submitted as float",
        201 => "The parameter quantity was not submitted as integer.",
        202 => "The parameter unitPrice was not submitted as numeric value.",
        203 => "The parameter totalPrice was not submitted as numeric value.",
        204 => "The parameter tax was not submitted as numeric value.",
        205 => "The parameter amount was not submitted as nummeric",
        300 => "The parameter email was submitted with an unsupported format",
        301 => "The parameter successUrl was submitted with an unsupported format",
        302 => "The parameter failureUrl was submitted with an unsupported format",
        303 => "The parameter dateOfBirth was submitted with an unsupported format. YYYY-MM-DD is required",
        304 => "The parameter gender was submitted with an unsupported format. M,F or U is required",
        305 => "The parameter currency was submitted with an unsupported format. Uppercase is required",
        306 => "The parameter streetNumber was submitted with an unsupported format",
        400 => "toArray-method failed to convert object. Be sure to set all required data.",
        500 => 'MCC must be either "negative", "neutral", "positive" or "vip".'
    );

    /**
     * Constructor
     *
     * @param integer $errorCode
     */
    public function __construct($errorCode = null)
    {
        if (isset($errorCode)) {
            $this->_setExceptionMessage($errorCode);
        }
    }

    /**
     * Set the exception-message for the given error-code.
     *
     * @param integer $errorCode
     */
    private function _setExceptionMessage($errorCode)
    {
        if (array_key_exists($errorCode, $this->code)) {
            $this->message = $this->code[$errorCode];
        }
    }

}
