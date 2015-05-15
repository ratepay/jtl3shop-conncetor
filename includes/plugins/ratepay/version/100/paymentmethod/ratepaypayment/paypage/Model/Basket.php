<?php

/**
 * Basket Model
 *
 * @category PayIntelligent
 * @package PiRatepay_Paypage_Model
 * @copyright Copyright(c) 2012 PayIntellignet GmbH
 * @license
 * @version 1.0.0
 */
class PiRatepay_Paypage_Model_Basket
{

    /**
     * Currency
     * @var string
     */
    private $_currency;

    /**
     * amount
     * @var float
     */
    private $_amount;

    /**
     * An array of instances of the itemModel
     * @var array
     */
    private $_items = array();

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Construct
     *
     * @param string $currency must be a string with uppercase
     * @param float $amount
     * @param Pi_Util_Validation $validation defaults to null
     * @throws PiRatepay_Paypage_Util_ValidationException shows up an error, if one attribut was not correct submitted
     */
    public function __construct($currency = null, $amount = null, $validation = null)
    {
        $this->_validation = is_null($validation)? new Pi_Util_Validation() : $validation;

        if (!is_null($currency)) {
            $this->_setCurrency($currency);
        }
        if (!is_null($amount)) {
            $this->_setAmount($amount);
        }
    }

    /**
     * This function returns the value of the parameter currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->_currency;
    }

    private function _setCurrency($currency)
    {
        if ($this->_validation->validateWithRegex("^[A-Z]+$", $currency)) {
            $this->_currency = $currency;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(305);
        }
    }

    /**
     * This function returns the value of the parameter amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     *
     * @param nummeric $amount
     * @throws PiRatepay_Paypage_Util_ValidationException
     */
    private function _setAmount($amount)
    {
        if ($this->_validation->validateIsNumeric($amount)) {
            $this->_amount = $amount;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(205);
        }
    }

    /**
     * This function returns the value of the parameter items
     *
     * @return ItemModel
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * This function adds an item to the object.
     *
     * @param ItemModel $item
     */
    public function addItem(PiRatepay_Paypage_Model_Item $item)
    {
        $this->_items[] = $item;
    }

    /**
     * This function converts the whole data from the object into an array.
     *
     * @return array
     */
    public function toArray()
    {
        $returnArray = array(
            'currency' => $this->_currency,
            'amount'   => $this->_amount,
        );
        foreach ($this->_items as $itemModel) {
            $returnArray['items'][] = $itemModel->toArray();
        }
        return $returnArray;
    }

}
