<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
require_login();

//set ad_id to get request if exists. Set to post request if not.
if (isset($_GET["ad_id"]) ? $ad_id = $_GET["ad_id"] : $ad_id = $_POST["ad_id"])

$error_arr = array();

//runs when form has been submitted
if (isset($_POST["submit"])) {

    ###### User input control #####

    //grab data from form
    $ad_title = test_input($_POST["ad_title"]) ?? '';
    $ad_residence_type = test_input($_POST["ad_residence_type"]) ?? 0;
    $ad_desc = test_input($_POST["ad_desc"]) ?? '';
    $ad_size = test_input($_POST["ad_size"]) ?? 0;
    $ad_price = test_input($_POST["ad_price"]) ?? 0;
    $ad_street_address = test_input($_POST["ad_street_address"]) ?? '';
    $ad_zip = test_input($_POST["ad_zip"]) ?? '';
    $ad_id = test_input($_POST["ad_id"]) ?? 0;

    //grab and assign checkbox value for status
    if (isset($_POST["ad_status"]))
        $ad_status = 0;
    else
        $ad_status = 1;

    //validate user input
    if (empty($ad_title))
        $error_arr[] = "Tittel er påkrevd";

    if (empty($ad_residence_type))
        $error_arr[] = "Velg boligtype";

    if (empty($ad_desc))
        $error_arr[] = "Beskrivelse er påkrevd";

    if (empty($ad_size))
        $error_arr[] = "Størrelse i kvm er påkrevd";
    else if (!is_numeric($ad_size))
        $error_arr[] = "Størrelse i kvm må være i tall";

    if (empty($ad_price))
        $error_arr[] = "Pris er påkrevd";
    else if (!is_numeric($ad_price))
        $error_arr[] = "Pris må være i tall";

    if (empty($ad_street_address))
        $error_arr[] = "Adresse er påkrevd";

    if (empty($ad_zip))
        $error_arr[] = "Postnummer er påkrevd";
    else if (strlen($ad_zip != 4) && !preg_match("/^[0-9]{4}$/", $ad_zip))
        $error_arr[] = "Postnummer må være fire tall";


    ###### File control #####

    //runs only if file has been uploaded
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {

        //file info
        $image_filename = $_FILES["image"]["name"];
        $temp_filename = $_FILES["image"]["tmp_name"];
        $file_type = $_FILES['image']['type'];
        $file_size = $_FILES['image']['size'];

        //configurations
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/hybelutleie/public/assets/img/';
        $accepted_file_types = array("jpg" => "image/jpeg",
                                    "png" => "image/png");
        $max_file_size = 1024*1024*8; //8 MB

        //no directory with that name?
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true))
                die("Cannot create directory..." . $dir);
        }

        //constructing suffix
        $suffix = array_search($file_type, $accepted_file_types);

        //if filename exists
        do
            $filename = substr(md5(date('YmdHis')), 0, 8) . '.' . $suffix;
        while (file_exists($dir . $filename));

        //image validation
        if (!empty($file_type) && !in_array($file_type, $accepted_file_types)) {
            $types = implode(", ", array_keys($accepted_file_types));
            $error_arr[] = "Ugyldig filformat (Kun $types er tillatt)";
        }

        if ($file_size > $max_file_size) {
            $error_arr[] = "Filstørrelsen (" . round($file_size / 1048576, 2) . 
            " MB) er større enn tillatt (" . round($max_file_size / 1048576, 2) . " MB)"; // Bin. conversion
        }
    }

    ###### Save to Database #####    
    
    //create file path if file has been uploaded
    if (!empty($temp_filename)) 
    $sql_filepath = url_for('/assets/img/') . $filename;
    else
    $sql_filepath = '';

    //if no error save user input to database
    if (empty($error_arr)) {
        $ad_object = new Advert();
        if (!empty($temp_filename)) {
        $ad_object->ad_update($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, 
                              $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id);
        }
        else {
        $ad_object->ad_update_no_file($ad_title, $ad_residence_type, $ad_desc, $ad_size, 
                                      $ad_price, $ad_street_address, $ad_zip, $ad_status, $ad_id);    
        }
        //save img to server
        if (is_uploaded_file($_FILES["image"]["tmp_name"]))
            move_uploaded_file($temp_filename, $dir . $filename);

        //display successful message
        display_success_message("Din annonse har blitt oppdatert, du blir videresendt til dine annonser");
        header("refresh:2; url=".url_for('/pages/myAds.php')); exit();
    }
    //display error message
    else
        display_error_messages($error_arr);
}

//creating object and using it to echo values in form
$ad = new Advert();
$ad_object = $ad->ad_select_one($ad_id);
$row = $ad_object->fetch_object();

?>

<!--login form-->

<div class="container text-center my-2">
    <h3>Oppdater din annonse</h3>
</div>

<div class="container d-flex align-items-center my-5">
    <div class="col-md-6 py-4 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_title">Tittel</label>
                <input type="text" name="ad_title" id="ad_title" class="form-control" value="<?php echo $row->ad_title; ?>" />
            </div>
            <div class="mb-3">
                <label for="image_filename" class="form-label">Legg til bilder (Kun .jpg- eller .png-format)</label>
                <input class="form-control" type="file" name="image" id="image_filename" value="<?php echo $row->ad_image; ?>">
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_residence_type">Hva leies ut</label>
                <select class="form-select" name="ad_residence_type" id="ad_residence_type">
                    <option value="<?php echo $row->ad_residence_type; ?>" hidden><?php echo $row->residence_type_name; ?></option>
                    <option value="1">Hybel</option>
                    <option value="2">Rom i kollektiv</option>
                    <option value="3">Leilighet</option>
                </select>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_desc">Beskrivelse</label>
                <textarea class="form-control" name="ad_desc" id="description" rows="8"><?php echo $row->ad_desc; ?></textarea>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_size">Størrelse i kvm</label>
                <input type="text" name="ad_size" id="ad_size" class="form-control" value="<?php echo $row->ad_size; ?>" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_price">Pris</label>
                <input type="text" name="ad_price" id="ad_price" class="form-control" value="<?php echo $row->ad_price; ?>" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_street_address">Gateadresse</label>
                <input type="text" name="ad_street_address" id="ad_street_address" value="<?php echo $row->ad_street_address; ?>" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_zip">Postnummer</label>
                <input type="text" name="ad_zip" id="ad_zip" class="form-control" value="<?php echo $row->ad_zip; ?>" />
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="ad_status" id="ad_status" <?php if ($row->ad_status==0) echo "checked";?> >
                <label class="form-check-label" for="ad_status"><?php if ($row->ad_status==0) {echo "Fjern markering for å aktivere annonse";} else echo "Deaktiver annonsen ved å huke av her"; ?></label>
            </div>
            <input type="hidden" name="ad_id" value="<?php echo $ad_id ?>">
            <button type="submit" name="submit" class="btn btn-primary">Oppdatere annonse</button>
        </form>
    </div>
</div>

<?php
include(INC_PATH . '/footer.php'); ?>