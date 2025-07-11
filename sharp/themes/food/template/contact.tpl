<?php echo $header; ?>

<style>
    
/* Added Loader overlay new css */
.loader-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* semi-transparent background */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
}

/* Loader element */
.loader {
    border: 8px solid #f3f3f3; /* Light grey */
    border-top: 8px solid #394d37; /* Updated to the requested color */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 2s linear infinite;
}

/* Keyframes for loader animation */
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
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

<section class="contact_us">
    <div class="container">
        <div class="contact_us_main">
        <?php if ($mapimage) : ?>
            <div class="contact_us_map">
            <!-- <?php echo html_entity_decode($config_map); ?> -->
                <!-- <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d97092.72597747397!2d55.322109379534616!3d25.262846668075728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e5f5d0693260e69%3A0xe695d4007a48eee9!2sDubai%20International%20Airport!5e0!3m2!1sen!2s!4v1736493545388!5m2!1sen!2s"
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe> -->
                <img src="<?php echo $mapimage; ?>" alt="google Map">
            </div>
            <?php endif; ?>
            <div class="contact_form">
                 <?php if($bgetIntouch) : ?>
                <div class="contact_form_head">
                    <h3><?php echo $bgetIntouch['title'];?></h3>
                    <?php echo $bgetIntouch['content']; ?>
                </div>
                <?php endif; ?>
                <div class="contant_form_body">
                    <form method="post" id="contactForm" action="<?php echo $action; ?>">
                        <div class="form-floating">
                            <input type="text" value="<?php echo $first_name;?>" name="first_name" class="form-control" id="first_name" placeholder="<?php echo $text_first_name; ?>">
                            <label for="first_name"><?php echo $text_first_name; ?>*</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" value="<?php echo $last_name; ?>" name="last_name" class="form-control" id="last_name" placeholder="<?php echo $text_last_name; ?>">
                            <label for="last_name"><?php echo $text_last_name; ?>*</label>
                        </div>
                        <div class="form-floating">
                            <input type="phone" value="<?php echo $phone; ?>" name="phone" class="form-control" id="phone" placeholder="<?php echo $entry_phone_contact; ?>" maxlength="15">
                            <label for="phone"><?php echo $entry_phone_contact; ?>*</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" value="<?php echo $email; ?>" name="email" class="form-control" id="email" placeholder="name@example.com">
                            <label for="email"><?php echo $entry_email_address; ?>*</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" name="message" placeholder="<?php echo $entry_leave_a; ?>"
                                id="message"><?php echo $message; ?></textarea>
                            <label for="message"><?php echo $entry_message; ?>*</label>
                        </div>
                        <input type="hidden" name="g-recaptcha-response" value="<?php echo $public_key; ?>" id="g-recaptcha-response"> 
                        <input type="hidden" name="enquiry_from" value="<?php echo $action; ?>">
                        <button type="submit" class="contact_form_btn g-recaptcha git_submit" data-action='submit'><?php echo $text_btn_submit; ?> <svg width="18" height="10"
                                viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.4419 5.03787C17.4039 5.12987 17.349 5.21276 17.28 5.28176L13.28 9.28176C13.134 9.42776 12.942 9.50173 12.75 9.50173C12.558 9.50173 12.366 9.42876 12.22 9.28176C11.927 8.98876 11.927 8.51373 12.22 8.22073L14.9399 5.50076H0.75C0.336 5.50076 0 5.16476 0 4.75076C0 4.33676 0.336 4.00076 0.75 4.00076H14.939L12.219 1.28079C11.926 0.987785 11.926 0.51275 12.219 0.21975C12.512 -0.07325 12.987 -0.07325 13.28 0.21975L17.28 4.21975C17.349 4.28875 17.4039 4.37165 17.4419 4.46365C17.5179 4.64765 17.5179 4.85387 17.4419 5.03787Z" fill="#6D863A" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="contact_us_links">
            <div class="Contact_us_links_main">
                <ul> 
                <?php if ($config_telephone): ?>
                    <li><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/phone.svg" alt="Phone"><a dir="ltr" href="tel:<?php echo $config_telephone; ?>"><?php echo $config_telephone; ?></a></li>
                    <?php endif; ?>
                    <?php if ($config_email): ?>
                    <!-- <li class="email_tesing"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/mail.svg" alt="Mail "><a dir="ltr" href="mailto:<?php echo $config_email; ?>"><?php echo $config_email; ?></a></li>-->
                    <?php endif; ?>
                    <?php if ($config_address): ?>
                    <li><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/location-pin.svg" alt="Mail "><a href="<?php echo $config_address_location; ?>" target="_blank"><?php echo $config_address; ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
            <div class="contact_us_social_icons">
                <h4><?php echo $entry_follow_us; ?></h4>
                <div class="contact_us_socail_icons_main">
                    <ul>
                    <?php if ($config_facebook): ?>
                        <li><a href="<?php echo $config_facebook; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/facebook.svg" alt="Facebook"></a></li>
                        <?php endif; ?>
                        <?php if ($config_instagram): ?>
                        <li><a href="<?php echo $config_instagram; ?>" target="_blank"><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/insta.svg" alt="insta"></a></li>
                        <?php endif; ?>
                        <?php if ($config_twitter): ?>
                        <li><a href="<?php echo $config_twitter; ?>"target="_blank" ><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/twitter.svg" alt="twitter"></a></li>
                        <?php endif; ?>
                        <?php if ($config_youtube): ?>
                        <li><a href="<?php echo $config_youtube; ?>"target="_blank" ><img src="<?php echo BASE_URL; ?>themes/food/assets/Images/youtube.svg" alt="youtube"></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Loader HTML -->
