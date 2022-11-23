<?php
require_once(__DIR__ . '/../initialize.php');

class Advert {

     protected static $db;

     public static function set_database($db) {
        self::$db = $db;
    }

    public static function find_by_sql ($sql) {
        $result = self::$db->query($sql);
        if (!$result) {
            exit("Forespørselen feilet, prøv på nytt...");
        }

        $object_array = [];
        while ($record = $result->fetch_assoc()) {
            $object_array[] = self::instantiate($record);
        }

        $result->free();

        return $object_array;
    }

    protected static function instantiate ($record) {
        $object = new self;

        foreach ($record as $property => $value) {
            if (property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
        return $object;
    }

    public $adId;
    public $adTitle;
    public $adResidenceTypeenceType;
    public $adDescriptioniption;
    public $adSize;
    public $price;
    public $streetAddressddress;
    public $zipcode;










    public static function ad_select_all () {
        
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)";

        return self::$db->query($sql);
    }

    function ad_select_one ($adId) {

        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_desc, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name, user.user_name, user.user_email 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)
                LEFT JOIN user ON (advert.ad_user_id = user.user_id)
                WHERE advert.ad_id=?";
        
        $stmt = self::$db->prepare($sql); 
        $stmt->bind_param("i", $adId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    //bruke advert = new advert og lage queries som har med adverts å gjøre.
    public function ad_insert ($adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode) {
        $stmt = self::$db->prepare("INSERT INTO advert (ad_title, ad_image, ad_residence_type, ad_desc, ad_size, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiisi", $adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode);
        $stmt->execute();
    }

    function ad_select_self () {

    }
    
    function ad_sort () {
        
    }

    function ad_update () {
        
    }

}