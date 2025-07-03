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
                                                <input type="text" name="business_description[<?php echo $lang['language_id'] ?>][name]" value="<?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['name'] : ''; ?>" placeholder="Title" id="input-name<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_name[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_name[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-short_description<?php echo $lang['language_id'] ?>">
                                                    Short Description
                                                </label>
                                                <textarea name="business_description[<?php echo $lang['language_id'] ?>][short_description]" rows="5" placeholder="Short Description" id="input-short_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['short_description'] : ''; ?></textarea>
                                                <?php if (isset($error_s_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_s_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                         <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-business_description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="business_description[<?php echo $lang['language_id'] ?>][full_description]" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"> <?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['full_description'] : ''; ?></textarea>
                                                <?php if (isset($error_f_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_f_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-name<?php echo $lang['language_id'] ?>">
                                                    Other Details Title
                                                </label>
                                                <input type="text" name="business_description[<?php echo $lang['language_id'] ?>][other_d_title]" value="<?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['other_d_title'] : ''; ?>" placeholder="Other Details Title" id="input-other-d-title<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_other_d_title[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_other_d_title[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-other-d-description<?php echo $lang['language_id'] ?>">
                                                Other Details Description
                                                </label>
                                                <textarea rows="5" name="business_description[<?php echo $lang['language_id'] ?>][other_d_description]" placeholder="Other Details Description" id="input-other-d-description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['other_d_description'] : ''; ?></textarea>
                                                <?php if (isset($error_other_d_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_other_d_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>


                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-detail-second-description<?php echo $lang['language_id'] ?>">
                                                Detail Second Description
                                                </label>
                                                <textarea rows="5" name="business_description[<?php echo $lang['language_id'] ?>][detail_second_description]" placeholder="Detail Second Description" id="input-detail-second-description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['detail_second_description'] : ''; ?></textarea>
                                                <?php if (isset($error_detail_second_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_detail_second_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="business_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="business_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <textarea rows="5" name="business_description[<?php echo $lang['language_id'] ?>][meta_description]" placeholder="Meta Description" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($business_description[$lang['language_id']]) ? $business_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <div class="tab-pane" id="tab-data">
                        <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-category-id">
                                     Sectors
                                    </label>
                                    <select name="sector_id" id="input-category-id" class="form-control">
                                        <option value="">Choose Sector</option>
                                        <?php 
                                        foreach ($c_sectors as $sector) { ?>
                                        <option value="<?php echo $sector['id']; ?>"
                                            <?php echo ($sector['id'] == $sector_id) ? "selected" : ""; ?>>
                                            <?php echo $sector['title']; ?>
                                        </option>
                                        <?php  } ?>
                                    </select>
                                    <?php if ($error_sector) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_sector; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div> 
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-website-url">
                                        Website Url
                                    </label>
                                    <input type="text" name="website_url" value="<?php echo $website_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_website_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_website_url; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-iframe-map">
                                     Map Url
                                    </label>
                                    <input type="text" name="iframe_map" value="<?php echo $iframe_map; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_iframe_map)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_iframe_map; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-phone">
                                        Phone
                                    </label>
                                    <input type="text" name="phone" value="<?php echo $phone; ?>" class="form-control" maxlength="15"/>
                                </div>
                                <?php if (isset($error_phone)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_phone; ?>
                                    </div>
                                <?php } ?>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-email">
                                        Email
                                    </label>
                                    <input type="email" name="email" value="<?php echo $email; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_email)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_email; ?>
                                    </div>
                                <?php } ?>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                <div class="form-group required">
                                    <label class="control-label" for="input-address">
                                        Address
                                    </label>
                                    <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                                </div>
                                <?php if (isset($error_address)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_address; ?>
                                    </div>
                                <?php } ?>
                                </div>


                        
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-image">Image</label>
                                        <input onchange="loadFile(event)" type="file" name="banner_image" id="image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_banner) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_banner; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($banner_image) { ?>
                                        <img id="bimage" src="../uploads/image/business/<?= $banner_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="bimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='banner_image' value="<?= $banner_image ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-image">Logo</label>
                                        <input onchange="load2File(event)" type="file" name="icon" id="image-icon" accept=".png,.jpg,.jpeg,.svg" style="display: block;">
                                    </div>
                                    <?php if ($error_icon) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_icon; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($icon) { ?>
                                        <img id="cimage" src="../uploads/image/business/<?= $icon ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='icon' value="<?= $icon ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-thumbnail">Thumb image</label>
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
                                        <img id="cthumbnail" src="../uploads/image/business/<?= $thumbnail ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cthumbnail" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='thumbnail' value="<?= $thumbnail ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-other_d_image">Other details image</label>
                                        <input onchange="load4File(event)" type="file" name="other_d_image" id="other-d-image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_other_d_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_other_d_image; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($other_d_image) { ?>
                                        <img id="cotherdimage" src="../uploads/image/business/<?= $other_d_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cotherdimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='other_d_image' value="<?= $other_d_image ?>">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-stats-scond-image">Stats Second Image</label>
                                        <input onchange="load5File(event)" type="file" name="stats_scond_image" id="stats-scond-image" accept=".png,.jpg,.jpeg" style="display: block;">
                                    </div>
                                    <?php if ($error_stats_scond_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_stats_scond_image; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($stats_scond_image) { ?>
                                        <img id="cstatsscondimage" src="../uploads/image/business/<?= $stats_scond_image ?>" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                        <img id="cstatsscondimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='stats_scond_image' value="<?= $stats_scond_image ?>">
                                </div>
                            </div>
                            </br>
                            </br>
                            </br>

                            <div class="row">
                                <div class="table-responsive">
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left required">Additional Images</td>
                                                <td class="text-center required">Content Title</td>
                                                <td class="text-center required">Image Content</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $image_row = 0;
                                            foreach ($business_images as $business_image) {
                                            ?>
                                                <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="<?php echo $business_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="busines_images[<?php echo $image_row; ?>][image]" value="<?php echo $business_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                        <?php if ($error_busines_images[$image_row]['image']) : ?>
                                                            <div class="text-danger"><?php echo $error_busines_images[$image_row]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                </span>
                                                                <input type="text" name="busines_images[<?php echo $image_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($business_image['description'][$language['language_id']]['title']) ? $business_image['description'][$language['language_id']]['title'] : ''; ?>" />
                                                            </div>
                                                            <?php if ($error_busines_images[$image_row]['title'][$language['language_id']]) : ?>
                                                                <div class="text-danger"><?php echo $error_busines_images[$image_row]['title'][$language['language_id']]; ?></div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                        </span>
                                                                        <textarea id="input-busines-images-description-<?php echo $language['language_id']; ?>-<?php echo $image_row; ?>" name="busines_images[<?php echo $image_row; ?>][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"><?php echo isset($business_image['description'][$language['language_id']]['content']) ? $business_image['description'][$language['language_id']]['content'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if ($error_busines_images[$image_row]['content'][$language['language_id']]) : ?>
                                                                    <div class="text-danger"><?php echo $error_busines_images[$image_row]['content'][$language['language_id']]; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="busines_images[<?php echo $image_row; ?>][sort_order]" value="<?php echo $business_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $image_row = $image_row + 1; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            </br>
                            </br>
                            </br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="icons" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left required">Project Capabilities Images</td>
                                                <td class="text-center required">Content Title</td>
                                                <td class="text-center required">Image Content</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $image_row_icons = 0;
                                            foreach ($busines_icons as $business_icon) {
                                            ?>
                                                <tr id="image-row-icons<?php echo $image_row_icons; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-icon<?php echo $image_row_icons; ?>" class="image-picker2">
                                                            <img src="<?php echo $business_icon['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="busines_icons[<?php echo $image_row_icons; ?>][image]" value="<?php echo $business_icon['image']; ?>" id="input-image-icon<?php echo $image_row_icons; ?>" />
                                                        <?php if ($error_busines_icons[$image_row_icons]['image']) : ?>
                                                            <div class="text-danger"><?php echo $error_busines_icons[$image_row_icons]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                </span>
                                                                <input type="text" name="busines_icons[<?php echo $image_row_icons; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($business_icon['description'][$language['language_id']]['title']) ? $business_icon['description'][$language['language_id']]['title'] : ''; ?>" />
                                                            </div>
                                                            <?php if ($error_busines_icons[$image_row_icons]['title'][$language['language_id']]) : ?>
                                                                <div class="text-danger"><?php echo $error_busines_icons[$image_row_icons]['title'][$language['language_id']]; ?></div>
                                                            <?php endif; ?>

                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                        </span>
                                                                        <textarea id="input-busines-icons-description-<?php echo $language['language_id']; ?>-<?php echo $image_row_icons; ?>" name="busines_icons[<?php echo $image_row_icons; ?>][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"><?php echo isset($business_icon['description'][$language['language_id']]['content']) ? $business_icon['description'][$language['language_id']]['content'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if ($error_busines_icons[$image_row_icons]['content'][$language['language_id']]) : ?>
                                                                    <div class="text-danger"><?php echo $error_busines_icons[$image_row_icons]['content'][$language['language_id']]; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="busines_icons[<?php echo $image_row_icons; ?>][sort_order]" value="<?php echo $business_icon['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#image-row-icons<?php echo $image_row_icons; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $image_row_icons = $image_row_icons + 1; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4"></td>
                                                <td class="text-left"><button type="button" onclick="addImageIcons();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            </br>
                            </br>
                            </br>
                            <div class="row">
                                <div class="table-responsive">
                                    <table id="other_details" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-center required">Other Detail Title</td>
                                                <td class="text-center required">Other Detail Content</td>
                                                <td class="text-right">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $other_detail_row = 0;
                                            foreach ($business_other_details as $business_other_detail) {
                                            ?>
                                                <tr id="other-detail-row<?php echo $other_detail_row; ?>">
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="input-group">
                                                                <span class="input-group-text">
                                                                    <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                </span>
                                                                <input type="text" name="business_other_details[<?php echo $other_detail_row; ?>][description][<?php echo $language['language_id']; ?>][title]" placeholder="Title" class="form-control" value="<?php echo isset($business_other_detail['description'][$language['language_id']]['title']) ? $business_other_detail['description'][$language['language_id']]['title'] : ''; ?>" />
                                                            </div>
                                                            <?php if ($error_busines_other_detail[$other_detail_row]['title'][$language['language_id']]) : ?>
                                                                <div class="text-danger"><?php echo $error_busines_other_detail[$other_detail_row]['title'][$language['language_id']]; ?></div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-left">
                                                        <?php foreach ($languages as $language) : ?>
                                                            <div class="col-md-12">
                                                                <div class="input-group mb-3">
                                                                    <div class="input-group">
                                                                        <span class="input-group-text">
                                                                            <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />
                                                                        </span>
                                                                        <textarea id="input-business_other_detail_description-<?php echo $language['language_id']; ?>-<?php echo $other_detail_row; ?>" name="business_other_details[<?php echo $other_detail_row; ?>][description][<?php echo $language['language_id']; ?>][content]" placeholder="Content" class="form-control"><?php echo isset($business_other_detail['description'][$language['language_id']]['content']) ? $business_other_detail['description'][$language['language_id']]['content'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <?php if ($error_busines_other_detail[$other_detail_row]['content'][$language['language_id']]) : ?>
                                                                    <div class="text-danger"><?php echo $error_busines_other_detail[$other_detail_row]['content'][$language['language_id']]; ?></div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="business_other_details[<?php echo $other_detail_row; ?>][sort_order]" value="<?php echo $business_other_detail['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                    </td>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#other-detail-row<?php echo $other_detail_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $other_detail_row = $other_detail_row + 1; ?>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="text-left"><button type="button" onclick="addOtherDetails();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
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
                                    <select name="publish" id="input-status" class="form-control">
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
<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script> -->
<script type="text/javascript">
    var image_row = <?php echo  $image_row; ?>;
    var image_row_icons = <?php echo  $image_row_icons; ?>;
    function addImage() {
        var html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-image' + image_row + '" class="image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="busines_images[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '<img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input name="busines_images[' + image_row + '][description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="title" class="form-control"/>';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            var textareaId = 'input-busines-images-description-<?php echo $language['language_id']; ?>-' + image_row;
            html += '<div class="col-md-12">';
            html += '<div class="input-group mb-3">';
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '<textarea id="' + textareaId + '" name="busines_images[' + image_row + '][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"></textarea>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="busines_images[' + image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#image-row' + image_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#images tbody').append(html);
        image_row++;
    }
    function addImageIcons() {
        var html = '<tr id="image-row' + image_row_icons + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-icon' + image_row_icons + '" class="image-picker2">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="busines_icons[' + image_row_icons + '][image]" value="" id="input-image-icon' + image_row_icons + '" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '<img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input name="busines_icons[' + image_row_icons + '][description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="title" class="form-control"/>';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            var textareaId = 'input-busines-icons-description-<?php echo $language['language_id']; ?>-' + image_row_icons;
            html += '<div class="col-md-12">';
            html += '<div class="input-group mb-3">';
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '<textarea id="' + textareaId + '" name="busines_icons[' + image_row_icons + '][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"></textarea>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="busines_icons[' + image_row_icons + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#image-row' + image_row_icons + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#icons tbody').append(html);
        image_row_icons++;
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
                        url: '/admin/?controller=business/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src',
                                    '../uploads/image/business/' + response[
                                        'filename']);
                                var imageName = file.name;
                                $('#input-image' + imageRowId.replace('thumb-image',
                                    '')).val(response['filename']);
                            }
                        },
                    });
                }
            });
        });
    });
    $('#language a:first').tab('show');

    $(document).ready(function() {
        $('body').on('click', '.image-picker2', function(e) {
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
                        url: '/admin/?controller=business/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src',
                                    '../uploads/image/business/' + response[
                                        'filename']);
                                var imageName = file.name;
                                $('#input-image-icon' + imageRowId.replace('thumb-icon',
                                    '')).val(response['filename']);
                            }
                        },
                    });
                }
            });
        });
    });
    $('#language a:first').tab('show');
