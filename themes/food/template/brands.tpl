<?php echo $header; ?>

<style>
.brand_main_item a {
    pointer-events: auto; /* Make sure it's clickable */
    z-index: 10; /* Bring the link to the front */
}
</style>

<?php if (!empty($banner)) { ?>
<section class="innerpages_banner"
    style="background: url('<?php echo $banner['image']; ?>') !important; background-size: cover !important; background-repeat: no-repeat !important; background-position: center !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner_banner_content">
                    <h1><?php echo $banner['title']; ?></h1>
                    <p><?php echo $banner['short_description']; ?></p>
                </div>
                <div class="innerpages_breadcrum">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
                        <li><?php echo $banner['title']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<section class="brands_item">
    <div class="container">
    <?php if (!empty($brands)) : ?>
        <div class="brands_items_main">
            <?php 
            $counter = 1;
            foreach ($brands as $brand) { 
                if ($counter <= 5 || ($counter > 10 && $counter <= 15) || ($counter > 20 && $counter <= 25)) {
                    $class = 'div' . (($counter - 1) % 5 + 1);
                } else {
                    $class = 'rev' . (($counter - 6) % 5 + 1);
                } ?>
            <div class="brand_main_item <?php echo $class; ?>">
                  <!-- <a href="<?php echo $brand['href']; ?>"> -->
                  <a href="javascript:void(0);">
                    <div class="brand_listing">
                        <div class="brand_feature_img">
                            <img src="<?php echo $brand['thumbnail']; ?>" alt="">
                        </div>
                        <div class="brand_main_item_title">
                            <div class="brand_main_logo">
                                <img src="<?php echo $brand['icon']; ?>" alt="Brands">
                            </div>
                            <div class="brand_mainlogo_text" style="position: relative;">
                                <h3><?php echo $brand['name']; ?></h3>
                                <p><?php echo $brand['location_name']; ?></p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <?php 
                $counter++;
            } ?>
        </div>
        <div class="media-pagination" data-aos="fade-up" data-aos-duration="1200">
        <ul class="pagination justify-content-center">
            <?php echo $pagination; ?>
        </ul>
    </div>
    <?php else: ?>
    <div class="row">
      <div class="col-md-12">
        <div class="not_found"><div class="norecord"><?php echo $text_no_record; ?></div> </div>
        </div>
     </div>
   <?php endif; ?>
    </div>
</section>

<?php echo $footer; ?>