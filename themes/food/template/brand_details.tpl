<?php echo $header; ?>

<section class="brands_details_breadcrumb black_header">
    <div class="container">
        <ul>
            <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
            <li><a href="<?php echo HTTPS_HOST . 'brands'; ?>"><?php echo $text_our_brands; ?></a></li>
            <li><?php echo $BrandsDetails['brand_name'];?></li>
        </ul>
    </div>
</section>
<section class="brand_details_gallery">
 <div class="container">
<div id="gallery" class="photos-grid-container gallery">
    <?php if (!empty($slider_images)) : ?>
        <div class="main-photo">
            <a href="<?php echo BASE_URL . 'uploads/image/brands/' . $slider_images[0]['image']; ?>" class="glightbox" data-glightbox="gallery">
                <img src="<?php echo BASE_URL . 'uploads/image/brands/' . $slider_images[0]['image']; ?>" alt="image" />
            </a>
        </div>
        <div class="sub">
            <?php foreach (array_slice($slider_images, 1) as $image) : ?>
                <div class="img-box">
                    <a href="<?php echo BASE_URL . 'uploads/image/brands/' . $image['image']; ?>" class="glightbox" data-glightbox="gallery">
                        <img src="<?php echo BASE_URL . 'uploads/image/brands/' . $image['image']; ?>" alt="image" />
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
      <?php endif; ?>
  </div>
        <div class="opening_hours">
            <div class="row">
                <div class="col-lg-8">
                    <div class="opening_hours_main">
                        <?php if (!empty($BrandsDetails['brand_name'])) : ?>
                        <h2><?php echo $BrandsDetails['brand_name'];?></h2>
                        <?php endif; ?>
                        <?php echo $BrandsDetails['full_description'];?>
                    </div>
                </div>
                <?php if (!empty($BrandsDetails['opening_time']) && !empty($BrandsDetails['closing_time'])) : ?>
                <div class="col-lg-4">
                    <div class="opening_hours_details">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/clock.svg" alt="Clock">
                        <h5><?php echo $text_opening_hours; ?></h5>
                        <p><?php echo $BrandsDetails['opening_time'];?> - <?php echo $BrandsDetails['closing_time'];?></p>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php if (!empty($MenuRepeator)) : ?>
<section class="our_menu custom_padding">
    <div class="container">
        <div class="row align-items-end">
           <?php if (!empty($brandmenublock)) :?>
            <div class="col-md-8">
                <div class="our_menu_head">
                    <h4 class="short_heading"><?php echo $brandmenublock['title']; ?></h4>
                    <?php echo $brandmenublock['content']; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-4">
                <div class="our_team_slider_btns">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/left.png" alt="left" class="custom-prev-btn_1">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/right.png" alt="right" class="custom-next-btn_1">
                </div>
            </div>
        </div>
        <div class="our_menu_main_item">
            <div class="owl-carousel owl-theme">
                <?php foreach ($MenuRepeator as $Menu) :?>
                <div class="our_menu_item">
                    <div class="our_latest_menu_img">
                        <img src="<?php echo BASE_URL . 'uploads/image/brands/' . $Menu['image']; ?>" alt="Menu">
                    </div>
                    <div class="our_latest_menu_details">
                        <h5><?php echo $Menu['title']; ?></h5>
                         <?php if (!empty($Menu['pdf'])) :?>
                        <a href="<?php echo BASE_URL . 'uploads/image/brands/pdf/' . $Menu['pdf']; ?>" target="_blank"><?php echo $text_only_view; ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
