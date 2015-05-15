<?php

/**
 * Set Parameter for a Request and send them to the Paypage.
 *
 * @category PayIntelligent
 * @package PiRatepay_Paypage_Model
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Model_Request
{

    /**
     * profileId
     * @var string
     */
    private $_profileId;

    /**
     * securitycode
     * @var string
     */
    private $_securityCode;

    /**
     * successUrl
     * @var string
     */
    private $_successUrl;

    /**
     * failUrl
     * @var string
     */
    private $_failureUrl;

    /**
     * orderId
     * @var string
     */
    private $_orderId;

    /**
     * tax
     * @var string
     */
    private $_tax;

    /**
     * merchant
     * @var PiRatepay_Paypage_Model_Merchant
     */
    private $_merchant;

    /**
     * customer
     * @var PiRatepay_Paypage_Model_Customer
     */
    private $_customer;

    /**
     * flags
     * @var array
     */
    private $_flags;

    /**
     * basket
     * @var PiRatepay_Paypage_Model_Basket
     */
    private $_basket;

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Merchant Consumer Classification
     * @var string
     */
    private $_mcc = 'neutral';

    /**
     * Allowed values for Merchant Consumer Classification
     * @var string
     */
    private $_mccValues = array(
        'negative',
        'neutral',
        'positive',
        'vip'
    );

    /**
     * Construct
     * @param string $profileId
     * @param string $securityCode
     * @param string $successUrl
     * @param string $failureUrl
     * @param string $orderId
     * @param string $tax
     * @param PiRatepay_Paypage_Model_Merchant $merchant
     * @param PiRatepay_Paypage_Model_Customer $customer
     * @param array $flags
     * @param PiRatepay_Paypage_Model_Basket $basket
     * @param Pi_Util_Validation $validation
     */
    public function __construct(
        PiRatepay_Paypage_Model_Basket $basket = null,
        $profileId = null,
        $securityCode = null,
        $successUrl = null,
        $failureUrl = null,
        $orderId = null,
        $tax = null,
        PiRatepay_Paypage_Model_Merchant $merchant = null,
        $mcc = null,
        PiRatepay_Paypage_Model_Customer $customer = null,
        array $flags = null,
        Pi_Util_Validation $validation = null)
    {
        $this->_validation = is_null($validation) ? new Pi_Util_Validation() : $validation;

        if (!is_null($basket)) {
            $this->setBasket($basket);
        }
        if (!is_null($profileId)) {
            $this->setProfileId($profileId);
        }
        if (!is_null($securityCode)) {
            $this->setSecurityCode($securityCode);
        }
        if (!is_null($successUrl)) {
            $this->setSuccessUrl($successUrl);
        }
        if (!is_null($failureUrl)) {
            $this->setFailureUrl($failureUrl);
        }
        if (!is_null($orderId)) {
            $this->setOrderId($orderId);
        }
        if (!is_null($tax)) {
            $this->setTax($tax);
        }
        if (!is_null($merchant)) {
            $this->setMerchant($merchant);
        }
        if (!is_null($mcc)) {
            $this->setMcc($mcc);
        }
        if (!is_null($customer)) {
            $this->setCustomer($customer);
        }
        if (!is_null($flags)) {
            $this->setFlags($flags);
        }
    }

    /**
     * This function returns the value of the parameter profileId
     *
     * @return string
     */
    public function getProfileId()
    {
        return $this->_profileId;
    }

    /**
     * This function sets the value for the profileId
     *
     * @param string $profileId
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter profileId was not submitted as string
     */
    public function setProfileId($profileId)
    {
        if ($this->_validation->validateIsString($profileId)) {
            $this->_profileId = $profileId;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(100);
        }
    }

    /**
     * This function returns the value of the parameter securityCode
     *
     * @return string
     */
    public function getSecurityCode()
    {
        return $this->_securityCode;
    }

    /**
     * This function sets the value for the securityCode
     *
     * @param string $securityCode
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter securityCode was not submitted as string
     */
    public function setSecurityCode($securityCode)
    {
        if ($this->_validation->validateIsString($securityCode)) {
            $this->_securityCode = $securityCode;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(101);
        }
    }

    /**
     * This function returns the value of the parameter successUrl
     *
     * @return string
     */
    public function getSuccessUrl()
    {
        return $this->_successUrl;
    }

    /**
     * This function sets the value for the successUrl
     *
     * @param string $successUrl
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter successUrl was submitted with an unsupported format
     */
    public function setSuccessUrl($successUrl)
    {
        if ($this->_validation->validateStartsWithHttp($successUrl)) {
            $this->_successUrl = $successUrl;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(301);
        }
    }

    /**
     * This function returns the value of the parameter failureUrl
     *
     * @return string
     */
    public function getFailureUrl()
    {
        return $this->_failureUrl;
    }

    /**
     * This function sets the value for the failureUrl
     *
     * @param string $failureUrl
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter failureUrl was submitted with an unsupported format
     */
    public function setFailureUrl($failureUrl)
    {
        if ($this->_validation->validateStartsWithHttp($failureUrl)) {
            $this->_failureUrl = $failureUrl;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(302);
        }
    }

    /**
     * This function returns the value of the parameter orderId
     *
     * @return string
     */
    public function getOrderId()
    {
        return $this->_orderId;
    }

    /**
     * This function sets the value for the orderId
     *
     * @param string $orderId
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter orderId was not submitted as string
     */
    public function setOrderId($orderId)
    {
        if ($this->_validation->validateIsString($orderId)) {
            $this->_orderId = $orderId;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(106);
        }
    }

    /**
     * This function returns the value of the parameter tax
     *
     * @return string
     */
    public function getTax()
    {
        return $this->_tax;
    }

    /**
     * This function sets the value for the parameter tax
     *
     * @param string $tax
     * @throws PiRatepay_Paypage_Util_ValidationException The parameter tax was not submitted as string
     */
    public function setTax($tax)
    {
        if ($this->_validation->validateIsNumeric($tax)) {
            $this->_tax = $tax;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(200);
        }
    }

    /**
     * Get Merchant Consumer Classification
     * @return string
     */
    public function getMcc()
    {
        return $this->_mcc;
    }

    /**
     * Set Merchant Consumer Classification
     * @param string $mcc
     * @throws PiRatepay_Paypage_Util_ValidationException MCC must be either "negative", "neutral", "positive" or "vip".
     */
    public function setMcc($mcc)
    {
        if (in_array($mcc, $this->_mccValues, true)) {
            $this->_mcc = $mcc;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(500);
        }
    }

    /**
     * Return merchant for this request
     * @return PiRatepay_Paypage_Model_Merchant
     */
    public function getMerchant()
    {
        return $this->_merchant;
    }

    /**
     * This function sets the value for the parameter merchant
     *
     * @param MerchantModel $merchant
     */
    public function setMerchant(PiRatepay_Paypage_Model_Merchant $merchant)
    {
        $this->_merchant = $merchant;
    }

    /**
     * Return customer for this request
     * @return PiRatepay_Paypage_Model_Customer
     */
    public function getCustomer()
    {
        return $this->_customer;
    }

    /**
     * This function sets the value for the parameter customer
     *
     * @param CustomerModel $customer
     */
    public function setCustomer(PiRatepay_Paypage_Model_Customer $customer)
    {
        $this->_customer = $customer;
    }

    /**
     * This function returns the value of the parameter flags
     *
     * @return array
     */
    public function getFlags()
    {
        return $this->_flags;
    }

    /**
     * This function sets the value for the parameter merchant
     *
     * @param array $flagsOptional
     */
    public function setFlags(array $flagsOptional)
    {
        $this->_flags = $flagsOptional;
    }

    /**
     * This function sets the value for the parameter basket
     *
     * @param BasketModel $basketModel
     */
    public function setBasket(PiRatepay_Paypage_Model_Basket $basketModel)
    {
        $this->_basket = $basketModel;
    }

    /**
     * This function sets the value for the parameter basket
     *
     * @param BasketModel $basketModel
     */
    public function getBasket()
    {
        return $this->_basket;
    }

    /**
     * This function converts the whole data of the object into an array.
     *
     * @return array
     */
    public function toArray()
    {

        if (is_null($this->_basket) || is_null($this->_merchant)) {
            throw new PiRatepay_Paypage_Util_ValidationException(400);
        }

        $requestData = array(
            'profile_id'    => $this->getProfileId(),
            'security_code' => $this->getSecurityCode(),
            'success_url'   => $this->getSuccessUrl(),
            'failure_url'   => $this->getFailureUrl(),
            'tax'           => $this->getTax(),
            'order_id'      => $this->getOrderId(),
            'mcc'           => $this->getMcc()
        );

        $returnArray = array_merge($requestData, $this->_basket->toArray());
        $returnArray['merchant'] = $this->_merchant->toArray();

        if (isset($this->_customer)) {
            $returnArray['customer'] = $this->_customer->toArray();
        }

        if (isset($this->_flags)) {
            $returnArray['flags'] = $this->_flags;
        }

        return array($returnArray);
    }

}
