<?php echo $header; ?>

<section class="brands_details_breadcrumb black_header" id="career_details_breadcrum">
    <div class="container">
        <ul>
            <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
            <li><a href="<?php echo HTTPS_HOST . 'media-center'; ?>"><?php echo $text_title_news; ?></a></li>
            <li><?php echo $mediaDetails['banner_title'];?></li>
        </ul>
    </div>
</section>
<section class="news_blog_main">
    <div class="container">
        <div class="news_blog_main_head">
            <?php if (!empty($mediaDetails['banner_title'])) : ?>
            <div class="news_blog_details_heading">
                <h1><?php echo $mediaDetails['banner_title'];?></h1>
            </div>
            <?php endif; ?>
            <?php if (!empty($mediaDetails['banner'])) : ?>
            <div class="news_blog_feature_img">
                <img src="<?php echo $mediaDetails['banner'];?>" alt="<?php echo $mediaDetails['banner_title'];?>">
            </div>
            <?php endif; ?>
            <div class="news_blog_info">
                <div class="news_blog_date">
                    <p><span><?php echo $text_only_date; ?></span><label dir="ltr"><?php echo date('d-M-Y', strtotime($mediaDetails['publish_date'])); ?></label></p>
                </div>
                <div class="news_blog_social_links">
                    <p><?php echo $text_only_share; ?></p>
                    <ul>
                        <?php if (!empty($share_links['twitter'])) : ?>
                        <li><a href="<?php echo $share_links['twitter']; ?>" target="_blank"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1_1463)"> <path d="M14.828 10.5858L23.9347 0H21.7767L13.8694 9.1915L7.55379 0H0.269531L9.81991 13.8992L0.269531 25H2.42765L10.778 15.2935L17.4477 25H24.732L14.8275 10.5858H14.828ZM11.8722 14.0216L10.9045 12.6376L3.20525 1.62459H6.51999L12.7334 10.5124L13.701 11.8965L21.7777 23.4493H18.463L11.8722 14.0222V14.0216Z" fill="#6D863A" /></g>
                                    <defs>
                                        <clipPath id="clip0_1_1463">
                                            <rect width="25" height="25" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?>
                        <!-- <?php if (!empty($share_links['twitter'])) : ?>
                        <li><a href="<?php echo $share_links['twitter']; ?>"  target="_blank"><svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1_1455)">
                                        <path d="M18.75 0H6.25C2.75 0 0 2.75 0 6.25V18.75C0 22.25 2.75 25 6.25 25H18.75C22.25 25 25 22.25 25 18.75V6.25C25 2.75 22.25 0 18.75 0ZM22.5 18.75C22.5 20.875 20.875 22.5 18.75 22.5H6.25C4.125 22.5 2.5 20.875 2.5 18.75V6.25C2.5 4.125 4.125 2.5 6.25 2.5H18.75C20.875 2.5 22.5 4.125 22.5 6.25V18.75Z"
                                            fill="#6D863A" />
                                        <path d="M12.5 6.25C9 6.25 6.25 9 6.25 12.5C6.25 16 9 18.75 12.5 18.75C16 18.75 18.75 16 18.75 12.5C18.75 9 16 6.25 12.5 6.25ZM12.5 16.25C10.375 16.25 8.75 14.625 8.75 12.5C8.75 10.375 10.375 8.75 12.5 8.75C14.625 8.75 16.25 10.375 16.25 12.5C16.25 14.625 14.625 16.25 12.5 16.25Z" fill="#6D863A" />
                                        <path
                                            d="M18.75 7.5C19.4404 7.5 20 6.94036 20 6.25C20 5.55964 19.4404 5 18.75 5C18.0596 5 17.5 5.55964 17.5 6.25C17.5 6.94036 18.0596 7.5 18.75 7.5Z" fill="#6D863A" /></g>
                                    <defs>
                                        <clipPath id="clip0_1_1455">
                                            <rect width="25" height="25" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </a>
                        </li>
                        <?php endif; ?> -->
                        <?php if (!empty($share_links['facebook'])) : ?>
                        <li><a href="<?php echo $share_links['facebook']; ?>"  target="_blank"><svg width="12" height="23" viewBox="0 0 12 23" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.70283 23V12.5094H11.0696L11.5748 8.4198H7.70283V5.80919C7.70283 4.62553 8.01595 3.81888 9.64135 3.81888L11.711 3.81799V0.160114C11.3531 0.111487 10.1245 0 8.6945 0C5.70844 0 3.66413 1.90551 3.66413 5.40416V8.4198H0.287109V12.5094H3.66413V23H7.70283Z" fill="#6D863A" />
                                  </svg>
                                 </a>
                          </li>
                          <?php endif; ?>
                     </ul>
                </div>
            </div>
        </div>
        <?php if (!empty($mediaDetails['description'])) { ?>
        <div class="news_blog_body_main">
           <?php echo $mediaDetails['description'];?>
        </div>
        <?php } ?>
    </div>
</section>
<?php if (!empty($relatedmediacenter)) { ?>
<section class="news_blog_details_listing">
    <div class="container">
        <div class="news_details_listing_head">
            <div class="row align-items-center">
            <?php if (!empty($newsblock)) { ?>
               <div class="col-md-6">
                    <div class="news_details_listing_head_main">
                        <h4 class="short_heading"><?php echo $newsblock['title']; ?></h4>
                        <?php echo $newsblock['content']; ?>
                    </div>
                </div>
                <?php } ?>
                <div class="col-md-6">
                    <div class="our_team_slider_btns">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/left.png" alt="left" class="custom-prev-btn_3">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/right.png" alt="right" class="custom-next-btn_3">
                    </div>
                </div>
            </div>
        </div>
        <div class="news_blog_details_listing_main">
          <div class="owl-carousel owl-theme">
            <?php foreach ($relatedmediacenter as $relatedmcenter) { ?>
              <div class="news_blog_main_items">
                    <div class="new_blog_img">
                        <img src="<?php echo $relatedmcenter['image']; ?>" alt="Blog Images">
                    </div>
                    <div class="news_blogs_details">
                        <div class="_news_blog_date">
                            <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/calendar.svg" alt="calendar"> <span dir="ltr"> <?php echo date('d M Y', strtotime($relatedmcenter['publish_date'])); ?></span>
                        </div>
                        <div class="news_blog_heading">
                            <h3><?php echo $relatedmcenter['title']; ?></h3>
                            <p><?php echo $relatedmcenter['short_description']; ?></p>
                        </div>
                        <div class="news_blog_btn">
                            <a href="<?php echo $relatedmcenter['href']; ?>"><?php echo $text_learn_more; ?> <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/btn_arrow.svg" alt="Arrow"></a>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php echo $footer; ?>
