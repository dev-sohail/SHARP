<?php echo $header; ?>
<?php if (!empty($getPages)) : ?>

    <section class="terms_body">
    <section class="brands_details_breadcrumb black_header" id="Terms_conditions">
        <div class="container">
            <ul>
                <li><a href="<?php echo HTTPS_HOST; ?>"><?php echo $heading_title; ?></a></li>
                <li><?php echo  $getPages['name']; ?></li>
            </ul>
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
</section>

<?php endif; ?>
<?php echo $footer; ?>