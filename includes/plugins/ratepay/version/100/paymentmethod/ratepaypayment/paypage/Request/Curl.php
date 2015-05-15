<?php

/**
 * Set Parameter for a Request and send them to the Paypage.
 *
 * @category PayIntelligent
 * @package PiRatepay_Paypage_Request
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Request_Curl
extends PiRatepay_Paypage_Request_RequestAbstract
{

    /**
     * Send the request to the paypage using curl.
     *
     * @param array $params
     * @return object Paypage response
     */
    public function _jsonRequest(array $params)
    {
        $params = utf8_convert_recursive($params);
        $params = json_encode($params);
        $curlInit = curl_init(parent::getUrl());
        curl_setopt($curlInit, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curlInit, CURLOPT_POST, TRUE);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlInit, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curlInit, CURLOPT_SSLVERSION, TRUE);
        curl_setopt($curlInit, CURLOPT_HTTP_VERSION, 'CURL_HTTP_VERSION_1_1');
        curl_setopt($curlInit, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($curlInit);
        return $result;
    }

    /*
 CURLOPT_SSL_VERIFYPEER => 0,
CURLOPT_SSL_VERIFYHOST => 0,
CURLOPT_SSLVERSION => 1,
CURLOPT_RETURNTRANSFER => 1,
CURLOPT_POST => 1,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     */

}
