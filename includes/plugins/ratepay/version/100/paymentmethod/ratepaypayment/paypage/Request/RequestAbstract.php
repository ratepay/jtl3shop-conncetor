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
abstract class PiRatepay_Paypage_Request_RequestAbstract
{

    /**
     * JSON RPC Version
     * @var string
     */
    private $_jsonrpc = '2.0';

    /**
     * sandbox
     * @var boolean
     */
    private $_sandbox = true;

    /**
     * Url for the livesystem
     * @var string
     */
    private $_liveUrl = 'http://paymentpage-int.ratepay.com/api/1.0/rppaypageapi.php'; // http://paypage.dev/api/1.0/rppaypageapi.php

    /**
     * Url for the sandboxsystem
     * @var string
     */
    private $_sandBoxUrl = 'http://paymentpage-int.ratepay.com/api/1.0/rppaypageapi.php'; // http://paypage.dev/api/1.0/rppaypageapi.php

    /**
     * An instance of the validationclass
     * @var Validation
     */
    private $_validation = null;

    /**
     * JSON id
     * @var string
     */
    private $_jsonid;

    /**
     *
     * @param string $token
     */
    function __construct($token = null)
    {
        $this->_validation = new Pi_Util_Validation();
        if (!is_null($token)) {
            $this->setToken($token);
        }
    }

    /**
     * This function sends a request to the paypage and returns the received token
     * for further usage
     *
     * @param PiRatepay_Paypage_Model_Request $requestModel
     * @return string
     * @throws PiRatepay_Paypage_Util_ApiException
     */
    public function initialisation(PiRatepay_Paypage_Model_Request $requestModel)
    {
        $parameter['jsonrpc'] = $this->_jsonrpc;
        $parameter['method'] = 'initialisation';
        $parameter['id'] = $this->_jsonid;
        $parameter['params'] = $requestModel->toArray();

        $json = $this->_jsonRequest($parameter);
        $result = json_decode($json);

        if (isset($result->result->token)) {
            return $result->result->token;
        } else {
            die(var_dump($result));
            throw new PiRatepay_Paypage_Util_ApiException($result);
        }
    }

    /**
     * This function sends a request to the paypage and returns the received customerdata
     *
     * @param PiRatepay_Paypage_Model_Request $requestModel
     * @param string $token
     * @return PiRatepay_Paypage_Model_Customer
     * @throws PiRatepay_Paypage_Util_ApiException
     */
    public function customerData(PiRatepay_Paypage_Model_Request $requestModel, $token)
    {
        $parameter['jsonrpc'] = $this->_jsonrpc;
        $parameter['id'] = $this->_jsonid;
        $parameter['method'] = 'customerdata';
        $parameter['params'] = $requestModel->toArray();
        $parameter['params'][0]['token'] = $token;

        $result = json_decode($this->_jsonRequest($parameter));
        $help = get_object_vars($result->result);
        if (array_key_exists('errors', $help)) {
            throw new PiRatepay_Paypage_Util_ApiException(get_object_vars($help['errors']));
        } else {
            return $this->_convertCustomerDataResponse($result);
        }
    }

    /**
     * This function sends a request to the paypage and returns a boolean when its successful
     *
     * @param PiRatepay_Paypage_Model_Request $requestModel
     * @param string $token
     * @return boolean
     * @throws PiRatepay_Paypage_Util_ApiException
     */
    public function finalisation(PiRatepay_Paypage_Model_Request $requestModel, $token)
    {
        $parameter['jsonrpc'] = $this->_jsonrpc;
        $parameter['id'] = $this->_jsonid;
        $parameter['method'] = 'finalisation';
        $parameter['params'] = $requestModel->toArray();
        $parameter['params'][0]['token'] = $token;

        $result = json_decode($this->_jsonRequest($parameter));
        $help = get_object_vars($result->result);

        if (array_key_exists('errors', $help)) {
            throw new PiRatepay_Paypage_Util_ApiException(get_object_vars($help['errors']));
        } else {
            return true;
        }
    }

    /**
     * This function sends a request to the paypage and returns the received rptransactionid
     *
     * @param PiRatepay_Paypage_Model_Request $requestModel
     * @param string $token
     * @return string
     * @throws PiRatepay_Paypage_Util_ApiException
     */
    public function rptransactionid(PiRatepay_Paypage_Model_Request $requestModel, $token)
    {
        $parameter['jsonrpc'] = $this->_jsonrpc;
        $parameter['id'] = $this->_jsonid;
        $parameter['method'] = 'rptransactionid';
        $parameter['params'] = $requestModel->toArray();
        $parameter['params'][0]['token'] = $token;

        $result = json_decode($this->_jsonRequest($parameter));
        $help = get_object_vars($result->result);
        if (array_key_exists('errors', $help)) {
            throw new PiRatepay_Paypage_Util_ApiException(get_object_vars($help['errors']));
        } else {
            return $result->result->rptransactionid;
        }
    }

