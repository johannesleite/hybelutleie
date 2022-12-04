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

        while ($ad = $userAds->fetch_object()) {
        ?>
            <div class="card shadow-sm border-0 my-4">
                <div class="row g-0" <?php if ($ad->ad_status==0) {echo 'style="opacity: 50%;"';} ?>>
                    <div class="col-md-4 text-center bg-secondary bg-gradient" style="max-height: 300px;">
                        <img src="<?php echo $ad->ad_image; ?>" class="img-fluid rounded-start h-100" alt="Denne annonsen har ikke bilde">
                    </div>
                    <div class="col-md-8 align-self-center">
                        <div class="card-body py-1">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title"><?php echo $ad->ad_title; ?></h5>
                                <div class="text-muted">Dato lagt ut: <?php echo $ad->ad_timestamp; ?></div>
                            </div>
                            <p class="card-text">Boligtype: <?php echo $ad->residence_type_name; ?></p>
                            <p class="card-text">Størrelse: <?php echo $ad->ad_size; ?>kvm</p>
                            <div class="d-flex justify-content-between">
                            <p class="card-text"><strong>Pris: <?php echo $ad->ad_price; ?>,-</strong></p>                                
                            <p class="card-text"><strong>Status: <?php if ($ad->ad_status==1) {echo "Aktiv";} else echo "Deaktivert"; ?></strong></p>                                
                            </div>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $ad->ad_zip . ", " . $ad->zip_location; ?></p>
                                <form action="<?php echo url_for('/pages/viewOneAd.php'); ?>" method="get">
                                     <input type="hidden" name="ad_id" value="<?php echo $ad->ad_id; ?>">
                                     <button type="submit" class="btn btn-primary">Se hele annonsen</button>
                                 </form>
                                 <form action="<?php echo url_for('/pages/updateAd.php'); ?>" method="get">
                                    <input type="hidden" name="ad_id" value="<?php echo $ad->ad_id; ?>">
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
