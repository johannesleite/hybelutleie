<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
require_login();

$error_arr = array();

if (isset($_POST["submit"])) {

    ###### User input control #####

    //grab data from form
    $ad_title = test_input($_POST["ad_title"]) ?? '';
    $ad_residence_type = test_input($_POST["ad_residence_type"]) ?? 0;
    $ad_desc = test_input($_POST["ad_desc"]) ?? '';
    $ad_size = test_input($_POST["ad_size"]) ?? 0;
    $ad_price = test_input($_POST["ad_price"]) ?? 0;
    $ad_street_address = test_input($_POST["ad_street_address"]) ?? '';
    $ad_zip = test_input($_POST["ad_zip"]) ?? 0;

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
            else if (strlen($ad_zip != 4 && !is_numeric($ad_zip)))
                $error_arr[] = "Postnummer må være fire tall";


    ###### File control #####

    //file info
    $image_filename = $_FILES["image"]["name"];
    $temp_filename = $_FILES["image"]["tmp_name"];
    $file_type = $_FILES['image']['type'];
    $file_size = $_FILES['image']['size'];

    //configurations
    $dir = $_SERVER['DOCUMENT_ROOT'].'/hybelutleie/public/assets/img/';
    $sql_filepath = url_for('/assets/img/').$image_filename;
    $accepted_file_types = array("jpg" => "image/jpeg",
                                 "png" => "image/png");
    $max_file_size = 1024*1024*8; //8 MB

    //no directory with that name?
    if(!file_exists($dir)) 
        {
            if (!mkdir($dir, 0777, true)) 
                die("Cannot create directory..." . $dir);
        }
    
    //constructing file name
    $suffix = array_search($file_type, $accepted_file_types);
    $filename  = $_SESSION['user_id'] . '.' . $suffix;

    //if filename exists
    do 
        $filename = substr(md5(date('YmdHis')), 0, 5). '.'. $suffix;
    while(file_exists($dir. $filename));

    //image validation
    if (!empty($file_type) && !in_array($file_type, $accepted_file_types)) {
        $types = implode(", ", array_keys($accepted_file_types));
        $error_arr[] = "Ugyldig filformat (Kun $types er tillatt)";
    }

    if ($file_size > $max_file_size){
    $error_arr[] = "Filstørrelsen (" . round($file_size / 1048576, 2) . 
    " MB) er større enn tillatt (" . round($max_file_size / 1048576, 2) . " MB)"; // Bin. conversion
    }
 

    ###### Save to Database #####

    //if no error save user input to database
    if (empty($error_arr)) {
        $ad = new Advert;
        $ad->ad_insert($ad_title, $sql_filepath, $ad_residence_type, $ad_desc, $ad_size, 
                        $ad_price, $ad_street_address, $ad_zip, $session->user_id);  
        
        //save img to database
        if (is_uploaded_file($temp_filename))
        move_uploaded_file($temp_filename, $dir.$image_filename);
        
        //display successful message
        display_success_message("Din annonse har blitt opprettet, du blir videresendt til hjemmesiden");
        header("Refresh:3; url=" . url_for('/index.php')); exit(); 
    } 
        //display error message
    else 
        display_error_messages($error_arr);

}
?>

<!--login form-->

<div class="container text-center my-2">
    <h3>Oppdater din annonse</h3>
</div>

<div class="container d-flex align-items-center my-5">
    <div class="col-md-6 py-4 mx-auto">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_title">Tittel</label>
                <input type="text" name="ad_title" id="ad_title" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="image_filename" class="form-label">Legg til bilder (Kun .jpg- eller .png-format)</label>
                <input class="form-control" type="file" name="image" id="image_filename" multiple>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="ad_residence_type">Hva leies ut</label>
                <select class="form-select" name="ad_residence_type" id="ad_residence_type">
                    <option value="" selected hidden>...</option>
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
include(INC_PATH . '/footer.php'); ?>