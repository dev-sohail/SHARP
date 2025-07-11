<?php echo $header; ?>
<!--==================== Login Start ====================-->
<section class="pt-login register section-padding">
            <div class="container">
                <h1>Register</h1>
                <div class="pt-multi-form">
                    <div class="stepwizard">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step" style="background: rgb(233 246 252 / 50%);padding: 15px 0;">
                                <a href="#step-1" type="button" class="btn btn-primary btn-circle" style="background: #104EE0;"><img src="/themes/nhealth/assets/imgs/tick.svg" style="filter: brightness(0) saturate(100%) invert(100%) sepia(10%) saturate(1%) hue-rotate(77deg) brightness(100%) contrast(100%);"></a>
                                <p>Personal Information</p>
                            </div>
                            <div class="stepwizard-step " style="background: rgb(233 246 252 / 50%);padding: 15px 0;">
                                <a href="#step-2" type="button" class="btn btn-primary btn-circle" style="background: #104EE0;" disabled="disabled"><img src="/themes/nhealth/assets/imgs/tick.svg" style="filter: brightness(0) saturate(100%) invert(100%) sepia(10%) saturate(1%) hue-rotate(77deg) brightness(100%) contrast(100%);"></a>
                                <p>Upload Document</p>
                            </div>
                            <div class="stepwizard-step" style="background: rgb(233 246 252 / 50%);padding: 15px 0;">
                                <a href="#step-3" type="button" class="btn btn-primary btn-circle" style="background: #104EE0;" disabled="disabled"><img src="/themes/nhealth/assets/imgs/tick.svg" style="filter: brightness(0) saturate(100%) invert(100%) sepia(10%) saturate(1%) hue-rotate(77deg) brightness(100%) contrast(100%);"></a>
                                <p>Contract Agreement</p>
                            </div>
                        </div>
                    </div>
                    <form class="form pt-login-form">
                        <div class="row setup-content thank-you">
                            <div class="col-md-12">
                                <div class="account-successful">
                                    <div class="act-content">
                                        <div class="success-logo">
                                            <img src="/themes/nhealth/assets/imgs/success-img.svg">
                                        </div>
                                        <h4>Account created successfully!</h4>
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusm od tempor incidunt.</p>
                                        <div class="pt-btn-simple">
                                            <a href="<?php echo SITE_HOST; ?>">Home</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
<!--==================== Login End ====================-->
<?php echo $footer ?>