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

<section class="careers custom_padding" style="position:relative;overflow: hidden;">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="othaim_life_wrapper">
                    <h2 class="line_heading aos-init aos-animate"><?php echo $blockexcitingopportunities['title'];?></h2>
                    <div class="othaim_life_content aos-init aos-animate">
                        <div class="othaim_life_subheading">
                           <?php echo $blockexcitingopportunities['content'];?>
                        </div>
                        <div class="othaim_life_excerpt">
                            <div class="arrow_btn blue">
                                <a target="_blank"
                                    href="https://career23.sapsf.com/career?career_company=abdullahal&amp;lang=en_US&amp;company=abdullahal&amp;site">
                                    <span><?php echo $text_check_vacancies; ?></span><svg width="11" height="18" viewBox="0 0 11 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 17L9 9L1 1" stroke="#6D863A" stroke-width="1.5"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="image-container about_image_container">
        <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/food_wheel.svg">
    </div>
</section>

<?php echo $footer; ?>