<div id="loader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>
<?php echo $footer; ?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    $(document).on('submit', '#contactForm', function(e) {
        e.preventDefault();
        let valid = true;
        $('.text-danger').remove(); // Clear previous error messages
        $('.alert-success').remove(); // Clear previous success messages

        const first_name = $('#first_name').val().trim();
        const last_name = $('#last_name').val().trim();
        const phone = $('#phone').val().trim();
        const email = $('#email').val().trim();
        const message = $('#message').val().trim();

        // Fetch error messages from the language file
        const fnameError = '<?php echo $err_first_name; ?>';
        const lnameError = '<?php echo $err_last_name; ?>';
        const phoneError = '<?php echo $err_phone; ?>';
        const phoneInvalidError = '<?php echo $err_invalid_phone; ?>';
        const emailError = '<?php echo $err_email; ?>';
        const emailErrorInvalid = '<?php echo $err_invalid_email; ?>';
        const messageError = '<?php echo $err_message; ?>';

        if (first_name === '') {
            valid = false;
            $('#first_name').after('<div class="text-danger">' + fnameError + '</div>');
        }

        if (last_name === '') {
            valid = false;
            $('#last_name').after('<div class="text-danger">' + lnameError + '</div>');
        }

        if (phone === '') {
            valid = false;
            $('#phone').after('<div class="text-danger">' + phoneError + '</div>');
        } else if (!validatePhone(phone)) {
            valid = false;
            $('#phone').after('<div class="text-danger">' + phoneInvalidError + '</div>');
        }

        if (email === '') {
            valid = false;
            $('#email').after('<div class="text-danger">' + emailError + '</div>');
        } else if (!validateEmail(email)) {
            valid = false;
            $('#email').after('<div class="text-danger">' + emailErrorInvalid + '</div>');
        }

        if (message === '') {
            valid = false;
            $('#message').after('<div class="text-danger">' + messageError + '</div>');
        }

        if (valid) {
            $('#loader').show();
            $('.git_submit').prop('disabled', true);
            $.ajax({
                url: '<?php echo HTTPS_HOST; ?>contact/contactUsForm',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $.each(response.error, function(field, errorMsg) {
                            $('#' + field).after('<div class="text-danger">' + errorMsg + '</div>');
                        });
                        $('.git_submit').prop('disabled', false);
                        $('#loader').hide();
                    } else if (response.success) {
                        $('#loader').hide();
                        $('#message').closest('.form-floating').after(
                            '<div class="alert alert-success alert-dismissible fade show mt-2" role="alert">' +
                            response.success +
                            '</div>'
                        );
                        $('#contactForm')[0].reset();
                        setTimeout(function() {
                            $('.alert-success').fadeOut(500, function() {
                                $(this).remove();
                                $('.git_submit').prop('disabled', false);
                            });
                        }, 15000);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loader').hide();
                    Swal.fire({
                        icon: 'error',
                        title: 'Submission Error',
                        text: 'There was an error submitting your message. Please try again later.',
                        showConfirmButton: true
                    });
                }
            });
        }
    });

    function validateEmail(email) {
        var re = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        return re.test(email);
    }

    function validatePhone(phone) {
        var re = /^\+?[0-9]{7,15}$/;
        return re.test(phone);
    }
});

</script>