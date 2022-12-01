<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--login form-->

<div class="container text-center my-2">
    <h3>Legg til ditt utleieobjekt</h3>
</div>

<div class="container d-flex align-items-center my-5">
    <div class="col-md-6 py-4 mx-auto">
    <!-- echo htmlspecialchars($_SERVER['PHP_SELF']);-->
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_title">Tittel</label>
                <input type="text" name="ad_title" id="ad_title" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="image_filename" class="form-label">Legg til bilder (Kun .jpg- eller .jpeg-format)</label>
                <input class="form-control" type="file" name="image_filename" id="image_filename" multiple>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_residence_type">Hva leies ut</label>
                <select class="form-select" name="ad_residence_type" id="ad_residence_type">
                    <option value="" selected disabled>...</option>
                    <option value="1">Hybel</option>
                    <option value="2">Rom i kollektiv</option>
                    <option value="3">Leilighet</option>
                </select>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_desc">Beskrivelse</label>
                <textarea class="form-control" name="ad_desc" id="description" rows="8" placeholder="Legg til beskrivelse her"></textarea>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_size">Størrelse i kvm</label>
                <input type="text" name="ad_size" id="ad_size" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_price">Pris</label>
                <input type="text" name="ad_price" id="ad_price" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_street_address">Gateadresse</label>
                <input type="text" name="ad_street_address" id="ad_street_address" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_zip">Postnummer</label>
                <input type="text" name="ad_zip" id="ad_zip" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Legg til annonse</button>
        </form>
    </div>
</div>

<?php
$error_arr = array();

if (isset($_POST["submit"])) {

    $ad_title = test_input($_POST["ad_title"]) ?? '';
    $ad_residence_type = test_input($_POST["ad_residence_type"]) ?? '';
    $ad_desc = test_input($_POST["ad_desc"]) ?? '';
    $ad_size = test_input($_POST["ad_size"]) ?? '';
    $ad_price = test_input($_POST["ad_price"]) ?? '';
    $ad_street_address = test_input($_POST["ad_street_address"]) ?? '';
    $ad_zip = test_input($_POST["ad_zip"]) ?? '';

    $dir = $_SERVER['DOCUMENT_ROOT'].'/hybelutleie/public/assets/img/';
    $image_filename = $_FILES["image_filename"]["name"];
    $sql_filepath = url_for('/assets/img/').$image_filename;
    $temp_filename = $_FILES["image_filename"]["tmp_name"];

    /* Input validation */
    if (empty($ad_title)){
        $error_arr[] = "Tittel er påkrevd";
    }
    
    if (empty($ad_residence_type)) {
        $error_arr[] = "Velg boligtype";
    }

    if (empty($ad_desc)) {
        $error_arr[] = "Beskrivelse er påkrevd";
    }

    if (empty($ad_size)) {
        $error_arr[] = "Størrelse er påkrevd";
    } else if (!is_numeric($ad_size)) {
        $error_arr[] = "Størrelse må beskrives i tall";
        }
    
    if (empty($ad_price)) {
        $error_arr[] = "Pris er påkrevd";
    } else if (!is_numeric($ad_price)) {
        $error_arr[] = "Størrelse må beskrives i tall";
        }    
    
    if (empty($ad_street_address)){
        $error_arr[] = "Adresse er påkrevd";
    }    

    if (empty($ad_zip)) {
        $error_arr[] = "Postnummer er påkrevd";
    } else if (strlen($ad_zip != 4 && !is_numeric($ad_zip))) {
        $error_arr[] = "Postnummer må være fire tall";
    }

    /* Save user input into database*/
    if (empty($error_arr)) {
        $ad = new Advert;
        $ad->ad_insert($ad_title, 
                       $sql_filepath, 
                       $ad_residence_type,
                       $ad_desc, 
                       $ad_size,
                       $ad_price, 
                       $ad_street_address, 
                       $ad_zip);
?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-success" role="alert">Din annonse har blitt opprettet, du blir videresendt til innloggingssiden!</p>
            </div>
            <?php header("Refresh:3; url=" . url_for('/pages/login.php')); exit(); ?>
        </div>
    <?php
    } else {

    ?>
        <div class="container d-flex align-items-center">
            <div class="col-md-4 py-3 mx-auto">
                <p class="alert alert-danger" role="alert">Vennligst rett opp feilene under og prøv på nytt<ul>
                    <?php foreach ($error_arr as $value) { ?>
                        <li><?php echo $value ?></li>
                    <?php } ?>
                </ul></p>
                
            </div>
        </div>
<?php

    }
    // if (is_uploaded_file($temp_filename)) {
    //     move_uploaded_file($temp_filename, $dir.$image_filename);
    //     echo "<script>alert(\"Annonsen ble lastet opp!\")</script>";
    // } else {
    //     echo "Filen finnes ikke, prøv på nytt";
    // }
    
    

}

include(INC_PATH . '/footer.php'); ?>