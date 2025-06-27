<?php echo $header; ?>
<style>
.responsive-table {
    overflow-x: auto;
}
</style>
<?php if (!empty($getPages)) : ?>

<section class="innerpages_banner"
    style="background: url('<?php echo $getPages['banner_image']; ?>') !important; background-size: cover !important; background-repeat: no-repeat !important; background-position: center !important;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="inner_banner_content">
                    <h1><?php echo $getPages['name']; ?></h1>
                    <p><?php echo $getPages['short_description']; ?></p>
                </div>
                <div class="innerpages_breadcrum">
                    <ul class="breadcrumb">
                        <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
                        <li><?php echo $getPages['name']; ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="terms_condition_main">
        <div class="container">
            <div class="terms_conditon_body">
                <h1><?php echo  $getPages['name']; ?></h1>
                <?php echo  $getPages['description']; ?>
            </div>
        </div>
    </section>

<?php endif; ?>
<?php echo $footer; ?>
<script>
$(document).ready(function () {
	$("#custom-general-template table").each(function () {
		if (!$(this).parent().hasClass('responsive-table')) {
			$(this).wrap('<div class="responsive-table"></div>');
		}
	});
});
</script>