    /**
     * This function returns the Api-URL for the Request.
     *
     * @return string $return
     */
    final protected function getUrl()
    {
        if ($this->_sandbox) {
            $url = $this->_sandBoxUrl;
        } else {
            $url = $this->_liveUrl;
        }
        return $url;
    }

    /**
     * This function returns the value of the parameter sandbox
     *
     * @return boolean
     */
    public function getSandbox()
    {
        return $this->_sandbox;
    }

    /**
     * Activate or deactivate sandbox mode.
     * @param boolean $sandbox
     */
    public function setSandbox($sandbox)
    {
        $this->_sandbox = $sandbox;
    }

    /**
     * This function returns the value of the parameter liveUrl
     *
     * @return string
     */
    public function getLiveUrl()
    {
        return $this->_liveUrl;
    }

    /**
     * Set live url for request; default is
     * https://paymentpage.ratepay.com/api/1.0/rppaypageapi.php
     * @param string $liveUrl
     */
    public function setLiveUrl($liveUrl)
    {
        if ($this->_validation->validateStartsWithHttp($liveUrl)) {
            $this->_liveUrl = $liveUrl;
        }
    }

    /**
     * This function returns the value of the parameter sandboxUrl
     *
     * @return string
     */
    public function getSandBoxUrl()
    {
        return $this->_sandBoxUrl;
    }

    /**
     * Set sandbox url for request;
     * @param string $sandBoxUrl
     */
    public function setSandBoxUrl($sandBoxUrl)
    {
        if ($this->_validation->validateStartsWithHttp($sandBoxUrl)) {
            $this->_sandBoxUrl = $sandBoxUrl;
        }
    }

    /**
     * This function returns the value of the parameter id
     *
     * @return string
     */
    public function getId()
    {
        return $this->_jsonid;
    }

    /**
     * This function sets the value for the parameter id
     *
     * @param string $id
     * @throws PiRatepay_Paypage_Util_ValidationException
     */
    public function setId($id)
    {
        if ($this->_validation->validateIsString($id)) {
            $this->_jsonid = $id;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(121);
        }
    }

    /**
     * This function converts the response from the JSONrequest to an valid Instance of the 'PiRatepay_Paypage_Model_Customer'-class.
     *
     * @param array $customerData
     */
    private function _convertCustomerDataResponse($customerData)
    {
        $billingAddress = null;
        $shippingAddress = null;

        if (isset($customerData->result->customer->billing_address)) {
            $billingAddress = get_object_vars($customerData->result->customer->billing_address);
            $billingAddress = new PiRatepay_Paypage_Model_Address(
                    $billingAddress['street'],
                    $billingAddress['street_number'],
                    $billingAddress['zip'],
                    $billingAddress['city'],
                    $billingAddress['country']
            );
        }
        if (isset($customerData->result->customer->shipping_address)) {
            $shippingAddress = get_object_vars($customerData->result->customer->shipping_address);
            $shippingAddress = new PiRatepay_Paypage_Model_Address(
                    $shippingAddress['street'],
                    $shippingAddress['street_number'],
                    $shippingAddress['zip'],
                    $shippingAddress['city'],
                    $shippingAddress['country']
            );
        }

        $newCustomerData = new PiRatepay_Paypage_Model_Customer(
                $customerData->result->customer->first_name,
                $customerData->result->customer->last_name,
                $customerData->result->customer->title,
                $customerData->result->customer->email,
                $customerData->result->customer->date_of_birth,
                $customerData->result->customer->gender,
                $customerData->result->customer->phone,
                $customerData->result->customer->fax,
                $customerData->result->customer->mobile,
                $customerData->result->customer->company_name,
                $customerData->result->customer->vat_id,
                $customerData->result->customer->nationality,
                $billingAddress,
                $shippingAddress
        );
        return $newCustomerData;
    }

    /**
     * This Method handles the json request to the api. A curl version is
     * shipped with this package. A Developer could easyily create a own version
     * using Zend or of other frameworks request classes.
     */
    abstract protected function _jsonRequest(array $params);
}
