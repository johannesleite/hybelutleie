<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');

//fetching id from get request
if (isset($_GET["ad_id"]))
    $ad_id = $_GET["ad_id"];
else {
    header("location:" . url_for('/index.php')); 
    exit(); 
}

$ad = new Advert;

$result = $ad->ad_select_one($ad_id);
while ($row = $result->fetch_object()) {
?>

    <!--bootstrap cards with each individual advert-->

    <div class="container d-flex align-items-center my-4">
        <div class="col-lg-10 mx-auto">
            <div class="row justify-content-center">
                <img src="<?php echo $row->ad_image; ?>" class="mb-2 ad-single-image" alt="Denne annonsen har ikke bilde">
            </div>
            <div class="align-self-center">
                <div class="d-flex justify-content-between">
                    <h4 class="mb-4"><?php echo $row->ad_title; ?></h4>
                    <div class="text-muted">Dato lagt ut: <?php echo $row->ad_timestamp; ?></div>
                </div>
                <div class="d-flex justify-content-between">
                    <div class="col-md-7">
                        <p><?php echo nl2br($row->ad_desc); ?></p>
                        <p class="">Boligtype: <?php echo $row->residence_type_name; ?></p>
                        <p class="">Størrelse: <?php echo $row->ad_size; ?>kvm</p>
                        <p class=""><strong>Pris: <?php echo $row->ad_price; ?>,-</strong></p>
                    </div>
                    <div class="col-md-4 text-end p-2 bg-light shadow-sm">
                        <div class="ratio ratio-4x3"><?php echo api_address_map($row->ad_street_address, $row->ad_zip);?></div>
                        <p class=""><?php echo $row->ad_street_address . ", " . $row->ad_zip . " " . $row->zip_location; ?></p>
                        <p class=""><strong><?php echo $row->user_name; ?></strong></p>
                        <form action="<?php echo url_for('/pages/contactSeller.php'); ?>" method="post">
                            <input type="hidden" name="to_email" value="<?php echo $row->user_email; ?>">
                            <input type="hidden" name="ad_title" value="<?php echo $row->ad_title; ?>">
                            <button type="submit" class="btn btn-ads btn-primary">Kontakt utleier</button>
                        </form>
                    </div>
                </div>
            </div>
  <?php } ?>
        </div>
    </div>
<?php

include(INC_PATH . '/footer.php');
