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
        <h2>Parent Categories</h2>
        <div class="row">
            <?php if (!empty($categories)) { ?>
                <?php foreach ($categories as $category) { ?>
                    <div class="card m-2" style="width: 18rem;">
                        <img class="p-2" src="<?php echo BASE_URL; ?>uploads\image\categories/<?= $category['image']; ?>" alt="<?= htmlspecialchars($category['title']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($category['title']); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($category['description']); ?></p>
                            <a href="categories/category_id=<?= $category['category_id']; ?>" class="btn btn-primary mt-3">Go to</a>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p>No categories found.</p>
            <?php } ?>
        </div>
    </div>
    <div class="image-container about_image_container">
        <img class="spin_image" src="<?php echo BASE_URL; ?>themes/food/assets/Images/food_wheel.svg">
    </div>
</section>

<?php echo $footer; ?>