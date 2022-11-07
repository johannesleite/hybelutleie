<?php
require_once('../private/initialize.php');
require(PRIVATE_PATH . '/advert.class.php');
//require(INC_PATH . '/db.inc.php');
include(INC_PATH . '/header.php');
?>

<!--bootstrap cards with each individual advert-->

    <div class="container d-flex align-items-center">
    <!--d-flex align-items-center-->
        <div class="col-lg-10 mx-auto">

        <?php
        $ad = new Advert;
        $result = $ad->adSelectAll();
        while ($row = $result->fetch_assoc()) {
        ?>

            <div class="card shadow-sm my-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $row['ad_image']; ?>" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['ad_title']; ?></h5>
                            <p class="card-subtitle mb-2 text-muted">Boligtype: <?php echo $row['ad_residence_type']; ?></p>
                            <p class="card-text">Størrelse: <?php echo $row['ad_size']; ?>kvm</p>
                            <p class="card-text"><strong>Pris: <?php echo $row['ad_price']; ?>,-</strong></p>
                            <p class="card-text"><?php echo $row['ad_zip'] . ", " . $row['zip_location']; ?></p>
                            <p class="card-text"><small class="text-muted">Dato lagt ut: <?php echo $row['ad_timestamp']; ?></small></p>
                        </div>
                    </div>
                </div>
            </div>

            <?php } ?>
        </div>
    </div>
<?php

include(INC_PATH . '/footer.php');
