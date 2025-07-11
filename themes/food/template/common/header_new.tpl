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
    <style>
        /* for desktop */
        @media (min-width: 992px) {
            .navbar-expand-lg .navbar-toggler {
                display: flex !important;
                background: none;
                border: none;
                font-size: 1.5rem;
                margin-left: 20px;
            }

            .navbar-toggler {
                display: none !important;
            }

            .navbar-expand-lg .navbar-collapse.navbar-toggler {
                display: none !important;
            }

            .menu-shown {
                display: flex !important;
            }

            .navbar-collapse {
                margin-top: 10%;
            }

            /* Show dropdown horizontally in full-screen */
            .navbar-collapse.menu-shown ul.menu_link .dropdown-menu {
                display: none !important;
            }

            .navbar-collapse.menu-shown ul.menu_link .company_dropdown_main:hover .dropdown-menu,
            .navbar-collapse.menu-shown ul.menu_link .company_dropdown_main:focus-within .dropdown-menu,
            .navbar-collapse.menu-shown ul.menu_link .company_dropdown_main.show .dropdown-menu {
                display: flex !important;
            }

            .navbar-collapse ul.menu_link {
                position: absolute;
                top: 100px;
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: center;
                width: 100%;
                list-style: none;
                padding: 0;
                margin: 0;
                /* gap: auto; */
            }

            .navbar-collapse ul.menu_link li a {
                color: white;
                font-size: 32px;
                padding: 0 10px;
                text-decoration: none;
                white-space: nowrap;
            }
        }

        /* for mobile */
        @media (max-width: 991.98px) {
            .desktop_new_header .navbar-toggler {
                display: none !important;
            }

            /* .navbar-toggler {
                display: block !important;
            } */

            /* .navbar-toggler,
            .menu-shown {
                display: block !important;
            } */

            .navbar-collapse {
                margin-top: 25%;
            }

            .navbar-collapse ul.menu_link .dropdown-menu.show,
            .navbar-collapse.show {
                opacity: 1 !important;
                visibility: visible !important;
                z-index: 9999 !important;
                display: block !important;
            }

            .navbar-collapse ul.menu_link {
                flex-direction: column !important;
                gap: 1rem;
            }

            .navbar-collapse ul.menu_link li {
                padding: 0;
                margin-bottom: 20px;
            }

            .navbar-collapse ul.menu_link li a {
                color: white;
                font-size: 19px;
                padding: 0 10px;
                text-decoration: none;
                white-space: nowrap;
            }

            .navbar-collapse ul.menu_link .dropdown-menu {
                position: static;
                display: none !important;
                background: none;
                box-shadow: none;
                border: none;
                flex-direction: column;
                gap: 0;
                padding: 0;
            }

            .navbar-collapse ul.menu_link .company_dropdown_main.show .dropdown-menu {
                display: block !important;
            }

            .navbar-collapse ul.menu_link {
                position: absolute;
                top: 100px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                width: 100%;
                list-style: none;
                padding: 0;
                margin: 0;
                /* gap: auto; */
            }

            /* Animated Dot Menu Icon */
            .menu-icon {
                position: relative;
                width: 30px;
                height: 30px;
                cursor: pointer;
            }

            .menu-icon .dot {
                position: absolute;
                top: 50%;
                left: 50%;
                width: 6px;
                height: 6px;
                background-color: #dc3545;
                border-radius: 6px;
                transform: translate(-50%, -50%);
                transition: margin 0.4s ease 0.4s, width 0.4s ease;
            }

            .menu-icon .dot:nth-of-type(1) {
                margin-top: -12px;
                margin-left: -12px;
                transform: translate(-50%, -50%) rotate(45deg);
            }

            .menu-icon .dot:nth-of-type(2) {
                margin-top: -12px;
                transform: translate(-50%, -50%) rotate(-45deg);
            }

            .menu-icon .dot:nth-of-type(3) {
                margin-top: -12px;
                margin-left: 12px;
            }

            .menu-icon .dot:nth-of-type(4) {
                margin-left: -12px;
            }

            .menu-icon .dot:nth-of-type(5) {
                /* Center dot - no margin needed */
            }

            .menu-icon .dot:nth-of-type(6) {
                margin-left: 12px;
            }

            .menu-icon .dot:nth-of-type(7) {
                margin-top: 12px;
                margin-left: -12px;
            }

            .menu-icon .dot:nth-of-type(8) {
                margin-top: 12px;
            }

            .menu-icon .dot:nth-of-type(9) {
                margin-top: 12px;
                margin-left: 12px;
            }

            .menu-icon.clicked .dot {
                transition: margin 0.4s ease, width 0.4s ease 0.4s;
                margin-left: 0;
                margin-top: 0;
            }

            .menu-icon.clicked .dot:nth-of-type(1) {
                width: 30px;
            }

            .menu-icon.clicked .dot:nth-of-type(2) {
                width: 30px;
            }

            .menu-icon.clicked .dot:nth-of-type(3),
            .menu-icon.clicked .dot:nth-of-type(4),
            .menu-icon.clicked .dot:nth-of-type(5),
            .menu-icon.clicked .dot:nth-of-type(6),
            .menu-icon.clicked .dot:nth-of-type(7),
            .menu-icon.clicked .dot:nth-of-type(8),
            .menu-icon.clicked .dot:nth-of-type(9) {
                display: none;
            }
        }

        /* Desktop menu styles */
        .navbar-expand-lg {
            z-index: 99;
            background: white;
            padding: 0;
        }

        .navbar-collapse {
            width: 100vw;
            background: rgba(0, 0, 0, 0.95);
            position: fixed;
            z-index: 9999;
            display: block;
            visibility: hidden;
            opacity: 0;
            top: 0;
            left: 0;
            height: 100vh;
            transition: all 0.4s;
        }

        .navbar-collapse.show {
            opacity: 1 !important;
            visibility: visible !important;
            z-index: 9999 !important;
            display: block !important;
        }

        .navbar-collapse ul.menu_link {
            position: absolute;
            top: 100px;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            list-style: none;
            padding: 0;
            margin: 0;
            /* gap: auto; */
        }

        .navbar-collapse ul.menu_link li {
            opacity: 0;
            transition: opacity 0.4s cubic-bezier(0.58, 0.3, 0.005, 1);
            padding: 0 10px;
            margin-bottom: 0;
            position: relative;
        }

        .navbar-collapse.menu-shown {
            min-height: 100vh;
            visibility: visible;
            opacity: 1;
            z-index: 9999;
        }

        .navbar-collapse.menu-shown ul.menu_link li,
        .navbar-collapse.show ul.menu_link li {
            opacity: 1;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(1) {
            transition-delay: 0.06s;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(2) {
            transition-delay: 0.12s;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(3) {
            transition-delay: 0.18s;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(4) {
            transition-delay: 0.24s;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(5) {
            transition-delay: 0.3s;
        }

        .navbar-collapse.menu-shown ul.menu_link li:nth-child(6) {
            transition-delay: 0.36s;
        }

        .navbar-toggler {
            padding: 0;
        }

        /* Animated Dot Menu Icon */
        .menu-icon {
            position: relative;
            width: 30px;
            height: 30px;
            cursor: pointer;
        }

        .menu-icon .dot {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 6px;
            height: 6px;
            background-color: #dc3545;
            border-radius: 6px;
            transform: translate(-50%, -50%);
            transition: margin 0.4s ease 0.4s, width 0.4s ease;
        }

        .menu-icon .dot:nth-of-type(1) {
            margin-top: -12px;
            margin-left: -12px;
            transform: translate(-50%, -50%) rotate(45deg);
        }

        .menu-icon .dot:nth-of-type(2) {
            margin-top: -12px;
            transform: translate(-50%, -50%) rotate(-45deg);
        }

        .menu-icon .dot:nth-of-type(3) {
            margin-top: -12px;
            margin-left: 12px;
        }

        .menu-icon .dot:nth-of-type(4) {
            margin-left: -12px;
        }

        .menu-icon .dot:nth-of-type(5) {
            /* Center dot - no margin needed */
        }

        .menu-icon .dot:nth-of-type(6) {
            margin-left: 12px;
        }

        .menu-icon .dot:nth-of-type(7) {
            margin-top: 12px;
            margin-left: -12px;
        }

        .menu-icon .dot:nth-of-type(8) {
            margin-top: 12px;
        }

        .menu-icon .dot:nth-of-type(9) {
            margin-top: 12px;
            margin-left: 12px;
        }

        .menu-icon.clicked .dot {
            transition: margin 0.4s ease, width 0.4s ease 0.4s;
            margin-left: 0;
            margin-top: 0;
        }

        .menu-icon.clicked .dot:nth-of-type(1) {
            width: 30px;
        }

        .menu-icon.clicked .dot:nth-of-type(2) {
            width: 30px;
        }

        .menu-icon.clicked .dot:nth-of-type(3),
        .menu-icon.clicked .dot:nth-of-type(4),
        .menu-icon.clicked .dot:nth-of-type(5),
        .menu-icon.clicked .dot:nth-of-type(6),
        .menu-icon.clicked .dot:nth-of-type(7),
        .menu-icon.clicked .dot:nth-of-type(8),
        .menu-icon.clicked .dot:nth-of-type(9) {
            display: none;
        }

        /* --- DROPDOWN STYLES --- */
        .navbar-collapse ul.menu_link .dropdown-menu {
            display: none !important;
            position: absolute;
            left: 0;
            top: 100%;
            background: rgba(0, 0, 0, 0.95);
            flex-direction: row;
            gap: 10px;
            min-width: unset;
            box-shadow: none;
            border: none;
            padding: 10px 0;
        }

        .navbar-collapse ul.menu_link .dropdown-menu .dropdown-item {
            color: white;
            font-size: 24px;
            background: none;
            padding: 0 12px;
        }

        .navbar-collapse ul.menu_link .dropdown-menu .dropdown-item:hover {
            text-decoration: underline;
        }

        .navbar-collapse ul.menu_link .company_dropdown_main.show .dropdown-menu {
            display: flex !important;
        }
    </style>
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

<body class="<?php echo $body_class; ?> <?php echo $this->session->data['lang']; ?>" dir="<?php if ($this->session->data['lang'] == 'ar') {
                                                                                                echo "rtl";
                                                                                            } else {
                                                                                                echo "ltr";
                                                                                            } ?>">
    <nav class="navbar navbar-expand-lg" id="header" style="background: black;">
        <div class="container">
            <div class="header_site_logo">
                <?php if (!empty($hlogo)) : ?>
                    <a href="<?php echo HTTPS_HOST; ?>">
                        <img src="<?php echo $hlogo; ?>" alt="Logo" class="img-responsive" />
                    </a>
                <?php endif; ?>
            </div>
            <!-- Menu Toggle Button -->
            <div class="desktop_new_header">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="font-size: 1rem; align-items: center; background: none; border: none;">
                    <span class="text-danger me-2">Menu</span>
                    <div class="menu-icon">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </button>
            </div>
            <div class="mobile_new_header">
                <div class="mobile_header">
                    <div class="language_Changer mobile_language_Changer_Show">
                        <?php if ($this->session->data['lang'] == 'en') { ?>
                            <a href="<?php echo $lang_url; ?>">العربية</a>
                        <?php } else { ?>
                            <a href="<?php echo $lang_url; ?>">English</a>
                        <?php } ?>
                    </div>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" style="font-size: 1rem; align-items: center; background: none; border: none;">
                        <span class="text-danger me-2">Menu</span>
                        <div class="menu-icon">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                        </div>
                    </button>
                </div>

                <div class="mobile_social_item">
                    <div class="head_social_items">
                        <ul class="list-inline">
                            <?php if (!empty($config_facebook)) : ?>
                                <li>
                                    <a href="<?php echo $config_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook Logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_instagram)) : ?>
                                <li>
                                    <a href="<?php echo $config_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="Instagram Logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_twitter)) : ?>
                                <li>
                                    <a href="<?php echo $config_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="Twitter logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_youtube)) : ?>
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
                        <ul class="menu_link ">
                            <?php foreach ($headerMenus as $hmenu) : ?>
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
                <div class="header_social_links text-center text-md-right mobile_hide_menu  me-lg-5 me-md-auto">
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
                            <?php if (!empty($config_facebook)) : ?>
                                <li>
                                    <a href="<?php echo $config_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook Logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_instagram)) : ?>
                                <li>
                                    <a href="<?php echo $config_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="Instagram Logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_twitter)) : ?>
                                <li>
                                    <a href="<?php echo $config_twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="Twitter logo" /></a>
                                </li>
                            <?php endif; ?>
                            <?php if (!empty($config_youtube)) : ?>
                                <li>
                                    <a href="<?php echo $config_youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="Youtube Logo" /></a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="language_Changer mobile_language_Changer">
                        <?php if ($this->session->data['lang'] == 'en') { ?>
                            <a href="<?php echo $lang_url; ?>">العربية</a>
                        <?php } else { ?>
                            <a href="<?php echo $lang_url; ?>" style="text-transform: none;">English</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ToggleBtn = document.querySelector('.navbar-toggler');
            // var mobileToggleBtn = document.querySelector('.navbar-toggler:not(.navbar-toggler)');
            var Menus = document.getElementById('navbarSupportedContent');
            var menuIcon = document.querySelector('.menu-icon');

            function setMenuState() {
                Menus.classList.add('navbar-toggler');
                Menus.classList.remove('menu-shown');
                if (ToggleBtn) {
                    ToggleBtn.setAttribute('aria-expanded', 'false');
                }
                if (menuIcon) {
                    menuIcon.classList.remove('clicked');
                }
            }
            setMenuState();
            window.addEventListener('resize', setMenuState);
            if (ToggleBtn && Menus) {
                ToggleBtn.addEventListener('click', function() {
                    var isExpanded = this.getAttribute('aria-expanded') === 'true';
                    if (!isExpanded) {
                        Menus.classList.remove('navbar-toggler');
                        Menus.classList.add('menu-shown');
                        this.setAttribute('aria-expanded', 'true');
                        if (menuIcon) {
                            menuIcon.classList.add('clicked');
                        }
                    } else {
                        Menus.classList.remove('menu-shown');
                        Menus.classList.add('navbar-toggler');
                        this.setAttribute('aria-expanded', 'false');
                        if (menuIcon) {
                            menuIcon.classList.remove('clicked');
                        }
                    }
                });
            }
            if (ToggleBtn && Menus) {
                ToggleBtn.addEventListener('click', function() {
                    Menus.classList.toggle('show');
                });
            }
        });
    </script>