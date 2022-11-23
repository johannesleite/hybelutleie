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
                <label class="form-label" for="adTitle">Tittel</label>
                <input type="text" name="adTitle" id="adTitle" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="imageFilename" class="form-label">Legg til bilder (Kun .jpg- eller .jpeg-format)</label>
                <input class="form-control" type="file" name="imageFilename" id="imageFilename" multiple>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adResidenceType">Hva leies ut</label>
                <select class="form-select" name="adResidenceType" id="adResidenceType">
                    <option value="hybel">Hybel</option>
                    <option value="rom i kollektiv">Rom i kollektiv</option>
                </select>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adDescription">Beskrivelse</label>
                <textarea class="form-control" name="adDescription" id="description" rows="8" placeholder="Legg til beskrivelse her"></textarea>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adSize">Størrelse i kvm</label>
                <input type="text" name="adSize" id="adSize" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="price">Pris</label>
                <input type="text" name="price" id="price" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="streetAddress">Gateadresse</label>
                <input type="text" name="streetAddress" id="streetAddress" class="form-control" />
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="zipcode">Postnummer</label>
                <input type="text" name="zipcode" id="zipcode" class="form-control" />
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Legg til annonse</button>
        </form>
    </div>
</div>

<?php
if (isset($_POST["submit"])) {

    $adTitle = $adResidenceType = $adDescription  = $streetAddress = '';
    $adSize = $price = $zipcode = '';

    $adTitle = $_POST["adTitle"];
    $adResidenceType = $_POST["adResidenceType"];
    $adDescription = $_POST["adDescription"];
    $adSize = $_POST["adSize"];
    $price = $_POST["price"];
    $streetAddress = $_POST["streetAddress"];
    $zipcode = $_POST["zipcode"];

    $dir = $_SERVER['DOCUMENT_ROOT'].'/hybelutleie/public/assets/img/';
    $imageFilename = $_FILES["imageFilename"]["name"];
    $SQLfilepath = urlFor('/assets/img/').$imageFilename;
    $tempFilename = $_FILES["imageFilename"]["tmp_name"];

    if (is_uploaded_file($tempFilename)) {
        move_uploaded_file($tempFilename, $dir.$imageFilename);
        echo "<script>alert(\"Annonsen ble lastet opp!\")</script>";
    } else {
        echo "Filen finnes ikke, prøv på nytt";
    }
    
    $ad = new Advert;
    $ad->ad_insert($adTitle, $SQLfilepath, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode);

}

include(INC_PATH . '/footer.php'); ?>