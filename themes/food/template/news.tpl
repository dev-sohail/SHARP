<?php echo $header; ?>
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
<section class="news_listing custom_padding">
    <div class="container">
    <?php if (!empty($mediacenters)) : ?>
        <div class="news_listing_main">
            <?php foreach ($mediacenters as $media) { ?>
            <div class="news_blog_main_items">
                <div class="new_blog_img">
                    <img src="<?php echo $media['image']; ?>" alt="Blog Images">
                </div>
                <div class="news_blogs_details">
                    <div class="_news_blog_date">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/calendar.svg" alt="calendar"> <span dir="ltr"><?php echo date('d M Y', strtotime($media['publish_date'])); 
                        ?></span>
                    </div>
                    <div class="news_blog_heading">
                        <h3><?php echo $media['title']; ?></h3>
                        <p><?php echo $media['short_description']; ?></p>
                    </div>
                    <div class="news_blog_btn">
                        <a href="<?php echo $media['href']; ?>"><?php echo $text_learn_more; ?> <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/btn_arrow.svg" alt="Arrow"></a>
                    </div>
                </div>
            </div>
            <?php }?>
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