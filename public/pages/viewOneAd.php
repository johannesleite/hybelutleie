<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--bootstrap cards with each individual advert-->

        <?php
        $ad = new Advert;

        $adId = $_GET["ad_id"];

        $result = $ad->adSelectOne($adId);
        while ($row = $result->fetch_assoc()) {
        ?>
            <div class="container d-flex align-items-center my-4">
                <div class="col-lg-10 mx-auto">
                    <div class="row">
                        <img src="<?php echo $row['ad_image']; ?>" class="mb-2" alt="advert image">
                    </div>
                    <div class="align-self-center">
                        <div class="d-flex justify-content-between">
                            <h4 class="mb-4"><?php echo $row['ad_title']; ?></h4>
                            <div class="text-muted">Dato lagt ut: <?php echo $row['ad_timestamp']; ?></div>
                        </div>
                        <p class=""><?php echo nl2br($row['ad_desc']); ?></p>
                        <p class="">Boligtype: <?php echo $row['residence_type_name']; ?></p>
                        <p class="">Størrelse: <?php echo $row['ad_size']; ?>kvm</p>
                        <div class="d-flex justify-content-between">
                            <p class=""><strong>Pris: <?php echo $row['ad_price']; ?>,-</strong></p>
                            <p class=""><strong><?php echo $row['user_firstname']; ?></strong></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p><?php echo $row['ad_zip'] . ", " . $row['zip_location']; ?></p>
                            <a href="mailto:<?php echo $row['user_email']?>" class="btn btn-primary">Kontakt utleier</a>
                        </div>
                    </div>

  <?php } ?>
        </div>
    </div>
<?php

include(INC_PATH . '/footer.php');
