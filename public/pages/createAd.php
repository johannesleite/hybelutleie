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
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
            <div class="form-outline mb-3">
                <label class="form-label" for="adTitle">Tittel</label>
                <input type="text" name="adTitle" id="adTitle" class="form-control" />
            </div>
            <div class="mb-3">
                <label for="formFileMultiple" class="form-label">Legg til bilder (Kun .jpg- eller .jpeg-format)</label>
                <input class="form-control" type="file" name="formFileMultiple" id="formFileMultiple" multiple>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adResidenceType">Hva leies ut</label>
                <select class="form-select" name="adResidenceType" id="adResidenceType">
                    <option value="hybel">Hybel</option>
                    <option value="rom">Rom i kollektiv</option>
                </select>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adDescription">Beskrivelse</label>
                <textarea class="form-control" name="adDescription" id="description" rows="8" placeholder="Legg til beskrivelse her"></textarea>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adSize">Pris</label>
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

    $adTitle = $formFileMultiple = $adResidenceType = $adDescription  = $streetAddress = '';
    $adSize = $price = $zipcode = '';

    $adTitle = $_POST["adTitle"];
    $formFileMultiple = $_POST["formFileMultiple"];
    $adResidenceType = $_POST["adResidenceType"];
    $adDescription = $_POST["adDescription"];
    $adSize = $_POST["adSize"];
    $price = $_POST["price"];
    $streetAddress = $_POST["streetAddress"];
    $zipcode = $_POST["zipcode"];

    //preparing statement, binding parameters to the form data and executing statement before closing it.
    $db = new Database;
    $conn = $db->connection();
    $sql = $conn->prepare("INSERT INTO hybel (ad_title, ad_image, ad_residence_type, ad_desc, ad_size ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("sbssisi", $adTitle, $formFileMultiple, $adResidenceType, $adDescription, $adSize, $price, $streetAddress, $zipcode);
    $sql->execute();

    $sql->close();
    $conn->close();
}


include(INC_PATH . '/footer.php'); ?>