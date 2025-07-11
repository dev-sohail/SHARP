<?php echo $header; ?>
<style>
    /* Input field styling */
    .multi-select {
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 14px;
        width: 100%;
        /* Ensures it takes the full width of the parent column */
    }
    /* Dropdown menu styling */
    .dropdown-menu {
        width: 100%;
        /* Aligns with the width of the input field */
        border: 1px solid #ced4da;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .dropdown-menu li a {
        padding: 8px 12px;
        display: block;
    }
    .dropdown-menu li a:hover {
        background-color: #f8f9fa;
    }
    /* Scrollable area styling */
    .multi-select-well {
        border: 1px solid #ced4da;
        background-color: #f8f9fa;
        padding: 8px;
        overflow-y: auto;
        width: 100%;
        /* Matches the width of the column */
    }
    /* Responsive adjustments for smaller devices */
    @media (max-width: 768px) {
        .multi-select,
        .dropdown-menu,
        .multi-select-well {
            font-size: 16px;
        }
    }
    .table-responsive .input-group {
        height: auto;
    }
</style>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
        <?php if (!$viewer) { ?>
            <button type="submit" form="form-customer" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
           <?php } ?>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <?php if ($error_warning) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                        <?php echo $error_warning; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $_SESSION['error_warning'] = null;
                } ?>
                <?php if ($this->session->data['success']) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                        <?php echo $this->session->data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $this->session->data['success'] = null;
                }  ?>
                <?php $css = 'style="border-color: red;"'; ?>
                <?php $css1 = 'style="outline: 1px solid rgb(255 0 0 / 100%);"'; ?>
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $lang) { ?>
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" />
                                            <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="brands_description[<?php echo $lang['language_id'] ?>][name]" value="<?php echo isset($brands_description[$lang['language_id']]) ? $brands_description[$lang['language_id']]['name'] : ''; ?>" placeholder="Title" id="input-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_name[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_name[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                         <!-- <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-brands_description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="brands_description[<?php echo $lang['language_id'] ?>][full_description]" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"> <?php echo isset($brands_description[$lang['language_id']]) ? $brands_description[$lang['language_id']]['full_description'] : ''; ?></textarea>
                                                <?php if (isset($error_f_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_f_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div> -->
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="brands_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($brands_description[$lang['language_id']]) ? $brands_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="brands_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($brands_description[$lang['language_id']]) ? $brands_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <textarea rows="5" name="brands_description[<?php echo $lang['language_id'] ?>][meta_description]" placeholder="Meta Description" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($brands_description[$lang['language_id']]) ? $brands_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <div class="tab-pane" id="tab-data">
                    <div class="col-lg-6 col-md-6" style="display: none;">
                                <div class="form-group">
                                    <label class="control-label" for="input-seo_url">
                                        Seo Url
                                    </label>
                                    <input type="text" name="seo_url" value="<?php echo $seo_url; ?>"
                                        class="form-control" />
                                    <?php if (isset($error_seo_url)) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_seo_url; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-location-id">
                                     Location
                                    </label>
                                    <?php
                                    // Ensure $location_id is set to an empty value if it's not already defined
                                    $location_id = $location_id ?? "";
                                    ?>
                                    <select name="location_id" id="input-location-id" class="form-control">
                                        <option value="" <?php echo $location_id === "" ? "selected" : ""; ?>>Choose Location</option>
                                        <?php 
                                        foreach ($brands_location as $location) { ?>
                                            <option value="<?php echo $location['location_id']; ?>"
                                                <?php echo ($location['location_id'] == $location_id) ? "selected" : ""; ?>>
                                                <?php echo $location['location_name']; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                    <?php if ($error_location_id) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_location_id; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>

                    <!-- <div class="col-lg-6 col-md-6">
                        <div class="form-group required">
                            <label class="control-label" for="input-opening-hours">
                                Opening Hours
                            </label>
                            <div class="row">
                            <div class="col-md-6">
                                <select id="opening_time" name="opening_time" class="form-control me-2">
                                    <option value="" disabled <?php echo empty($opening_time) ? 'selected' : ''; ?>>Select Opening Time</option>
                                    <?php
                                    // Generate time options from 12:00 AM to 11:30 PM
                                    for ($i = 0; $i < 24; $i++) {
                                        for ($j = 0; $j < 2; $j++) {
                                            $time = date("h:i A", strtotime($i . ":" . ($j * 30)));
                                            $selected = (isset($opening_time) && $opening_time == $time) ? 'selected' : '';
                                            echo "<option value='$time' $selected>$time</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <?php if (isset($error_opening_time)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_opening_time; ?>
                                    </div>
                                <?php } ?>
                                </div>
                                <div class="col-md-6">
                                <select id="closing_time" name="closing_time" class="form-control">
                                    <option value="" disabled <?php echo empty($closing_time) ? 'selected' : ''; ?>>Select Closing Time</option>
                                    <?php
                                    // Generate time options from 12:00 AM to 11:30 PM
                                    for ($i = 0; $i < 24; $i++) {
                                        for ($j = 0; $j < 2; $j++) {
                                            $time = date("h:i A", strtotime($i . ":" . ($j * 30)));
                                            $selected = (isset($closing_time) && $closing_time == $time) ? 'selected' : '';
                                            echo "<option value='$time' $selected>$time</option>";
                                        }
                                    }
                                    ?>
                                </select>
                                <?php if (isset($error_closing_time)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_closing_time; ?>
                                    </div>
                                <?php } ?>
                                </div>
                            </div>
                            <div id="time_error" class="text-danger mt-2" style="display: none;">
                                Opening time must be less than closing time.
                            </div>
                        </div>
                    </div> -->
                        <!-- <div class="col-lg-6 col-md-6">
                            <div class="form-group required">
                                <label class="control-label" for="input-youtube-url">
                                Youtube Url
                                </label>
                                <input type="text" name="youtube_url" placeholder="https://www.youtube.com/" value="<?php echo isset($youtube_url) ? $youtube_url : ''; ?>" class="form-control" />
                            </div>
                            <?php if (isset($error_youtube_url)) { ?>
                                <div class="text-danger">
                                    <?php echo $error_youtube_url; ?>
                                </div>
                            <?php } ?>
                        </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-facebook-url">
                                        Facebook URL
                                    </label>
                                    <input type="text" name="facebook_url" placeholder="https://www.facebook.com/" value="<?php echo $facebook_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_facebook_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_facebook_url; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-instagram-url">
                                     Instagram URL
                                    </label>
                                    <input type="text" name="instagram_url" placeholder="https://www.instagram.com/" value="<?php echo $instagram_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_instagram_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_instagram_url; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-x-url">
                                     Twitter URL
                                    </label>
                                    <input type="text" name="x_url" placeholder="https://twitter.com/" value="<?php echo $x_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_x_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_x_url; ?>
                                    </div>
                                <?php } ?>
                            </div> -->
                                <!-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-image">Image</label>
                                        <input onchange="load4File(event)" type="file" name="image" id="image" accept=".png,.jpg,.jpeg,.svg" style="display: block;">
                                    </div>
                                    <?php if ($error_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_image; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($image) { ?>
                                        <img id="pimage" src="../uploads/image/brands/<?= $image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="pimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='image' value="<?= $image ?>">
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-image">Logo (62 × 62px)</label>
                                        <input onchange="load2File(event)" type="file" name="icon" id="icon" accept=".png,.jpg,.jpeg,.svg" style="display: block;">
                                    </div>
                                    <?php if ($error_icon) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_icon; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($icon) { ?>
                                        <img id="cimage" src="../uploads/image/brands/<?= $icon ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='icon' value="<?= $icon ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-thumbnail">Thumb image (543 × 540px)</label>
                                        <input onchange="load3File(event)" type="file" name="thumbnail" id="thumbnail" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_thumbnail) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_thumbnail; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($thumbnail) { ?>
                                        <img id="cthumbnail" src="../uploads/image/brands/<?= $thumbnail ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cthumbnail" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='thumbnail' value="<?= $thumbnail ?>">
                                </div>
                            </div>
                            <!-- </br>
                            </br>
                            </br> -->
                            <div class="row" style="display: none;">
                                <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left required">Gallery Images (790 × 595px)</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (!empty($brand_images)) : ?>
                                            <?php $image_row = 0; ?>
                                            <?php foreach ($brand_images as $brand_image) : ?>
                                                <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="<?php echo $brand_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="brand_images[<?php echo $image_row; ?>][image]" value="<?php echo $brand_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                        <?php if ($error_brand_images[$image_row]['image']) : ?>
                                                            <div class="text-danger"><?php echo $error_brand_images[$image_row]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="brand_images[<?php echo $image_row; ?>][sort_order]" value="<?php echo $brand_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $image_row = $image_row + 1; ?>
                                                <?php endforeach; ?>
                                           <?php else : ?>
                                        <!-- Default Row -->
                                        <?php $image_row = 0; ?>
                                        <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="brand_images[<?php echo $image_row; ?>][image]" value="<?php echo $brand_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                        <?php if ($error_brand_images[$image_row]['image']) : ?>
                                                            <div class="text-danger"><?php echo $error_brand_images[$image_row]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="brand_images[<?php echo $image_row; ?>][sort_order]" value="<?php echo $brand_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2"></td>
                                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <?php if ($error_gallery_images_main) : ?>
                                        <div class="text-danger"><?php echo $error_gallery_images_main; ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <!-- </br>
                            </br>
                            </br> -->
                            <div class="row" style="display: none;">
    <div class="table-responsive">
        <table id="menu-images" class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <td class="text-left required">Image (352 × 519px)</td>
                    <td class="text-left required">PDF</td>
                    <td class="text-center required">Title</td>
                    <td class="text-right">Sort Order</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ourmenu_images)) : ?>
                    <?php $menu_image_row = 0; ?>
                    <?php foreach ($ourmenu_images as $ourmenu_image) : ?>
                        <tr id="menu-image-row<?php echo $menu_image_row; ?>">
                            <td class="text-left">
                                <a href="" id="menu-thumb-image<?php echo $menu_image_row; ?>" class="menu-image-picker">
                                    <img src="<?php echo $ourmenu_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                </a>
                                <input type="hidden" name="ourmenu_images[<?php echo $menu_image_row; ?>][image]" value="<?php echo $ourmenu_image['image']; ?>" id="menu-input-image<?php echo $menu_image_row; ?>" />
                                <?php if ($error_ourmenu_images[$menu_image_row]['image']) : ?>
                                    <div class="text-danger"><?php echo $error_ourmenu_images[$menu_image_row]['image']; ?></div>
                                <?php endif; ?>
                            </td>
                            <td class="text-left">
                                <input type="file" name="ourmenu_images[<?php echo $menu_image_row; ?>][pdf]" accept="application/pdf" class="form-control" />
                                <input type="hidden" name="ourmenu_images[<?php echo $menu_image_row; ?>][pdf]" value="<?php echo $ourmenu_image['pdf']; ?>" id="menu-input-pdf<?php echo $menu_image_row; ?>" />
                                
                                <?php if ($error_ourmenu_images[$menu_image_row]['pdf']) : ?>
                                    <div class="text-danger"><?php echo $error_ourmenu_images[$menu_image_row]['pdf']; ?></div>
                                <?php endif; ?>

                                <?php if (!empty($ourmenu_image['pdf'])) : ?>
                                    <p class="mt-2">
                                        <strong>Uploaded PDF:</strong> 
                                        <a href="<?php echo $ourmenu_image['pdf_url']; ?>" target="_blank">
                                            <?php echo basename($ourmenu_image['pdf']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="text-left">
                                <?php foreach ($languages as $language) : ?>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                        </span>
                                        <input type="text" name="ourmenu_images[<?php echo $menu_image_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($ourmenu_image['description'][$language['language_id']]['title']) ? $ourmenu_image['description'][$language['language_id']]['title'] : ''; ?>" />
                                    </div>
                                    <?php if ($error_ourmenu_images[$menu_image_row]['title'][$language['language_id']]) : ?>
                                        <div class="text-danger"><?php echo $error_ourmenu_images[$menu_image_row]['title'][$language['language_id']]; ?></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                            <td class="text-right">
                                <input type="text" name="ourmenu_images[<?php echo $menu_image_row; ?>][sort_order]" value="<?php echo $ourmenu_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                            </td>
                            <td class="text-left">
                                <button type="button" onclick="$('#menu-image-row<?php echo $menu_image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                    <i class="fa fa-minus-circle"></i>
                                </button>
                            </td>
                        </tr>
                        <?php $menu_image_row++; ?>
                    <?php endforeach; ?>
                <?php else : ?>
                    <?php $menu_image_row = 0; ?>
                    <tr id="menu-image-row<?php echo $menu_image_row; ?>">
                        <td class="text-left">
                            <a href="" id="menu-thumb-image<?php echo $menu_image_row; ?>" class="menu-image-picker">
                                <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                            </a>
                            <input type="hidden" name="ourmenu_images[<?php echo $menu_image_row; ?>][image]" value="" id="menu-input-image<?php echo $menu_image_row; ?>" />
                        </td>
                        <!-- <td class="text-left">
                            <input type="file" name="ourmenu_images[<?php echo $menu_image_row; ?>][pdf]" value="" accept="application/pdf" class="form-control" />
                        </td> -->

                        <td class="text-left">
                                <input type="file" name="ourmenu_images[<?php echo $menu_image_row; ?>][pdf]" accept="application/pdf" class="form-control" />
                                <!-- <input type="hidden" name="ourmenu_images[<?php echo $menu_image_row; ?>][pdf]" value="<?php echo $ourmenu_image['pdf']; ?>" id="menu-input-pdf<?php echo $menu_image_row; ?>" /> -->
                                
                                <?php if (!empty($ourmenu_image['pdf'])) : ?>
                                    <p class="mt-2">
                                        <strong>Uploaded PDF:</strong> 
                                        <a href="<?php echo $ourmenu_image['pdf_url']; ?>" target="_blank">
                                            <?php echo basename($ourmenu_image['pdf']); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </td>



                        <td class="text-left">
                            <?php foreach ($languages as $language) : ?>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                    </span>
                                    <input type="text" name="ourmenu_images[<?php echo $menu_image_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="" />
                                </div>
                            <?php endforeach; ?>
                        </td>
                        <td class="text-right">
                            <input type="text" name="ourmenu_images[<?php echo $menu_image_row; ?>][sort_order]" value="" placeholder="Sort Order" class="form-control" />
                        </td>
                        <td class="text-left">
                            <button type="button" onclick="$('#menu-image-row<?php echo $menu_image_row; ?>').remove();" data-toggle="tooltip" title="Remove" class="btn btn-danger">
                                <i class="fa fa-minus-circle"></i>
                            </button>
                        </td>
                    </tr>
                <?php endif; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="text-left">
                                <button type="button" onclick="addMenuImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i> </button>
                            </td>
                            </tr>
                        </tfoot>
                        </table>
                        <?php if ($error_ourmenu_images_main) : ?>
                            <div class="text-danger"><?php echo $error_ourmenu_images_main; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                            </br>
                            </br>
                            </br>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" class="form-control" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-status">
                                        Status
                                    </label>
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ($status) { ?>
                                            <option value="1" selected="selected">Active</option>
                                            <option value="0">Inactive</option>
                                        <?php } else { ?>
                                            <option value="1">Active</option>
                                            <option value="0" selected="selected">Inactive</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                        <?php if (!$viewer) { ?>
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                           <?php } ?>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<script type="text/javascript">
    var image_row = <?php echo (!empty($brand_images)) ? count($brand_images) : 1; ?>;
    function addImage() {
        var html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-image' + image_row + '" class="image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="brand_images[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="brand_images[' + image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#images tbody').append(html);
        image_row++; // Increment the row counter
    }

    $(document).ready(function() {
        $('body').on('click', '.image-picker', function(e) {
            e.preventDefault();
            var imageRowId = $(this).attr('id');
            var fileInput = $('<input type="file" style="display: none;" accept="image/*">');
            $('body').append(fileInput);
            fileInput.click();
            fileInput.on('change', function() {
                var file = this.files[0];
                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file.');
                        return;
                    }
                    if (file.size > 2097152) {
                        alert('The file is too large. Please select a file smaller than 2 MB.');
                        return;
                    }
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    var fd = new FormData();
                    fd.append('image', file);
                    $.ajax({
                        url: '/admin/?controller=brands/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src', '../uploads/image/brands/' + response['filename']);
                                $('#input-image' + imageRowId.replace('thumb-image', '')).val(response['filename']);
                            }
                        },
                    });
                }
            });
        });
    });
    $('#language a:first').tab('show');
</script>

<script type="text/javascript">
    var menu_image_row = <?php echo (!empty($ourmenu_images)) ? count($ourmenu_images) : 1; ?>;

    function addMenuImage() {
        var html = '<tr id="menu-image-row' + menu_image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="" id="menu-thumb-image' + menu_image_row + '" class="menu-image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="ourmenu_images[' + menu_image_row + '][image]" value="" id="menu-input-image' + menu_image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <input type="file" name="ourmenu_images[' + menu_image_row + '][pdf]" accept="application/pdf" class="form-control menu-pdf-upload" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input type="text" name="ourmenu_images[' + menu_image_row + '][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="" />';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="ourmenu_images[' + menu_image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#menu-image-row' + menu_image_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';

        $('#menu-images tbody').append(html);
        menu_image_row++; // Increment the row counter
    }

    $(document).ready(function() {
        $('body').on('click', '.menu-image-picker', function(e) {
            e.preventDefault();
            var imageRowId = $(this).attr('id');
            var fileInput = $('<input type="file" style="display: none;" accept="image/*">');
            $('body').append(fileInput);
            fileInput.click();
            fileInput.on('change', function() {
                var file = this.files[0];
                if (file) {
                    if (!file.type.match('image.*')) {
                        alert('Please select an image file.');
                        return;
                    }
                    if (file.size > 2097152) {
                        alert('The file is too large. Please select a file smaller than 2 MB.');
                        return;
                    }
                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    var fd = new FormData();
                    fd.append('image', file);
                    $.ajax({
                        url: '/admin/?controller=brands/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src', '../uploads/image/brands/' + response['filename']);
                                $('#menu-input-image' + imageRowId.replace('menu-thumb-image', '')).val(response['filename']);
                            }
                        },
                    });
                }
            });
        });

      
    });
