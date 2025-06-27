
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="utf-8" />
    <?php if ($meta_description) { ?>
        <meta name="description" content="<?php echo ($meta_description) ? $meta_description : ''; ?>">
    <?php } ?>
    <?php if ($meta_keywords) { ?>
        <meta name="keywords" content="<?php echo ($meta_keywords) ? $meta_keywords : ""; ?>">
    <?php } ?>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?php echo $config_name; ?></title>
    <?php if (!empty($flogo)) : ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $flogo; ?>">
    <?php endif; ?>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/food/assets/includes/OwlCarousel/dist/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/food/assets/includes/OwlCarousel/dist/assets/owl.theme.default.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/food/assets/bootstrap/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/food/assets/css/style.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>themes/food/assets/css/responsive.css">
</head>

 <?php
$urlpath = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
if ($urlpath[0] == "") {
    $new_lng = 'en';
    $old_lng = 'ar';
} elseif ($urlpath[0] == "en") {
    $new_lng = 'en';
    $old_lng = 'ar';
} elseif ($urlpath[0] == "ar") {
    $new_lng = 'ar';
    $old_lng = 'en';
} else {
    $new_lng = 'en';
    $old_lng = 'ar';
}
$current_url =  str_replace("/" . $new_lng . "/", "", $_SERVER['REQUEST_URI']);
if ($old_lng == 'en') {
    $lang_url =  BASE_URL . $current_url;
} else {
    $lang_url =  BASE_URL . $old_lng . $current_url;
}
?>
<body class="<?php echo $body_class; ?> <?php echo $this->session->data['lang']; ?>" dir="<?php if ($this->session->data['lang'] == 'ar') { echo "rtl";  } else { echo "ltr"; } ?>"> 
    <nav class="navbar navbar-expand-lg" id="header">
        <div class="container">
            <div class="header_site_logo">
            <?php if (!empty($hlogo)) : ?>
                <a href="<?php echo HTTPS_HOST; ?>">
                    <img src="<?php echo $hlogo; ?>" alt="Logo" class="img-responsive" />
                </a>
          <?php endif; ?>
            </div>
            <div class="mobile_new_header">
                <div class="mobile_header">
                    <div class="language_Changer mobile_laguage_Changer_Show">
                    <?php if ($this->session->data['lang'] == 'en') { ?>
                        <a href="<?php echo $lang_url; ?>">العربية</a>
                        <?php } else { ?>
                            <a href="<?php echo $lang_url; ?>">English</a>
                            <?php } ?>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                
                <div class="mobile_social_item">
                    <div class="head_social_items">
                        <ul class="list-inline">
                        <?php if (!empty($config_facebook)) :?>
                            <li>
                                <a href="<?php echo $config_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook Logo" /></a>
                            </li>
                            <?php endif; ?>
                            <?php if (!empty($config_instagram)) :?>
                            <li>
                                <a href="<?php echo $config_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="Instagram Logo" /></a>
                            </li>
                            <?php endif; ?>
                            <?php if (!empty($config_twitter)) :?>
                            <li>
                                <a href="<?php echo $config_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="Twitter logo" /></a>
                            </li>
                            <?php endif; ?>
                            <?php if (!empty($config_youtube)) :?>
                            <li>
                                <a href="<?php echo $config_youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="Youtube Logo" /></a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <div class="header_main_links text-center text-md-left">
                <?php if (!empty($headerMenus)) : ?>
                    <ul class="menu_link">
                    <?php foreach ($headerMenus as $hmenu) :?>
                        <?php
                            if (($currentUrl == '/' || $currentUrl == "/ar/") && $hmenu['url'] == 'home') {
                                $activeClass = 'active';
                            } else {
                                $activeClass = (strpos($currentUrl, $hmenu['url']) !== false) ? 'active' : '';
                            }
                        ?>
                        <li class="menu_items <?php echo $activeClass; ?>">
                            <a href="<?php echo HTTPS_HOST . $hmenu['url']; ?>"><?php echo $hmenu['title']; ?></a>
                        </li>
                    <?php endforeach; ?>
                    <li class="menu_items dropdown company_dropdown_main mobile_dropdown_new">
                            <a class="btn company_drop_down dropdown-toggle" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false"><?php echo $text_our_companies_drop; ?>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- <li><a class="dropdown-item main" href="https://othaimfoods.com/" target="_blank">Al Othaim Food</a></li> -->
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_investment; ?>" target="_blank"><?php echo $text_al_othaim_investment; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_mall; ?>" target="_blank"><?php echo $text_al_othaim_mall; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_life; ?>" target="_blank"><?php echo $text_al_othaim_life; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_entertainment; ?>" target="_blank"><?php echo $text_al_othaim_entertainment; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_noircinema; ?>" target="_blank"><?php echo $text_al_othaim_noircinema; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_sport; ?>" target="_blank"><?php echo $text_al_othaim_sport; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_royal; ?>" target="_blank"><?php echo $text_al_othaim_royal; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_ai; ?>" target="_blank"><?php echo $text_al_othaim_ai; ?></a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                </div>

                <div class="header_social_links text-center text-md-right mobile_hide_menu">
                    <div class="dropdown company_dropdown_main">
                        <a class="btn company_drop_down dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $text_our_companies_drop; ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="<?php echo $href_al_othaim_investment; ?>" target="_blank"><?php echo $text_al_othaim_investment; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_mall; ?>" target="_blank"><?php echo $text_al_othaim_mall; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_life; ?>" target="_blank"><?php echo $text_al_othaim_life; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_entertainment; ?>" target="_blank"><?php echo $text_al_othaim_entertainment; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_noircinema; ?>" target="_blank"><?php echo $text_al_othaim_noircinema; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_sport; ?>" target="_blank"><?php echo $text_al_othaim_sport; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_royal; ?>" target="_blank"><?php echo $text_al_othaim_royal; ?></a></li>
                                <li><a class="dropdown-item" href="<?php echo $href_al_othaim_ai; ?>" target="_blank"><?php echo $text_al_othaim_ai; ?></a></li>
                            </li>
                        </ul>
                    </div>
                    <div class="head_social_items">
                        <ul class="list-inline">
                           <?php if (!empty($config_facebook)) :?>
                            <li>
                                <a href="<?php echo $config_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook Logo" /></a>
                            </li>
                             <?php endif; ?>
                             <?php if (!empty($config_instagram)) :?>
                            <li>
                                <a href="<?php echo $config_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="Instagram Logo" /></a>
                            </li>
                             <?php endif; ?>
                             <?php if (!empty($config_twitter)) :?>
                            <li>
                                <a href="<?php echo $config_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="Twitter logo" /></a>
                            </li>
                             <?php endif; ?>
                             <?php if (!empty($config_youtube)) :?>
                            <li>
                                <a href="<?php echo $config_youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="Youtube Logo" /></a>
                            </li>
                             <?php endif; ?>
                        </ul>
                    </div>
                    <div class="language_Changer mobile_laguage_Changer">
                        <?php if ($this->session->data['lang'] == 'en') { ?>
                        <a href="<?php echo $lang_url; ?>">العربية</a>
                        <?php } else { ?>
                            <a href="<?php echo $lang_url; ?>" style="text-transform: none;">English</a>
                            <?php } ?>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>