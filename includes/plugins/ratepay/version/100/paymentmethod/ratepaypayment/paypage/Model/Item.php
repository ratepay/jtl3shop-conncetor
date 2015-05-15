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
class PiRatepay_Paypage_Model_Item
{

    /**
     * articlenumber
     * @var string
     */
    private $_articleNumber;

    /**
     * articlename
     * @var string
     */
    private $_articleName;

    /**
     * quantity
     * @var integer
     */
    private $_quantity;

    /**
     * unitprice
     * @var float
     */
    private $_unitPrice;

    /**
     * totalprice
     * @var float
     */
    private $_totalPrice;

    /**
     * tax
     * @var float
     */
    private $_tax;

    /**
     * An instance of the validationclass
     * @var Pi_Util_Validation
     */
    private $_validation;

    /**
     * Construct
     *
     * This function initialized an instance of the object and set all parameters
     *
     * @param string $articleNumber
     * @param string $articleName
     * @param integer $quantity
     * @param float $unitPrice
     * @param float $totalPrice
     * @param float $tax
     * @param Pi_Util_Validation $validation defaults to null
     */
    public function __construct(
        $articleNumber = null,
        $articleName = null,
        $quantity = null,
        $unitPrice = null,
        $totalPrice = null,
        $tax = null,
        $validation = null
    )
    {
        $this->_validation = is_null($validation) ? new Pi_Util_Validation() : $validation;

        if (!is_null($articleNumber)) {
            $this->setArticleNumber($articleNumber);
        }
        if (!is_null($articleName)) {
            $this->setArticleName($articleName);
        }
        if (!is_null($quantity)) {
            $this->setQuantity($quantity);
        }
        if (!is_null($unitPrice)) {
            $this->setUnitPrice(floatval($unitPrice));
        }
        if (!is_null($totalPrice)) {
            $this->setTotalPrice(floatval($totalPrice));
        }
        if (!is_null($tax)) {
            $this->setTax(floatval($tax));
        }
    }

    /**
     * Return article number of the basket item
     * @return string
     */
    public function getArticleNumber()
    {
        return $this->_articleNumber;
    }

    /**
     * Set article number of the basket item
     * @param string $articleNumber
     */
    public function setArticleNumber($articleNumber)
    {
        if ($this->_validation->validateIsString($articleNumber)) {
            $this->_articleNumber = $articleNumber;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(115);
        }
    }

    /**
     * Return basket item name
     * @return string
     */
    public function getArticleName()
    {
        return $this->_articleName;
    }

    /**
     * Set basket item name
     * @param string $articleName
     */
    public function setArticleName($articleName)
    {
        if ($this->_validation->validateIsString($articleName)) {
            $this->_articleName = $articleName;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(116);
        }
    }

    /**
     * Return quantity of the item
     * @return integer
     */
    public function getQuantity()
    {
        return $this->_quantity;
    }

    /**
     * Set quantity of the item
     * @param integer $quantity
     */
    public function setQuantity($quantity)
    {
        if ($this->_validation->validateIsInteger($quantity)) {
            $this->_quantity = $quantity;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(201);
        }
    }

    /**
     * Return the price of one unit of the item (without taxes)
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->_unitPrice;
    }

    /**
     * Set the price of one unit of the item (without taxes)
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        if ($this->_validation->validateIsNumeric($unitPrice)) {
            $this->_unitPrice = $unitPrice;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(202);
        }
    }

    /**
     * Return the total price of the item. The total price equals
     * unit price * quantity.
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->_totalPrice;
    }

    /**
     * Set the total price of the item. The total price must equal
     * unit price * quantity.
     * @param float $totalPrice
     */
    public function setTotalPrice($totalPrice)
    {
        if ($this->_validation->validateIsNumeric($totalPrice)) {
            $this->_totalPrice = $totalPrice;
        } else {
            throw new PiRatepay_Paypage_Util_ValidationException(203);
        }
    }

    /**
     * Return total tax amount for this item.
     * @return float
     */
    public function getTax()
    {
        return $this->_tax;
    }

    /**
     * Set total tax amount for this item.
     * @param float $tax
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
     * This function converts the whole data of the object into an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            'article_number' => $this->_articleNumber,
            'article_name'   => $this->_articleName,
            'quantity'       => $this->_quantity,
            'unit_price'     => $this->_unitPrice,
            'total_price'    => $this->_totalPrice,
            'tax'            => $this->_tax
        );
    }

}
