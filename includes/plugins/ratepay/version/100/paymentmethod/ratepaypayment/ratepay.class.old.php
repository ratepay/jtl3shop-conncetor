<?php
include_once (PFAD_ROOT.PFAD_INCLUDES_MODULES.'PaymentMethod.class.php');
require_once(dirname(__FILE__) . '/bootstrap.php');

class Ratepay extends PaymentMethod
{
    public function init()
    {
        $this->name = 'RatePAY';
        $this->caption = 'RatePAY';
    }

    public function preparePaymentProcess($order) {
        global $oPlugin;

        $requestObject = $this->_getRequestObject($order);
        $requestModel = $this->_getRequestModel($order);

        //die(print_r((array) $requestModel));

        //die(var_dump($requestObject->initialisation($requestModel)));

        $token = $requestObject->initialisation($requestModel);

        /*if (!isset($token->result->token)) { //  && isset($token->result->errors)
            die("test");
        }*/

        //die(var_dump($token));
        //die(print_r((array) $requestModel));

        $helperConnection = new RatepayHelperConnection;
        $helperData = new RatepayData;

        $sandbox = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);

        header('Location: ' . $helperConnection->getRatepayPayPageUrl($sandbox) . $token);

        //$this->cancelOrder($order->kBestellung);
        //header('Location: ' . gibShopURL() . '/bestellvorgang.php?editZahlungsart=1');
        die();
    }

    private function _getRequestObject($order) {
        global $oPlugin;        
        $helperConnection = new RatepayHelperConnection;
        $helperData = new RatepayData;

        $bestellNr = $order->cBestellNr;
        $config['profile_id']    = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_profile_id'];
        $config['security_code'] = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_security_code'];
        $config['sandbox']       = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);
        
        $requestObject = new PiRatepay_Paypage_Request_Curl();
        $requestObject->setSandBox($config['sandbox']);
        $requestObject->setId(
            md5(
                $config['profile_id'] .
                $config['security_code'] .
                $bestellNr
            )
        );

        if ($config['sandbox']) {
            $requestObject->setSandBoxUrl($helperConnection->getRatepayPayPageApiUrl(true));
        } else {
            $requestObject->setLiveUrl($helperConnection->getRatepayPayPageApiUrl(false));
        } 
        
        return $requestObject;
    }

    private function _getRequestModel($order) {
        global $oPlugin;
        $helperData = new RatepayData;

        $config['profile_id']    = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_profile_id'];
        $config['security_code'] = $oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_security_code'];
        $config['sandbox']       = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_sandbox']);
        $config['ala']           = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_ala']);
        $config['b2b']           = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_b2b']);
        $config['editable']      = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_editable']);
        $config['basketitems']   = $helperData->isConfigSet($oPlugin->oPluginEinstellungAssoc_arr[$this->cModulId . '_basketitems']);

        $protocol = ($_SERVER["HTTPS"] != 'on') ? "http://" : "http://";
        $host = $_SERVER[HTTP_HOST];
        $script = $_SERVER[SCRIPT_NAME];
        $hash = $this->generateHash($order);
        $hashParam = "?hash=" . $hash;

        $requestModel = new PiRatepay_Paypage_Model_Request();

        $requestModel->setProfileId($config['profile_id']);
        $requestModel->setSecurityCode($config['security_code']);
        $requestModel->setSuccessUrl($protocol . $host . str_replace("bestellabschluss", "includes/modules/notify", $script) . $hashParam);
        $requestModel->setFailureUrl($protocol . $host . str_replace("bestellabschluss", "bestellvorgang", $script) . '?editZahlungsart=1'); // '/bestellvorgang.php?editZahlungsart=1'
        $requestModel->setOrderId($order->cBestellNr);

        $basketModel = new PiRatepay_Paypage_Model_Basket($order->Waehrung->cISO, $order->fGesamtsumme);

        foreach ($order->Positionen as $article) {
            if($article->fPreis > 0) {
                $basketModel->addItem(
                    new PiRatepay_Paypage_Model_Item(
                        ($article->nPosTyp === "1") ? $article->cArtNr : "versand",
                        ($article->nPosTyp === "1") ? $article->Artikel->cName : $order->oVersandart->cName,
                        $article->nAnzahl,
                        $helperData->getPriceByLocalFormat($article->cEinzelpreisLocalized[1]),
                        $helperData->getPriceByLocalFormat($article->cGesamtpreisLocalized[1]),
                        $helperData->getPriceByLocalFormat($article->cGesamtpreisLocalized[0]) - $helperData->getPriceByLocalFormat($article->cGesamtpreisLocalized[1])
                    )
                );
            }

            /*if (isset($this->session->data['coupon'])) {
                $coupon = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);
                if ($coupon['type'] == 'P') {
                    $discount = ($article['price'] * ($coupon['discount'] / 100)) * -1;
                    $basketModel->addItem(
                        new PiRatepay_Paypage_Model_Item(
                            $article['product_id'] . "_" . $coupon['code'],
                            $coupon['name'] . ": " . $article['name'],
                            $article['quantity'],
                            $discount,
                            $discount * $article['quantity'],
                            0
                        )
                    );
                    $totalNet += $discount * $article['quantity'];
                }
            }*/
        }

        //die(print_r($order->Positionen));

        /*
        // Wird nicht gebraucht!
        if (isset($order->oVersandart) && $order->oVersandart->fPreis > 0) {
            $basketModel->addItem(
                new PiRatepay_Paypage_Model_Item(
                    "shipping",
                    $order->oVersandart->cName,
                    1,
                    $order->oVersandart->fPreis,
                    $order->oVersandart->fPreis,
                    0
                )
            );
        }*/

        //die(print_r((array) $order->oVersandart));

        /*if (isset($this->session->data['coupon'])) {
            $coupon = $this->model_checkout_coupon->getCoupon($this->session->data['coupon']);
            if ($coupon['type'] != 'P') {
                $discount = $coupon['discount'] * -1;
                $basketModel->addItem(
                    new PiRatepay_Paypage_Model_Item(
                        $coupon['code'],
                        $coupon['name'],
                        1,
                        $discount,
                        $discount,
                        0
                    )
                );
                $totalNet += $discount;
            }
        }*/

        /*if (isset($this->session->data['voucher'])) {
            $voucher = $this->model_checkout_voucher->getVoucher($this->session->data['voucher']);
            $basketModel->addItem(
                new PiRatepay_Paypage_Model_Item(
                    $voucher['code'],
                    'Voucher/Giftcard (from ' . $voucher['from_name'] . ')',
                    1,
                    $voucher['amount'] * -1,
                    $voucher['amount'] * -1,
                    0
                )
            );
            $totalNet -= $voucher['amount'];
        }*/

        $requestModel->setTax($order->fSteuern);

        $requestModel->setBasket($basketModel);

        $merchantModel = new PiRatepay_Paypage_Model_Merchant();
        $merchantModel->setName('Dummy');
        $merchantModel->setStreet('Dummy');
        $merchantModel->setZip('12345');
        $merchantModel->setCity('Dummy');
        $merchantModel->setPhone('123456');
        $merchantModel->setEmail('Dummy@dummy.de');
        $merchantModel->setFax('');
        $merchantModel->setFactorbank('Dummy');
        $merchantModel->setBanklocation('Dummy');
        $requestModel->setMerchant($merchantModel);

        $customerObject = new PiRatepay_Paypage_Model_Customer();
        die(print_r((array) $order));
        $customerObject->setFirstName($order->oRechnungsadresse->cVorname);
        $customerObject->setLastName($order->oRechnungsadresse->cNachname);
        $customerObject->setEmail($order->oRechnungsadresse->cMail);
        if (isset($order->oKunde->dGeburtstag)) {
            $customerObject->setDateOfBirth($order->oKunde->dGeburtstag);
        }
        $customerObject->setGender($helperData->getGender($order->oRechnungsadresse->cAnrede));
        $customerObject->setPhone($order->oRechnungsadresse->cTel);
        $customerObject->setMobile($order->oRechnungsadresse->cMobil);
        $customerObject->setFax($order->oRechnungsadresse->cFax);
        $customerObject->setCompanyName($order->oRechnungsadresse->cFirma);
        $customerObject->setVatId($order->oRechnungsadresse->cUSTID);
        $customerObject->setNationality($order->oRechnungsadresse->cLand);

        $billingAddress = new PiRatepay_Paypage_Model_Address(
            $order->oRechnungsadresse->cStrasse,
            $order->oRechnungsadresse->cHausnummer,
            $order->oRechnungsadresse->cPLZ,
            $order->oRechnungsadresse->cOrt,
            $order->oRechnungsadresse->cLand);
        $customerObject->setBillingAddress($billingAddress);

        if (isset($order->Lieferadresse)) {
            $shippingAddress = new PiRatepay_Paypage_Model_Address(
                $order->Lieferadresse->cStrasse,
                $order->Lieferadresse->cHausnummer,
                $order->Lieferadresse->cPLZ,
                $order->Lieferadresse->cOrt,
                $order->Lieferadresse->cLand);
            $customerObject->setShippingAddress($shippingAddress);
        }

        $requestModel->setCustomer($customerObject);

        $requestModel->setFlags(
            array(
                'edit_customer' => $config['editable'],
                'disable_items' => $config['basketitems']
            )
        );

        return $requestModel;
    }    

    public function handleNotification($order, $hash, $args) {
        if($this->verfiyNotification($order, $hash, $args))
        {
            //die($hash);
            //Zahlung setzen
            //Aufräumen
            //Emails senden
        }
    }

    public function verifyNotification($order, $hash, $args) {
        //die($hash);
        return true;
    }

    public function finalizeOrder($order, $hash, $args)
    {

    }
}
?>