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
<section class="cm_message custom_padding">
    <div class="container">
        <div class="row align-items-center">
            <?php if (!empty($AboutTopImage)) : ?>
            <div class="col-lg-6">
                <div class="cm-image">
                    <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $AboutTopImage['image'];?>" alt="CM">
                </div>
            </div>
             <?php endif; ?>
            <div class="col-lg-6">
                <div class="cm_message_main">
                    <h4 class="short_heading"><?php echo $messageblock['title']; ?></h4>
                    <?php echo $messageblock['content']; ?>
                    <div class="cm_name">
                        <h3><?php echo $barbarablock['title']; ?></h3>
                        <p><?php echo $barbarablock['content']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="image-container about_image_container">
        <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/food_wheel.svg">
    </div>
</section>
<section class="why_us custom_padding">
    <div class="container">
        <div class="why_us_head">
            <div class="row align-items-start">
                <?php if (!empty($blockwhyus)) :?>
                <div class="col-lg-6">
                    <div class="why_us_main">
                        <h4 class="short_heading"><?php echo $blockwhyus['title']; ?></h4>
                        <?php echo $blockwhyus['content'];?>
                    </div>
                </div>
                 <?php endif; ?>
                 <?php if (!empty($blockwhyussecond)) :?>
                <div class="col-lg-6">
                    <div class="why_us_main_body">
                      <?php echo $blockwhyussecond['content'];?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="why_us_body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="why_us_body_list">
                        <?php if (!empty($blockquistestfirst)) :?>
                        <div class="why_us_body_list_item">
                            <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/badge-discount.svg" alt="Icon">
                            <div class="why_us_body_list_heading">
                                <h4><?php echo $blockquistestfirst['title'];?></h4>
                               <?php echo $blockquistestfirst['content'];?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($blockquistestsecond)) :?>
                        <div class="why_us_body_list_item">
                            <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/poll-vertical-circle.svg" alt="Icon">
                            <div class="why_us_body_list_heading">
                                <h4><?php echo $blockquistestsecond['title'];?></h4>
                               <?php echo $blockquistestsecond['content'];?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php if (!empty($blockquistestthird)) :?>
                        <div class="why_us_body_list_item">
                            <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/badge-discount.svg" alt="Icon">
                            <div class="why_us_body_list_heading">
                                <h4><?php echo $blockquistestthird['title'];?></h4>
                               <?php echo $blockquistestthird['content'];?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if (!empty($AboutWhyUs)) : ?>
                <div class="col-lg-6">
                    <div class="why_us_body_list_images">
                        <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $AboutWhyUs['image'];?>" alt="Why_us">
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="our_vision custom_padding">
    <div class="container">
        <?php if (!empty($blockvisionvalues)) :?>
        <div class="our_vision_head">
            <h4 class="short_heading"><?php echo $blockvisionvalues['title']; ?></h4>
            <?php echo $blockvisionvalues['content']; ?>
        </div>
        <?php endif; ?>
        <div class="our_vision_body">
            <div class="our_vision_item">
                <?php if (!empty($blocknisiut)) :?>
                <div class="our_vision_item_main">
                    <div class="our_vision_item_head">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/badge-discount.svg" alt="Images">
                        <h4><?php echo $blocknisiut['title']; ?></h4>
                    </div>
                    <div class="our_vision_item_body">
                        <?php echo $blocknisiut['content']; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($blocknisiutsecond)) :?>
                <div class="our_vision_item_main">
                    <div class="our_vision_item_head">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/badge-discount.svg" alt="Images">
                        <h4><?php echo $blocknisiutsecond['title']; ?></h4>
                    </div>
                    <div class="our_vision_item_body">
                        <?php echo $blocknisiutsecond['content']; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            <?php if (!empty($AboutVision)) : ?>
            <div class="our_vision_main_img">
                <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $AboutVision['image'];?>" alt="Images">
            </div>
            <?php endif; ?>
            <?php if (!empty($blockvisionvaluesright)) :?>
            <div class="our_vision_main_para">
                <?php echo $blockvisionvaluesright['content']; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php if (!empty($OverTeam)) { ?>
<section class="our_team custom_padding">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="our_team_head">
                    <h4 class="short_heading"><?php echo $blockourteam['title']; ?></h4>
                    <h3><?php echo $blockourteam['content']; ?></h3>
                </div>
            </div>
            <div class="col-md-6">
                <div class="our_team_slider_btns">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/left.png" alt="left" class="custom-prev-btn12">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/right.png" alt="right" class="custom-next-btn12">
                </div>
            </div>
        </div>
        <div class="our_team_slider">
            <div class="owl-carousel owl-theme">
                <?php foreach ($OverTeam as $team) {?>
                <div class="our_team_item">
                    <img src="<?php echo BASE_URL; ?>uploads/image/ourteams/<?php echo $team['image'];?>" alt="Team">
                    <div class="our_team_desination">
                        <h4><?php echo $team['title']; ?></h4>
                        <p><?php echo $team['designation']; ?></p>
                    </div>
                </div>
              <?php }?>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php if ($blockalothaim) { ?>
<section class="company_message">
    <div class="container">
        <div class="row">
            <?php if (!empty($AboutalothaimGroupImage)) :?>
            <div class="col-lg-8">
                <div class="company_message_main">
                    <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $AboutalothaimGroupImage['image'];?>" alt="Company">
                </div>
            </div>
            <?php endif; ?>
            <div class="col-lg-4">
                <div class="company_message_main_para">
                    <div class="company_message_group">
                        <h4><?php echo $blockalothaim['title']; ?></h4>
                        <p><?php echo $blockalothaim['content']; ?></p>
                    </div>
                    <div class="company_message_group_img">
                        <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/aog_group.svg" alt="Images">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php if ($OverHistory) { ?>
<section class="history">
    <div class="row">
        <div class="col-lg-7">
            <div class="history_slider">
                <div class="swiper mySwiper" id="history_slider_1">
                    <span class="slider_item_history_head">
                        <h4 class="short_heading"><?php echo $blockhistory['title']; ?></h4>
                        <?php echo $blockhistory['content']; ?>
                    </span>
                    <div class="swiper-wrapper">
                    <?php foreach ($OverHistory as $history) : ?>
                        <?php 
                        // Ensure the date is correctly formatted before processing
                        $formattedDate = strtotime($history['date']);
                        if ($formattedDate !== false) {
                            $year = date('Y', $formattedDate);
                        } 
                        $short_description = str_replace('&nbsp;', ' ', html_entity_decode($history['short_description'], ENT_QUOTES, 'UTF-8'));
                       ?>
                        <div class="swiper-slide" date="<?= $year; ?>">
                            <div class="history_Slider_items_main">
                                <div class="history_slider_item_body">
                                    <h3><?= $year; ?></h3>
                                    <?= $short_description; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
         <?php if (!empty($AboutHistoryImage)) :?>
        <div class="col-lg-5">
            <div class="history_main_image">
                <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $AboutHistoryImage['image'];?>" alt="History">
            </div>
        </div>
       <?php endif; ?>
    </div>
</section>
<?php } ?>
<?php if ($awards) { ?>
<section class="our_awards">
    <div class="container">
        <div class="row align-items-end">
            <div class="col-md-6">
                <div class="awards_main">
                    <h4 class="short_heading"><?php echo $awardsblock['title'];?></h4>
                    <?php echo $awardsblock['content'];?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="our_team_slider_btns">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/left.png" alt="left" class="custom-prev-btn11">
                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/right.png" alt="right" class="custom-next-btn11">
                </div>
            </div>
        </div>
        <div class="our_award_slider">
            <div class="owl-carousel owl-theme">
            <?php foreach ($awards as $award) {?>
                <div class="our_award_slider_item">
                    <div class="our_award_slider_item_image">
                        <img src="<?php echo BASE_URL; ?>uploads/image/awards/<?php echo $award['image'];?>" alt="<?php echo $award['title']; ?>">
                    </div>
                    <div class="our_award_slider_item_title">
                        <h3><?php echo $award['title']; ?></h3>
                        <?php echo htmlspecialchars_decode($award['short_description']); ?>
                    </div>
                    <p class="award_date">
                    <?php echo date('d-M-Y', strtotime($award['publish_date'])); ?>
                    </p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<?php } ?>
<?php echo $footer; ?>