<?php

class RatepayData {

    public function isConfigSet($data) {
        if ($data == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getGender($data) {
        switch (strtoupper($data)) {
            case "W":
                return "F";
            case "M":
                return "M";
            default:
                return "U";
        }
    }

    public function getPriceByLocalFormat($data) {
        $price = str_replace(",", ".", $data);
        return floatval($price);
    }

    public function changeDateFormat($date) {
        $dateArr = explode(".", $date);
        return (count($dateArr) > 1) ? $dateArr[2] . "-" . $dateArr[1] . "-" . $dateArr[0] : $date;
    }
}