<section class="brand_contact">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="brand_Contact_details">
                    <div class="brand_contact_details_head">
                        <h4 class="short_heading"><?php echo $text_contact_details; ?></h4>
                        <h3><?php echo $text_coasterra; ?></h3>
                    </div>
                    <div class="brand_contact_details_link">
                    <ul>
                        <?php if (!empty($BrandsDetails['phone'])) : ?>
                            <li>
                                <a href="tel:<?php echo $BrandsDetails['phone']; ?>">
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/phone.svg" alt="Phone">
                                    <?php echo $BrandsDetails['phone']; ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($BrandsDetails['email'])) : ?>
                            <li>
                                <a href="mailto:<?php echo $BrandsDetails['email']; ?>">
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/mail.svg" alt="Mail">
                                    <?php echo $BrandsDetails['email']; ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($BrandsDetails['address'])) : ?>
                            <li>
                                <a href="https://www.google.com/maps?q=<?php echo $BrandsDetails['latitude']; ?>,<?php echo $BrandsDetails['longitude']; ?>" target="_blank">
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/location-pin.svg" alt="Location">
                                    <?php echo $BrandsDetails['address']; ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if (!empty($BrandsDetails['opening_time']) && !empty($BrandsDetails['closing_time'])) : ?>
                            <li>
                                <a href="#" onclick="return false">
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/clock.svg" alt="Clock">
                                    <span dir="ltr"><?php echo $BrandsDetails['opening_time']; ?> - <?php echo $BrandsDetails['closing_time']; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    </div>
                    <div class="brands_contact_follow_us">
                        <h4><?php echo $text_follow_on; ?></h4>
                        <div class="brands_Contat_social_link">
                            <ul>
                            <?php if (!empty($BrandsDetails['facebook_url'])) :?>
                                <li><a href="<?php echo $BrandsDetails['facebook_url'];?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook"></a></li>
                                <?php endif; ?>
                                <?php if (!empty($BrandsDetails['instagram_url'])) :?>
                                <li><a href="<?php echo $BrandsDetails['instagram_url'];?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="insta"></a></li>
                                <?php endif; ?>
                                <?php if (!empty($BrandsDetails['x_url'])) : ?>
                                <li><a href="<?php echo $BrandsDetails['x_url'];?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="twitter"></a></li>
                                <?php endif; ?>
                                <?php if (!empty($BrandsDetails['youtube_url'])) : ?>
                                <li><a href="<?php echo $BrandsDetails['youtube_url']; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="youtube"></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (!empty($BrandsDetails['longitude']) && !empty($BrandsDetails['latitude'])) : ?>
            <div class="col-lg-7">
                <div class="brand_details_map">
                <iframe
                src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAdpbECdjmT1Bacw3Rxa81whyIHF4h_PUg&q=<?php echo $BrandsDetails['latitude']; ?>,<?php echo $BrandsDetails['longitude']; ?>"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<section class="more_brands custom_padding">
    <div class="container">
        <div class="row align-items-end">
            <?php if (!empty($relatedbrandblock)) :?>
            <div class="col-md-8">
                <div class="more_brands_head">
                    <h4 class="short_heading"><?php echo $relatedbrandblock['title']; ?></h4>
                    <?php echo $relatedbrandblock['content']; ?>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-4">
                <div class="our_team_slider_btns">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/left.png" alt="left" class="custom-prev-btn_2">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/right.png" alt="right" class="custom-next-btn_2">
                </div>
            </div>
        </div>
        <div class="more_brands_items_main">
            <div class="owl-carousel owl-theme">
                <?php if (!empty($morebrands)) :?>
                    <?php foreach ($morebrands as $morebrand) :?>
                <div class="more_brands_item">
                    <a href="<?php echo HTTPS_HOST . 'brands' . '/' . $morebrand['seo_url']; ?>">
                        <div class="more_brands_item_img">
                            <img src="<?php echo BASE_URL . 'uploads/image/brands/' . $morebrand['thumbnail']; ?>" alt="Brands Imgaes">
                        </div>
                        <div class="more_brands_item_details">
                            <div class="more_item_details_img">
                                <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/brand_logo2.svg" alt="Brand Logo">
                            </div>
                            <div class="more_brands_img_details">
                                <h4><?php echo $morebrand['name']; ?></h4>
                                <p><?php echo $morebrand['location_name']; ?></p>
                            </div>

                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<?php echo $footer; ?>