<?php
require_once('../../private/initialize.php');
include(INC_PATH . '/header.php');
require_login();
?>

<!--bootstrap cards with each individual advert-->

<div class="container d-flex align-items-center">
    <!--d-flex align-items-center-->
    <div class="col-lg-10 mx-auto">

        <?php

        $ads = new Advert();

        $userAds = $ads->ad_select_own($session->user_id);

        while ($row = $userAds->fetch_object()) {
        ?>
            <div class="card shadow-sm border-0 my-4">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="<?php echo $row->ad_image; ?>" class="img-fluid rounded-start" alt="advert image">
                    </div>
                    <div class="col-md-8 align-self-center">
                        <div class="card-body py-1">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><?php echo $row->ad_title; ?></h5>
                                <div class="text-muted">Dato lagt ut: <?php echo $row->ad_timestamp; ?></div>
                            </div>
                            <p class="card-text">Boligtype: <?php echo $row->residence_type_name; ?></p>
                            <p class="card-text">Størrelse: <?php echo $row->ad_size; ?>kvm</p>
                            <div class="d-flex justify-content-between">
                            <p class="card-text"><strong>Pris: <?php echo $row->ad_price; ?>,-</strong></p>                                
                            <p class="card-text"><strong>Status: <?php if ($row->ad_status==1) {echo "Aktiv";} else echo "Deaktivert"; ?></strong></p>                                
                            </div>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $row->ad_zip . ", " . $row->zip_location; ?></p>
                                <form action="<?php echo url_for('/pages/updateAd.php'); ?>" method="get">
                                    <input type="hidden" name="ad_id" value="<?php echo $row->ad_id; ?>">
                                    <button type="submit" class="btn btn-primary">Endre annonsen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php

include(INC_PATH . '/footer.php');
