<?php
require(INC_PATH . '/db.inc.php');

class Advert {

//INGEN FELT DIN IDIOT
//bruke advert = new advert og lage queries som har med adverts å gjøre.
    public function adInsertNew ($adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode) {
        $db = new Database;
        $conn = $db->connection();

        $stmt = $conn->prepare("INSERT INTO advert (ad_title, ad_image, ad_residence_type, ad_desc, ad_size, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiisi", $adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode);
        $stmt->execute();
    
        $stmt->close();
        $conn->close();
    }

    function adSelectAll () {
        $db = new Database;
        $conn = $db->connection();

        $sql = "SELECT advert.ad_title, advert.ad_image, advert.ad_size, advert.ad_price, advert.ad_residence_type, advert.ad_street_address, advert.ad_zip, advert.ad_timestamp, city.zip_location 
        FROM advert
        LEFT JOIN city ON (advert.ad_zip = city.zip_code)";
        
        $result = $conn->query($sql);

        return $result;
    }

    

}