</script>
<?php echo $footer; ?>
<script>
    var loadFile = function(event) {
        var output = document.getElementById('bimage');
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 2 * 1024 * 1024;

        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
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
    var load3File = function(event) {
        var output = document.getElementById('cthumbnail');
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
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
        var output = document.getElementById('cotherdimage');
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
                return false;
            } else {
                output.src = URL.createObjectURL(file);
                output.onload = function() {
                    URL.revokeObjectURL(output.src);
                };
            }
        }
    };
    var load5File = function(event) {
        var output = document.getElementById('cstatsscondimage');
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 2 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 2 MB.');
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
<script type="text/javascript">
    $(function() {
        $("[rel='tooltip']").tooltip();
    });


    var other_detail_row = <?php echo $other_detail_row; ?>;
    function addOtherDetails() {
        var html = '<tr id="other-detail-row' + other_detail_row + '">';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '<img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '      <input name="business_other_details[' + other_detail_row + '][description][<?php echo $language['language_id']; ?>][title]" value="" placeholder="title" class="form-control"/>';
            html += '    </div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-left">';
        <?php foreach ($languages as $language) { ?>
            var textareaId = 'input-business_other_detail_description-<?php echo $language['language_id']; ?>-' + other_detail_row;
            html += '<div class="col-md-12">';
            html += '<div class="input-group mb-3">';
            html += '    <div class="input-group">';
            html += '      <span class="input-group-text">';
            html += '        <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>"/>';
            html += '      </span>';
            html += '<textarea id="' + textareaId + '" name="business_other_details['+ other_detail_row +'][description][<?php echo $language['language_id']; ?>][content]" placeholder="Image Content" class="form-control"></textarea>';
            html += '    </div>';
            html += '  </div>';
            html += '</div>';
        <?php } ?>
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="business_other_details['+ other_detail_row +'][sort_order]" value="" placeholder="sort order" class="form-control" />';
        html += '  </td>';
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#other-detail-row' + other_detail_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#other_details tbody').append(html);
      
        other_detail_row++;
    }
</script>