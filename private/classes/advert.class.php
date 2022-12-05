<?php
require_once(__DIR__ . '/../initialize.php');

class Advert extends Database {

    //view all ads
    public static function ad_select_all ($filter) {
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name 
        FROM advert
        LEFT JOIN city ON (advert.ad_zip = city.zip_code)
        LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id) 
        WHERE advert.ad_status=1 ";

        switch ($filter) {
            case 'price_asc':
                $sql .= "ORDER BY ad_price ASC";
                break;
            case 'price_desc':
                $sql .= "ORDER BY ad_price DESC";
                break;
            case 'date_added_asc':
                $sql .= "ORDER BY ad_timestamp ASC";
                break;
            case 'date_added_desc':
                $sql .= "ORDER BY ad_timestamp DESC";
                break;  
            default:
                $sql .= "ORDER BY ad_timestamp DESC";
                break;
        }

        $result = Database::$db->query($sql);
        return $result;
    }
    
    //to get to the viewOneAd.php
    public function ad_select_one ($ad_id) {
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_residence_type, advert.ad_desc, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_status, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name, user.user_name, user.user_email 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)
                LEFT JOIN user ON (advert.ad_user_id = user.user_id)
                WHERE advert.ad_id=?";
        
        $stmt = Database::$db->prepare($sql); 
        $stmt->bind_param("i", $ad_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    //On myAds.php to see own ads
    public function ad_select_own ($ad_user_id) {
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_desc, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, advert.ad_status, city.zip_location, residence_type.residence_type_name, user.user_name, user.user_email 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)
                LEFT JOIN user ON (advert.ad_user_id = user.user_id)
                WHERE advert.ad_user_id=? 
                ORDER BY advert.ad_status DESC, advert.ad_id DESC";
        
        $stmt = Database::$db->prepare($sql); 
        $stmt->bind_param("i", $ad_user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result;
    }

    //insert new ad
    public function ad_insert ($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_user_id) {
        $sql = "INSERT INTO advert (ad_title, ad_image, ad_residence_type, ad_desc, ad_size, ad_price, ad_street_address, ad_zip, ad_user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssssiissi", $ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_user_id);
        $stmt->execute();
        $stmt->close();
    }
    
    //update ad
    public function ad_update ($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id) {
        $sql = "UPDATE advert SET ad_title=?, ad_image=?, ad_residence_type=?, ad_desc=?, ad_size=?, ad_price=?, ad_street_address=?, ad_zip=?, ad_status=? WHERE ad_id=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssisiissii", $ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id);
        $stmt->execute();
    }

}