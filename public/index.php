<?php
require_once('../private/initialize.php');
include(INC_PATH . '/header.php');
?>

<!--bootstrap cards with each individual advert-->
<div class="container d-flex align-items-center">

    <!--Filtering of adverts-->
    <div class="pt-3 col-lg-10 mx-auto">
        <form action="" method="get">
            <select name="filter">
                <option value="" disabled selected>Filtrere</option>
                <option value="price_asc">Pris lav-høy</option>
                <option value="price_desc">Pris høy-lav</option>
                <option value="date_added_desc">Nyligste</option>
                <option value="date_added_asc">Eldste</option>
            </select>
            <button type="submit" class="btn btn-primary">Filtrér</button>
        </form>

        <?php

        //create new object and iterate through all rows
        $ads = new Advert();
        $ads = $ads->ad_select_all(isset($_GET['filter']) ? $_GET['filter'] : '');

        while ($ad = $ads->fetch_object()) {

        ?>

            <div class="card shadow-sm border-0 my-4">
                <div class="row g-0">
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
                            <p class="card-text"><strong>Pris: <?php echo $ad->ad_price; ?>,-</strong></p>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $ad->ad_zip . ", " . $ad->zip_location; ?></p>
                                <form action="<?php echo url_for('/pages/viewOneAd.php'); ?>" method="get">
                                    <input type="hidden" name="ad_id" value="<?php echo $ad->ad_id; ?>">
                                    <button type="submit" class="btn btn-primary">Se hele annonsen</button>
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
