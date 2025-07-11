<footer>
    <div class="main_footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                <?php if (!empty($logo)) : ?>
                    <div class="footer_logo">
                    <a href="<?php echo HTTPS_HOST; ?>"><img src="<?php echo $logo; ?>" alt="Site Logo"></a>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($config_f_description)) : ?>
                    <div class="footer_para">
                        <p><?php echo $config_f_description; ?></p>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($footerMenus)) : ?>
                <div class="col-lg-3 col-md-4">
                    <div class="footer_main_item">
                        <h3><?php echo $text_quick_links; ?></h3>
                        <div class="footer_links">
                            <ul>
                            <?php foreach ($footerMenus as $menu) { ?>
                                <li><a href="<?php echo HTTPS_HOST . $menu["url"]; ?>"><?php echo $menu["title"]; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($footerLegalsMenus)) : ?>
                <div class="col-lg-3 col-md-4">
                    <div class="footer_main_item">
                        <h3><?php echo $text_legals;?></h3>
                        <div class="footer_links">
                            <ul>
                            <?php foreach ($footerLegalsMenus as $flmenu) { ?>
                                <li><a href="<?php echo HTTPS_HOST . $flmenu["url"]; ?>"><?php echo $flmenu["title"]; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="col-lg-3 col-md-4">
                    <div class="footer_main_item">
                        <h3><?php echo $contact_us;?></h3>
                        <div class="footer_Socail_icon">
                            <ul>
                            <?php if (!empty($config_address_location)) : ?>
                                <li><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/location-pin.svg" alt="Mail "><a href="<?php echo $config_address_location;?>" target="_blank"><?php echo $admin_location;?></a></li>
                            <?php endif; ?>
                            <?php if (!empty($config_email)) : ?>
                                <!-- <li class="email_tesing"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/mail.svg" alt="Mail "><a href="mailto:<?php echo $config_email;?>" target="_blank"><?php echo $config_email; ?></a></li>-->
                            <?php endif; ?>
                            <?php if (!empty($config_telephone)) : ?>
                                <li><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/phone.svg" alt="Phone"><a dir="ltr" href="tel:<?php echo $config_telephone; ?>" target="_blank"><?php echo $config_telephone; ?></a></li>
                            <?php endif; ?>
                            
                            
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copywrite_footer">
        <div class="container">
            <div class="copywrite_footer_main">
                <div class="copywrite_text">
                    <p><?php echo $text_copyrights; ?></p>
                </div>
                <div class="copywrite_Links">
                    <ul>
                      <?php if (!empty($facebook)) :?>
                        <li><a href="<?php echo $facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook"></a></li>
                        <?php endif; ?>
                        <?php if (!empty($instagram)) :?>
                        <li><a href="<?php echo $instagram;?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="insta"></a></li>
                        <?php endif; ?>
                        <?php if (!empty($twitter)) :?>
                        <li><a href="<?php echo $twitter; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="twitter"></a></li>
                        <?php endif; ?>
                        <?php if (!empty($youtube)) :?>
                        <li><a href="<?php echo $youtube; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="youtube"></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer_image-container">
        <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/footer_wheel.svg">
    </div>
</footer>
<?php if (!empty($whatsapp)) : ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
<a href="https://api.whatsapp.com/send?phone=<?php echo $whatsapp; ?>&text=Merhaba" class="float" target="_blank">
<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M26.9354 5.06347C24.3558 2.45467 20.9285 0.854104 17.2723 0.550733C13.616 0.247362 9.97181 1.26118 6.99754 3.40916C4.02327 5.55713 1.91496 8.69771 1.05325 12.2639C0.191539 15.83 0.633217 19.5868 2.29854 22.8558L0.66696 30.7772C0.64949 30.8563 0.648813 30.9382 0.664973 31.0176C0.681133 31.097 0.71377 31.1721 0.760776 31.2381C0.828092 31.338 0.924316 31.415 1.03657 31.4587C1.14883 31.5024 1.27177 31.5109 1.38893 31.4828L9.13893 29.6432C12.399 31.2649 16.1288 31.6771 19.6644 30.8065C23.1999 29.9359 26.3118 27.8391 28.4462 24.8891C30.5806 21.9391 31.599 18.3274 31.3201 14.697C31.0412 11.0665 29.4831 7.65281 26.9231 5.06347H26.9354ZM24.5125 24.3854C22.7284 26.1663 20.4311 27.3433 17.9435 27.7508C15.4559 28.1583 12.9031 27.7759 10.6441 26.6574L9.55906 26.119L4.79893 27.2448V27.1836L5.80235 22.3827L5.27209 21.3385C4.11702 19.0733 3.70918 16.5005 4.1071 13.9891C4.50502 11.4778 5.68823 9.15706 7.48696 7.35992C9.7455 5.10373 12.8073 3.83641 15.9997 3.83641C19.1921 3.83641 22.2539 5.10373 24.5125 7.35992L24.5655 7.43334C26.7947 9.6967 28.0391 12.7493 28.0277 15.9261C28.0162 19.1029 26.7498 22.1464 24.5043 24.3936L24.5125 24.3854Z" fill="white"/>
<path d="M24.0927 20.8947C23.5094 21.8125 22.5835 22.9342 21.4292 23.2156C19.3897 23.7051 16.2856 23.2156 12.3984 19.6221L12.3494 19.5772C8.96798 16.4201 8.07061 13.7892 8.27048 11.7048C8.38877 10.5179 9.37587 9.44918 10.208 8.74761C10.3403 8.63605 10.4968 8.557 10.6651 8.51675C10.8334 8.4765 11.0088 8.47619 11.1773 8.51582C11.3457 8.55546 11.5026 8.63394 11.6353 8.74502C11.768 8.85609 11.8729 8.99666 11.9415 9.1555L13.1938 11.9863C13.2755 12.1685 13.3062 12.3695 13.2825 12.5678C13.2588 12.7661 13.1816 12.9543 13.0592 13.1121L12.4228 13.9279C12.2906 14.0972 12.2118 14.3021 12.1965 14.5165C12.1813 14.7308 12.2303 14.9448 12.3372 15.1312C12.9416 16.022 13.6648 16.8262 14.4868 17.5214C15.3712 18.3725 16.3741 19.0911 17.4644 19.6547C17.6634 19.7349 17.8818 19.7541 18.0917 19.7098C18.3016 19.6655 18.4936 19.5597 18.6432 19.4059L19.3734 18.6635C19.5123 18.5141 19.6899 18.4061 19.8864 18.3514C20.0829 18.2967 20.2908 18.2974 20.4869 18.3535L23.4646 19.206C23.6333 19.254 23.7883 19.3411 23.9172 19.4601C24.046 19.5792 24.145 19.7269 24.2062 19.8913C24.2673 20.0557 24.2889 20.2323 24.2692 20.4066C24.2495 20.5809 24.189 20.7481 24.0927 20.8947Z" fill="white"/>
</svg>

</a>
<?php endif; ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="<?php echo BASE_URL; ?>themes/food/assets/includes/OwlCarousel/dist/owl.carousel.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>themes/food/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="<?php echo BASE_URL; ?>themes/food/assets/js/script.js"></script>
</body>
</html>