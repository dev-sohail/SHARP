<?php echo $header; ?>

<?php if (!empty($category)) { ?>
    <section class="innerpages_banner"
        style="background: url('<?php echo $category['image'] ?? ''; ?>') !important; background-size: cover !important; background-repeat: no-repeat !important; background-position: center !important;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="inner_banner_content">
                        <h1><?php echo $category['title'] ?? ''; ?></h1>
                        <p><?php echo $category['meta_description'] ?? ''; ?></p>
                    </div>
                    <div class="innerpages_breadcrum">
                        <ul class="breadcrumb">
                            <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
                            <li><?php echo $category['title'] ?? ''; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>

<section class="careers custom_padding" style="position:relative;overflow: hidden;">
    <div class="container">
        <h2>Subcategories</h2>
        <div class="row">
            <?php if (!empty($has_subcategories) && !empty($subcategories)) { ?>
                <?php foreach ($subcategories as $subcategory) { ?>
                    <div class="card m-2" style="width: 18rem;">
                        <img src="<?= htmlspecialchars($subcategory['image']); ?>" alt="<?= htmlspecialchars($subcategory['title'] ?? $subcategory['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($subcategory['title'] ?? $subcategory['name']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($subcategory['description'] ?? ''); ?></p>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No subcategory exists.</p>
            <?php } ?>
        </div>
    </div>
    <div class="image-container about_image_container">
        <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/food_wheel.svg">
    </div>
</section>

<?php echo $footer; ?>