</script>


<script>
    $(document).ready(function() {
    $('body').on('change', 'input[type="file"][accept="application/pdf"]', function(e) {
        var file = this.files[0];
        var inputField = $(this);
        
        if (file) {
            if (file.type !== 'application/pdf') {
                alert('Please select a valid PDF file.');
                return;
            }
            if (file.size > 5242880) { // 5MB size limit
                alert('The file is too large. Please select a file smaller than 5 MB.');
                return;
            }

            var fd = new FormData();
            fd.append('pdf', file);

            $.ajax({
                url: '/admin/?controller=brands/uploadPdf&token=<?php echo $token; ?>',
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response['filename']) {
                        inputField.siblings('input[type="hidden"][name="' + inputField.attr('name') + '"]').remove();
                        // alert('PDF uploaded successfully: ' + response['filename']);
                        inputField.after('<input type="hidden" name="' + inputField.attr('name') + '" value="' + response['filename'] + '">');
                    } else {
                        // alert('PDF upload failed.');
                    }
                }
            });
        }
    });
});

</script>

<script src="/themes/admin/javascript/common.js" type="text/javascript"></script>
<script type="text/javascript">
    <?php foreach ($languages as $lang) { ?>
        var lang = 'input-description<?php echo $lang['language_id'] ?>';
        var code = '<?php echo $lang["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openingTimeSelect = document.getElementById("opening_time");
        const closingTimeSelect = document.getElementById("closing_time");
        const timeErrorDiv = document.getElementById("time_error");
        function validateTime() {
            const openingTime = openingTimeSelect.value;
            const closingTime = closingTimeSelect.value;
            if (openingTime && closingTime) {
                // Convert time to Date objects for comparison
                const openingDate = new Date("1970-01-01T" + convertTo24Hour(openingTime) + ":00");
                const closingDate = new Date("1970-01-01T" + convertTo24Hour(closingTime) + ":00");
                if (openingDate >= closingDate) {
                    timeErrorDiv.style.display = "block";
                    return false;
                } else {
                    timeErrorDiv.style.display = "none";
                }
            }
            return true;
        }
        function convertTo24Hour(time) {
            const [hours, minutesPart] = time.split(":");
            const [minutes, period] = minutesPart.split(" ");
            let hours24 = parseInt(hours, 10);
            if (period === "PM" && hours24 !== 12) {
                hours24 += 12;
            }
            if (period === "AM" && hours24 === 12) {
                hours24 = 0;
            }
            return `${hours24.toString().padStart(2, "0")}:${minutes}`;
        }
        openingTimeSelect.addEventListener("change", validateTime);
        closingTimeSelect.addEventListener("change", validateTime);
        // Optional: Prevent form submission if validation fails
        const form = document.querySelector("form");
        form.addEventListener("submit", function (e) {
            if (!validateTime()) {
                e.preventDefault();
            }
        });
    });
</script>

<script>
    var load2File = function(event) {
        var output = document.getElementById('cimage');
        var file = event.target.files[0];
        // var validExtensions = ['png', 'jpeg', 'svg', 'jpg'];
        var validExtensions = ['png', 'jpeg', 'jpg', 'svg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG, SVG) less than 2 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };

    var load4File = function(event) {
        var output = document.getElementById('pimage');
        var file = event.target.files[0];
        // var validExtensions = ['png', 'jpeg', 'svg', 'jpg'];
        var validExtensions = ['png', 'jpeg', 'jpg', 'svg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG, SVG) less than 2 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };

    var load3File = function(event) {
        var output = document.getElementById('cthumbnail');
        var file = event.target.files[0];
        // var validExtensions = ['png', 'jpeg', 'svg', 'jpg'];
        var validExtensions = ['png', 'jpeg', 'jpg', 'svg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG, SVG) less than 2 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };
</script>