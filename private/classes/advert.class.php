<?php
require_once(__DIR__ . '/../initialize.php');

class Advert {

     public static $db;

     public static function set_database($db) {
        self::$db = $db;
    }

//INGEN FELT DIN IDIOT
//bruke advert = new advert og lage queries som har med adverts å gjøre.
    public function adInsertNew ($adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode) {
        $stmt = Advert::$db->prepare("INSERT INTO advert (ad_title, ad_image, ad_residence_type, ad_desc, ad_size, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiisi", $adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode);
        $stmt->execute();
    
    }

    function adSelectAll () {
        
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_residence_type, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)";
        
        $result = Advert::$db->query($sql);

        return $result;
    }

    function adSelectOne ($adId) {

        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_residence_type, advert.ad_desc, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                WHERE advert.ad_id=?";
        
        $stmt = Advert::$db->prepare($sql); 
        $stmt->bind_param("i", $adId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }
}