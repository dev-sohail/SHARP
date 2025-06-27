<?php echo $header; ?>
<?php if (!empty($homeSlider)) { ?>
    <section class="outter hero-video">
        <section class="video-container">
            <div class="video-overlay"></div>
            <?php foreach ($homeSlider as $slider) {
                $videoId = '';

                if (!empty($slider['video_url']) && $slider['content_type'] == 'video') {
                    preg_match('/(?:https?:\/\/(?:www\.)?youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*\?v=))([^"&?\/\s]{11})/', $slider['video_url'], $matches);
                    if (isset($matches[1])) {
                        $videoId = $matches[1];
                    }
                }
                // Determine dynamic styles for .video_main
                $videoMainStyle = ($slider['content_type'] == 'video' && !empty($videoId))
                    ? 'position:relative; padding-bottom:56.25%; height:0; overflow:hidden; max-width:100%; width:100%;'
                    : 'max-width:100%; width:100%;';
                ?>
                <div class="video_main" style="<?php echo $videoMainStyle; ?>">
                    <?php if ($slider['content_type'] == 'video' && !empty($videoId)) { ?>
                        <iframe id="videoIframe"
                            src="https://www.youtube.com/embed/<?php echo $videoId; ?>?autoplay=1&amp;loop=1&amp;mute=1&amp;controls=0&amp;rel=0&amp;playlist=<?php echo $videoId; ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <?php } elseif ($slider['content_type'] == 'image') { ?>
                        <img src="<?php echo BASE_URL . 'uploads/image/sliders/' . $slider['image']; ?>"
                            alt="<?php echo $slider['title']; ?>" style="width: 100%; height: auto;">
                    <?php } ?>
                </div>

                <div class="callout">
                    <div class="banner-text">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-5">
                                    <h1><?php echo $slider['title']; ?></h1>
                                </div>
                                <div class="col-lg-5">
                                    <div class="banner_short_desc">
                                        <?php
                                        $slider_short_description = str_replace('&nbsp;', ' ', html_entity_decode($slider['short_description'], ENT_QUOTES, 'UTF-8'));
                                        ?>
                                        <h3><?php echo $slider_short_description; ?></h3>
                                    </div>
                                </div>
                                <?php if ($slider['content_type'] == 'video' && !empty($videoId)) { ?>
                                    <div class="col-lg-2">
                                        <div class="banner_Video_btn">
                                            <div class="custom_video_pause_item">
                                                <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/pause.png" alt="">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </section>
<?php } ?>
<?php if (!empty($aboutblock)) { ?>
    <section class="home_about_us custom_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="home_about_us_head">
                        <h3 class="short_heading"><?php echo $text_about; ?></h3>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="home_about_body">
                        <h3><?php echo $aboutblock['title']; ?></h3>
                        <?php echo $aboutblock['content']; ?>
                    </div>
                    <div class="home_about_images_gallery">
                        <div class="row justify-content-between">
                            <?php if (!empty($BlockLeftImage)): ?>
                                <div class="col-md-8">
                                    <div class="home_about_images_gallery1">
                                        <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $BlockLeftImage['image']; ?>"
                                            alt="Gallery Image">
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($BlockRightImage)): ?>
                                <div class="col-md-4">
                                    <div class="home_gallery_about_2">
                                        <div class="home_About_2gallery_img">
                                            <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $BlockRightImage['image']; ?>"
                                                alt="Gallery Image">
                                        </div>
                                        <div class="learn_more_btn">
                                            <a href="<?php echo HTTPS_HOST . 'about-us'; ?>"><?php echo $text_learn_more; ?><img
                                                    src="<?php echo BASE_URL; ?>themes/food/assets/Images/btn_arrow.svg"
                                                    alt="Arrow"></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="image-container">
                    <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/food_wheel.svg">
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<section class="fact_figer">
    <div class="container">
        <div class="row">
            <?php if (!empty($BlockMiddleImage)): ?>
                <div class="col-lg-6">
                    <div class="fact_figer_img">
                        <img src="<?php echo BASE_URL; ?>uploads/image/blockimages/<?php echo $BlockMiddleImage['image']; ?>"
                            alt="Images">
                    </div>
                </div>
            <?php endif; ?>
            <div class="col-lg-6">
                <?php if (!empty($blockfactstats)) { ?>
                    <div class="fact_figer_head">
                        <h4 class="short_heading"><?php echo $blockfactstats['title']; ?></h4>
                        <h3><?php echo $blockfactstats['content']; ?></h3>
                    </div>
                <?php } ?>
                <div class="fact_figer_compnay">
                    <?php if (!empty($block800)) { ?>
                        <div class="fact_figer_compnay_items">
                            <h3 class="counter" data-target="<?php echo $block800['title']; ?>">0</h3>
                            <?php echo $block800['content']; ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($block600)) { ?>
                        <div class="fact_figer_compnay_items">
                            <h3 class="counter" data-target="<?php echo $block600['title']; ?>">0</h3>
                            <?php echo $block600['content']; ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($block10)) { ?>
                        <div class="fact_figer_compnay_items">
                            <h3 class="counter" data-target="<?php echo $block10['title']; ?>">0</h3>
                            <?php echo $block10['content']; ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($block80)) { ?>
                        <div class="fact_figer_compnay_items">
                            <h3 class="counter" data-target="<?php echo $block80['title']; ?>">0</h3>
                            <?php echo $block80['content']; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="location_slider">
    <div id="map" style="width: 100%; height: 939px;"></div>
    <div class="container">
        <div class="location_slider_items">
            <div class="location_slider_item_head">
                <h4 class="short_heading"><?php echo $text_our_brands; ?></h4>
                <h3><?php echo $text_locations; ?></h3>
            </div>
            <div class="swiper mySwiper" id="location_slider_1">
                <div class="swiper-wrapper">
                    <?php
                    $counter = 1;
                    foreach ($brandLocations as $brandLocation):
                        ?>
                        <div class="swiper-slide lbrandsitem" data-id="<?= $brandLocation['location_id']; ?>">
                            <div class="location_item">
                                <div class="location_item_head">
                                    <h3><?= $brandLocation['title']; ?></h3>
                                    <div class="location_items_link">
                                        <a><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/location-pin.svg"
                                                alt="location"><?= $brandLocation['address']; ?></a>
                                        <a href="tel:966 000 700 000"><img
                                                src="<?php echo BASE_URL; ?>themes/food/assets/Images/phone.svg"
                                                alt="phone"><?= $brandLocation['phone']; ?></a>
                                    </div>
                                </div>
                                <div class="location_item_body">
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/location_share.svg" alt="">
                                </div>
                            </div>
                        </div>
                        <?php $counter++;
                    endforeach; ?>
                </div>
            </div>
            <div class="location_custom_btn">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($mediaCenter)) { ?>
    <section class="news_blog custom_padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="new_blog_main_header">
                        <h3 class="short_heading"><?php echo $blocknews['title']; ?></h3>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="new_blog_main_body">
                        <?php echo $blocknews['content']; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="new_blog_main">
            <div class="owl-carousel owl-theme">
                <?php foreach ($mediaCenter as $media) { ?>
                    <div class="news_blog_main_items">
                        <div class="new_blog_img">
                            <img src="<?php echo BASE_URL . 'uploads/image/mediacenter/' . $media['thumbnail']; ?>"
                                alt="Blog Images">
                        </div>
                        <div class="news_blogs_details">
                            <div class="_news_blog_date">
                                <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/calendar.svg" alt="calendar">
                                <span dir="ltr"><?php echo date('d M Y', strtotime($media['publish_date'])); ?></span>
                            </div>
                            <div class="news_blog_heading">
                                <h3><?php echo $media['title']; ?></h3>
                                <p><?php echo $media['short_description']; ?></p>
                            </div>
                            <div class="news_blog_btn">
                                <a href="<?php echo HTTPS_HOST . 'media-center/' . $media['seo_url']; ?>"><?php echo $text_learn_more; ?>
                                    <img src="<?php echo BASE_URL; ?>themes/food/assets/Images/btn_arrow.svg" alt="Arrow"></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="learn_more_btn news_blog_main_btn">
            <a href="<?php echo HTTPS_HOST . 'media-center'; ?>"><?php echo $text_view_all; ?> <img
                    src="<?php echo BASE_URL; ?>themes/food/assets/Images/btn_arrow.svg" alt="Arrow"></a>
        </div>
    </section>
<?php } ?>
<?php if (!empty($instagram_feeds)): ?>
    <section class="insta_feeds custom_padding">
        <div class="container">
            <div class="insta_feeds_head">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="insta_head">
                            <h3 class="short_heading"><?php echo $blockfollowus['title']; ?></h3>
                            <a href="<?php echo $config_instagram_url; ?>"
                                target="_blank"><?php echo $config_instagram_handler_name; ?></a>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="ista_para">
                            <?php echo $blockfollowus['content']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="instagram_feeds">
            <div class="owl-carousel owl-theme">
                <?php foreach ($instagram_feeds as $instagram_feed) { ?>
                    <div class="item">
                        <div class="instagram_feed_items">
                            <img src="<?php echo $instagram_feed['thumbnail_url']; ?>"
                                alt="<?php echo $instagram_feed['username']; ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php echo $footer; ?>
<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_map_key; ?>&callback=initMap"></script>
<script>
    let map;
    let markers = [];
    let currentLocation = {
        lat: 24.7136,
        lng: 46.6753
    }; // Default location

    function initMap() {
        map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            zoomControl: false,
            fullscreenControl: false,
            center: currentLocation,
            styles: [{
                "featureType": "all",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "saturation": 36
                },
                {
                    "color": "#333333"
                },
                {
                    "lightness": 40
                }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "visibility": "on"
                },
                {
                    "color": "#ffffff"
                },
                {
                    "lightness": 16
                }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#fefefe"
                },
                {
                    "lightness": 20
                }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#fefefe"
                },
                {
                    "lightness": 17
                },
                {
                    "weight": 1.2
                }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                },
                {
                    "lightness": 20
                }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                },
                {
                    "lightness": 21
                }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dedede"
                },
                {
                    "lightness": 21
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#d3d3d3"
                },
                {
                    "lightness": 17
                }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#d3d3d3"
                },
                {
                    "lightness": 29
                },
                {
                    "weight": 0.2
                }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#d3d3d3"
                },
                {
                    "lightness": 18
                }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#d3d3d3"
                },
                {
                    "lightness": 16
                }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f2f2f2"
                },
                {
                    "lightness": 19
                }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e9e9e9"
                },
                {
                    "lightness": 17
                }
                ]
            }
            ]
        });

        // Load the first brand location if available
        <?php if (!empty($brandLocations)) { ?>
            const firstMall = <?= json_encode($brandLocations[0] ?? null) ?>;
            if (firstMall && firstMall.latitude && firstMall.longitude) {
                updateMap(parseFloat(firstMall.latitude), parseFloat(firstMall.longitude), firstMall.name);
            }
        <?php } ?>

        // Handle window resize event
        window.addEventListener("resize", adjustMapCenter);
    }
    // Function to update map location and markers with responsive positioning
    function updateMap(lat, lng, title) {
        clearMarkers();
        currentLocation = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
        adjustMapCenter();
        map.setZoom(8);
        addMarker(currentLocation, title);
    }

    function adjustMapCenter() {
        if (!map || !currentLocation) return;

        const projection = map.getProjection();
        if (!projection) return;

        const worldPoint = projection.fromLatLngToPoint(currentLocation);
        let newCenterPoint;

        // Check if RTL (Right-to-Left) layout is applied
        var isRTL = $("body").hasClass("ar") && $("body").attr("dir") === "rtl";

        if (window.innerWidth < 991) {
            // Small screens: Shift marker to top-center (same for RTL and LTR)
            newCenterPoint = new google.maps.Point(worldPoint.x, worldPoint.y + 0.15);
        } else {
            if (isRTL) {
                // For RTL layout, shift the marker to the right-center
                newCenterPoint = new google.maps.Point(worldPoint.x - 1.99, worldPoint.y);
            } else {
                // For LTR layout, shift the marker to the left-center
                newCenterPoint = new google.maps.Point(worldPoint.x + 1.99, worldPoint.y);
            }
        }

        const newCenter = projection.fromPointToLatLng(newCenterPoint);
        map.setCenter(newCenter);
    }

    // Function to add a marker
    function addMarker(position, title) {
        const svgIcon = {
            url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
            <svg width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="19" cy="19" r="19" fill="#6D863A"/>
                <path d="M18.5 10C14.3643 10 11 13.4218 11 17.6282C11 22.0901 15.026 24.7943 17.69 26.5841L18.1434 26.8902C18.2514 26.9634 18.3757 27 18.5 27C18.6243 27 18.7486 26.9634 18.8566 26.8902L19.31 26.5841C21.974 24.7943 26 22.0901 26 17.6282C26 13.4218 22.6357 10 18.5 10ZM18.602 25.4927L18.5 25.5616L18.398 25.4927C15.818 23.7595 12.2857 21.3865 12.2857 17.6282C12.2857 14.1428 15.0731 11.3077 18.5 11.3077C21.9269 11.3077 24.7143 14.1428 24.7143 17.6282C24.7143 21.3865 21.1811 23.7604 18.602 25.4927ZM18.5 14.7949C16.964 14.7949 15.7143 16.0659 15.7143 17.6282C15.7143 19.1905 16.964 20.4615 18.5 20.4615C20.036 20.4615 21.2857 19.1905 21.2857 17.6282C21.2857 16.0659 20.036 14.7949 18.5 14.7949ZM18.5 19.1538C17.6729 19.1538 17 18.4695 17 17.6282C17 16.7869 17.6729 16.1026 18.5 16.1026C19.3271 16.1026 20 16.7869 20 17.6282C20 18.4695 19.3271 19.1538 18.5 19.1538Z" fill="white" stroke="white" stroke-width="0.5"/>
            </svg>
        `),
            scaledSize: new google.maps.Size(30, 30),
            anchor: new google.maps.Point(15, 15)
        };

        const marker = new google.maps.Marker({
            position: position,
            map: map,
            title: title,
            icon: svgIcon
        });

        markers.push(marker);
    }

    // Function to clear existing markers
    function clearMarkers() {
        markers.forEach(marker => marker.setMap(null));
        markers = [];
    }

    // Click event for brand items
    $(document).on('click', '.lbrandsitem', function () {
        const brandId = $(this).data('id');
        $.ajax({
            url: '<?php echo HTTPS_HOST; ?>home/getLocationData',
            type: 'GET',
            data: {
                id: brandId
            },
            dataType: 'json',
            success: function (response) {
                if (response.brand) {
                    const brand = response.brand;
                    updateMap(brand.latitude, brand.longitude, brand.title);
                } else {
                    alert(response.error || "An error occurred.");
                }
            },
            error: function () {
                alert("Failed to fetch brand data.");
            },
        });
    });

    $(document).ready(function () {
        window.initMap = initMap;
    });
</script>