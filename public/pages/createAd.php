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
                <input class="form-control" type="file" name="files[]" id="formFileMultiple" multiple>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="adResidenceType">Hva leies ut</label>
                <select class="form-select" name="residenceType" id="residenceType">
                    <option value="hybel">Hybel</option>
                    <option value="rom">Rom i kollektiv</option>
                </select>
            </div>
            <div class="form-outline mb-3">
                <label class="form-label" for="description">Beskrivelse</label>
                <textarea class="form-control" name="adDescription" id="description" rows="8" placeholder="Legg til beskrivelse her"></textarea>
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

    $adTitle = $_POST["adTitle"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    //$inputArr += ['firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phone' => $phone];
    $inputArr += array('firstName' => $firstName, 'lastName' => $lastName, 'email' => $email, 'phone' => $phone);

    //preparing statement, binding parameters to the form data and executing statement before closing it.
    $sql = $conn->prepare("INSERT INTO hybel (ad_title, ad_image, ad_residence_type, ad_desc, ad_price, ad_street_address, ad_zip) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("s?ssisi", $firstName, $lastName, $email, $phone);
    $sql->execute();

    $sql->close();
    $conn->close();

}


include(INC_PATH . '/footer.php'); ?>