<?php
require_once(__DIR__ . '/../initialize.php');

class Advert extends Database {

    //protected static $db;

    // public static function set_database($db) {
    //     self::$db = $db;
    // }

    protected static function instantiate ($record) {
        $object = new self;

        foreach ($record as $property => $value) {
            if (property_exists($object, $property)) {
                $object->$property = $value;
            }
        }
        return $object;
    }

    public static function find_by_sql ($sql) {
        $result = Database::$db->query($sql);
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

    public static function ad_select_all () {
        
        $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_status, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name 
                FROM advert
                LEFT JOIN city ON (advert.ad_zip = city.zip_code)
                LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)
                WHERE advert.ad_status=1
                ORDER BY ad_timestamp DESC";

        return self::find_by_sql($sql);
    }

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

    public $ad_id;
    public $ad_title;
    public $ad_image;
    public $ad_desc;
    public $ad_size;
    public $ad_price;
    public $ad_street_address;
    public $ad_zip;
    public $ad_timestamp;
    public $residence_type_name;
    public $ad_status;
    public $zip_location;
    public $user_email;
    public $ad_user_id;

    public function __construct($args=[]) {
        $this->ad_title = $args['ad_title'] ?? '';
        $this->ad_image = $args['ad_image'] ?? '';
        $this->residence_type_name = $args['residence_type_name'] ?? '';
        $this->ad_desc = $args['ad_desc'] ?? '';
        $this->ad_size = $args['ad_size'] ?? 0;
        $this->ad_price = $args['ad_price'] ?? 0;
        $this->ad_street_address = $args['ad_street_address'] ?? '';
        $this->ad_zip = $args['ad_zip'] ?? 0;
        $this->ad_timestamp = $args['ad_timestamp'] ?? '';
        $this->zip_location = $args['zip_location'] ?? '';
        $this->ad_status = $args['ad_status'] ?? 0;
        $this->user_email = $args['user_email'] ?? '';
        $this->ad_user_id = $args['ad_user_id'] ?? 0;
    
        // Caution: allows private/protected properties to be set
        // foreach($args as $k => $v) {
        //   if(property_exists($this, $k)) {
        //     $this->$k = $v;
        //   }
        // }
      }

    // public static function ad_select_all_old () {
        
    //     $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name 
    //             FROM advert
    //             LEFT JOIN city ON (advert.ad_zip = city.zip_code)
    //             LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)";

    //     return self::$db->query($sql);
    // }

    // function ad_select_one_old ($ad_id) {

    //     $sql = "SELECT advert.ad_id, advert.ad_title, advert.ad_image, advert.ad_desc, advert.ad_size, advert.ad_price, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location, residence_type.residence_type_name, user.user_name, user.user_email 
    //             FROM advert
    //             LEFT JOIN city ON (advert.ad_zip = city.zip_code)
    //             LEFT JOIN residence_type ON (advert.ad_residence_type = residence_type.residence_type_id)
    //             LEFT JOIN user ON (advert.ad_user_id = user.user_id)
    //             WHERE advert.ad_id=?";
        
    //     $stmt = self::$db->prepare($sql); 
    //     $stmt->bind_param("i", $ad_id);
    //     $stmt->execute();
    //     $result = $stmt->get_result();

    //     return $result;
    // }

    public function ad_insert ($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_user_id) {
        $sql = "INSERT INTO advert (ad_title, ad_image, ad_residence_type, ad_desc, ad_size, ad_price, ad_street_address, ad_zip, ad_user_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssssiisii", $ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_user_id);
        $stmt->execute();
        $stmt->close();
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
    
    public static function ad_get_sorted ($filter) {
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

    public function ad_update ($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id) {
        $sql = "UPDATE advert SET ad_title=?, ad_image=?, ad_residence_type=?, ad_desc=?, ad_size=?, ad_price=?, ad_street_address=?, ad_zip=?, ad_status=? WHERE ad_id=?";
        $stmt = Database::$db->prepare($sql);
        $stmt->bind_param("ssisiisiii", $ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id);
        $stmt->execute();
    }

    // public function ad_update_status ($ad_status_bool, $ad_id) {
    //     $sql = "UPDATE advert SET ad_status =? WHERE ad_id=?";
    //     $stmt = Database::$db->prepare($sql);
    //     $stmt->bind_param("ii", $ad_status_bool, $ad_id);
    //     $stmt->execute();
    // }

}