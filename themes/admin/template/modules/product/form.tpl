<?php echo $header; ?>

<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <!-- Page title -->
            <h3><?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <!-- Save and Cancel buttons (top) -->
            <button type="submit" form="form-product" data-toggle="tooltip" title="<?php echo 'Save'; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo 'Cancel'; ?>" class="btn btn-primary"><i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- Display error and success messages -->
                <?php if ($error_warning) { ?>
                    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $_SESSION['error_warning'] = null;
                } ?>
                <?php if (isset($this->session->data['success'])) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                        <?php echo $this->session->data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $this->session->data['success'] = null;
                } ?>

                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-product" class="form-horizontal">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
                        <li><a href="#tab-data" data-toggle="tab">Data</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab-general">
                            <!-- Language tabs for multilingual input -->
                            <ul class="nav nav-tabs" id="language">
                                <?php foreach ($languages as $language) { ?>
                                    <li><a href="#language<?php echo $language['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" /> <?= $language['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                    <div class="tab-pane" id="language<?php echo $language['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <!-- Title input -->
                                                <label class="control-label" for="input-title<?php echo $language['language_id']; ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['title'] : ''; ?>" placeholder="Title" id="input-title<?php echo $language['language_id']; ?>" class="form-control" />
                                                <?php if (isset($error_title[$language['language_id']])) { ?>
                                                    <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <!-- Short-Description input -->
                                                <label class="control-label" for="input-short-description<?php echo $language['language_id']; ?>">
                                                    Short Description
                                                </label>
                                                <textarea name="product_description[<?php echo $language['language_id']; ?>][short_description]" rows="5" placeholder="Short Description" id="input-short-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]['short_description']) ? $product_description[$language['language_id']]['short_description'] : ''; ?></textarea>
                                                <?php if (isset($error_short_description[$language['language_id']])) { ?>
                                                    <div class="text-danger"><?php echo $error_short_description[$language['language_id']]; ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <!-- Description input -->
                                                <label class="control-label" for="input-product_description<?php echo $language['language_id']; ?>">
                                                    Description
                                                </label>
                                                <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" placeholder="Description" id="input-product_description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]['description']) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
                                                <?php if (isset($error_description[$language['language_id']])) { ?>
                                                    <div class="text-danger"><?php echo $error_description[$language['language_id']]; ?></div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-made-in">Made In</label>
                                    <select name="made_in" id="input-made-in" class="form-control">
                                        <?php if (!empty($made_in_options)) { ?>
                                            <?php foreach ($made_in_options as $option) { ?>
                                                <option value="<?php echo htmlspecialchars($option['country_id']); ?>" <?php echo ($made_in == $option['country_id']) ? 'selected' : ''; ?>>
                                                    <?php echo htmlspecialchars($option['name']); ?>
                                                </option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_made_in)) { ?>
                                        <div class="text-danger"><?php echo $error_made_in; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort-order">Sort Order</label>
                                    <input type="number" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="Sort Order" id="input-sort-order" class="form-control" />
                                    <?php if (isset($error_sort_order)) { ?>
                                        <div class="text-danger"><?php echo $error_sort_order; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-screen-size">Screen Size (in inches)</label>
                                    <input type="number" name="screen_size" value="<?php echo $screen_size; ?>" placeholder="Screen Size" id="input-screen-size" class="form-control" step="0.1" />
                                    <?php if (isset($error_screen_size)) { ?>
                                        <div class="text-danger"><?php echo $error_screen_size; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sku">SKU (Stock Keeping Unit)</label>
                                    <input type="text" name="sku" value="<?php echo $sku; ?>" placeholder="e.g., SKU-12345" id="input-sku" class="form-control" />
                                    <?php if (isset($error_sku)) { ?>
                                        <div class="text-danger"><?php echo $error_sku; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-video">Video (YouTube/Vimeo) </label>
                                    <input type="url" name="video" value="<?php echo $video; ?>" placeholder="Video URL" id="input-video" class="form-control" />
                                    <?php if (isset($error_video)) { ?>
                                        <div class="text-danger"><?php echo $error_video; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-status">Status</label>
                                    <select name="status" id="input-status" class="form-control">
                                        <?php if ((int)$status) { ?>
                                            <option value="1" selected="selected">Enabled</option>
                                            <option value="0">Disabled</option>
                                        <?php } else { ?>
                                            <option value="1">Enabled</option>
                                            <option value="0" selected="selected">Disabled</option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_status)) { ?>
                                        <div class="text-danger"><?php echo $error_status; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-publish-date">Publish Date</label>
                                    <input type="date" name="publish_date" value="<?php echo $publish_date; ?>" id="input-publish-date" class="form-control" />
                                    <?php if (isset($error_publish_date)) { ?>
                                        <div class="text-danger"><?php echo $error_publish_date; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-featured">Featured</label>
                                    <select name="featured" id="input-featured" class="form-control">
                                        <?php if ((int)$featured) { ?>
                                            <option value="1" selected="selected">Yes</option>
                                            <option value="0">No</option>
                                        <?php } else { ?>
                                            <option value="1">Yes</option>
                                            <option value="0" selected="selected">No</option>
                                        <?php } ?>
                                    </select>
                                    <?php if (isset($error_featured)) { ?>
                                        <div class="text-danger"><?php echo $error_featured; ?></div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-icon">Icon</label>
                                        <input onchange="loadFile(event,'bimage')" type="file" name="icon" value="<?php echo $icon; ?>" id="input-icon" accept=".png,.jpg,.jpeg,.gif" style="display: block;">
                                        <small class="form-text text-muted">Upload an icon image (recommended size: 100x100px)</small>
                                    </div>
                                    <?php if ($error_icon) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_icon; ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-lg-2 col-md-2">
                                    <?php if (!empty($icon)) { ?>
                                        <img id="bimage" src="../uploads/image/product/<?php echo $icon; ?>" style="width: 100%; height: 89px; margin-top: 12px;" alt="<?= $icon; ?>">
                                    <?php } else { ?>
                                        <img id="bimage" src="../uploads/image/no-image.png" style="width: 100%; height: 89px; margin-top: 12px;" title="No Image Found" alt="No Image">
                                    <?php } ?>
                                    <input type="hidden" name="icon" value="<?php echo $icon; ?>">
                                </div>
                            </div>
                            <!-- Featured -->
                            <div class="row">
                                <div class="table-responsive">
                                    <h3>For Featured</h3>
                                    <table id="images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left required">Image</td>
                                                <td class="text-right required">Sort Order</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $image_row = 0;
                                            foreach ($product_features_images as $product_features_image) {
                                            ?>
                                                <tr id="image-row<?php echo $image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="" id="thumb-image<?php echo $image_row; ?>" class="image-picker">
                                                            <img src="<?php echo $product_features_image['thumb']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="product_features_image[<?php echo $image_row; ?>][image]" value="<?php echo $product_features_image['image']; ?>" id="input-image<?php echo $image_row; ?>" />
                                                        <?php if ($error_product_features_image[$image_row]['image']) : ?>
                                                            <div class="text-danger"><?php echo $error_product_features_image[$image_row]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <input type="text" name="product_features_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $product_features_image['sort_order']; ?>" placeholder="sort order" class="form-control" />
                                                        <?php if ($error_product_features_image[$image_row]['sort_order']) : ?>
                                                            <div class="text-danger"><?php echo $error_product_features_image[$image_row]['sort_order']; ?></div>
                                                        <?php endif; ?>
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
                                                <td colspan="2"></td>
                                                <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                            <!-- Benefits -->
                            <div class="row">
                                <div class="table-responsive">
                                    <h3>For Benefits</h3>
                                    <table id="benefits-images" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <td class="text-left required">Icon</td>
                                                <td class="text-right required">Title</td>
                                                <td class="text-right required">Description</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $benefits_image_row = 1; ?>
                                            <?php foreach ($product_benefits_image as $benefit) { ?>
                                                <tr id="benefits-image-row<?php echo $benefits_image_row; ?>">
                                                    <td class="text-left">
                                                        <a href="#" id="thumb-benefits-image<?php echo $benefits_image_row; ?>" class="benefits-image-picker">
                                                            <img src="<?php echo $benefit['image']; ?>" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;" />
                                                        </a>
                                                        <input type="hidden" name="product_benefits_image['description'][<?php echo $benefits_image_row; ?>][image]" value="<?php echo $benefit['image']; ?>" id="input-benefits-image<?php echo $benefits_image_row; ?>" />
                                                        <?php if (!empty($error_product_benefits_image[$benefits_image_row]['image'])) : ?>
                                                            <div class="text-danger"><?php echo $error_product_benefits_image[$benefits_image_row]['image']; ?></div>
                                                        <?php endif; ?>
                                                    </td>
                                                    
                                                    <?php foreach ($languages as $language) { ?>
                                                        <td class="text-right">
                                                            <div style="margin-bottom: 5px;">
                                                                <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" style="height:16px;" />
                                                                <input type="text"
                                                                    name="benefit[<?php echo $benefits_image_row; ?>][title][<?php echo $language['language_id']; ?>]"
                                                                    value="<?php echo isset($benefit[$benefits_image_row]['title'][$language['language_id']]) ? htmlspecialchars($benefit[$benefits_image_row]['title'][$language['language_id']]) : ''; ?>"
                                                                    placeholder="Title (<?php echo $language['name']; ?>)"
                                                                    class="form-control"
                                                                    style="display:inline-block; width:85%;" />
                                                                <?php if (!empty($error_benefit[$benefits_image_row]['title'][$language['language_id']])) { ?>
                                                                    <div class="text-danger"><?php echo $error_benefit[$benefits_image_row]['title'][$language['language_id']]; ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                        <td class="text-right">
                                                            <div style="margin-bottom: 5px;">
                                                                <img src="/vars/lang/be/<?php echo $language['code']; ?>-<?php echo $language['image']; ?>" style="height:16px;" />
                                                                <input type="text"
                                                                    name="benefit[<?php echo $benefits_image_row; ?>][description][<?php echo $language['language_id']; ?>]"
                                                                    value="<?php echo isset($benefit[$benefits_image_row]['description'][$language['language_id']]) ? htmlspecialchars($benefit[$benefits_image_row]['description'][$language['language_id']]) : ''; ?>"
                                                                    placeholder="Description (<?php echo $language['name']; ?>)"
                                                                    class="form-control"
                                                                    style="display:inline-block; width:85%;" />
                                                                <?php if (!empty($error_benefit[$benefits_image_row]['description'][$language['language_id']])) { ?>
                                                                    <div class="text-danger"><?php echo $error_benefit[$benefits_image_row]['description'][$language['language_id']]; ?></div>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    <?php } ?>
                                                    <td class="text-left">
                                                        <button type="button" onclick="$('#benefits-image-row<?php echo $benefits_image_row; ?>').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">
                                                            <i class="fa fa-minus-circle"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <?php $benefits_image_row++; ?>
                                            <?php } ?>
                                        </tbody>

                                        <tfoot>
                                            <tr>
                                                <td colspan="3"></td>
                                                <td class="text-left"><button type="button" onclick="addBenefitsImage();" data-toggle="tooltip" title="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Bottom action buttons -->
                    <div class="col-lg-6 col-md-6 bottom-inline-btns">
                        <button type="submit" form="form-product" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // Activate the first language tab by default
    $('#language a:first').tab('show');
</script>
<?php echo $footer; ?>
<!-- Image upload script -->
<script>
    var loadFile = function(event) {
        var output = document.getElementById('bimage');
        var file = event.target.files[0];
        var validExtensions = ['png', 'jpeg', 'jpg'];
        var maxSize = 5 * 1024 * 1024;
        if (file) {
            var extension = file.name.split('.').pop().toLowerCase();
            if (validExtensions.indexOf(extension) === -1 || file.size > maxSize) {
                event.target.value = '';
                alert('Please select a valid file (PNG, JPEG, JPG) less than 5 MB.');
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

<!-- Gallery image upload script for feature images -->
<script language="javascript" type="text/javascript">
    var image_row = <?php echo  $image_row; ?>;

    function addImage() {
        var html = '<tr id="image-row' + image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-image' + image_row + '" class="image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="product_features_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" />';
        html += '  </td>';
        html += '  <td class="text-right">';
        html += '    <input type="text" name="product_features_image[' + image_row + '][sort_order]" value="" placeholder="sort order" class="form-control" />';
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
    $(document).ready(function() {
        $('body').on('click', '.image-picker', function(e) {
            e.preventDefault();
            var imageRowId = $(this).attr('id');
            var maxSize = 5 * 1024 * 1024;
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

                    if (file.size > maxSize) {
                        alert('The file is too large. Please select a file smaller than ' + maxSize + ' MB.');
                        return;
                    }

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    var fd = new FormData();
                    fd.append('image', file);
                    $.ajax({
                        url: '/admin/?controller=product/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src', '../uploads/image/product/' + response['filename']);
                                var imageName = file.name;
                                $('#input-image' + imageRowId.replace('thumb-image', '')).val(response['filename']);
                            }
                        },
                    });
                }

            });
        });
    });
</script>


<!-- gallery script for benefits images -->
<script language="javascript" type="text/javascript">
    var benefits_image_row = <?php echo isset($benefits_image_row) ? $benefits_image_row : 0; ?>;
    var languages = <?php echo json_encode($languages); ?>;

    function addBenefitsImage() {
        var html = '<tr id="benefits-image-row' + benefits_image_row + '">';
        html += '  <td class="text-left">';
        html += '    <a href="#" id="thumb-benefits-image' + benefits_image_row + '" class="benefits-image-picker">';
        html += '      <img src="../uploads/image/no-image.png" alt="" title="" data-placeholder="" class="image-preview" style="width: 100px; height: 100px;"/>';
        html += '    </a>';
        html += '    <input type="hidden" name="product_benefits_image[' + benefits_image_row + '][image]" value="" id="input-benefits-image' + benefits_image_row + '" />';
        html += '  </td>';
        for (var i = 0; i < languages.length; i++) {
            var lang = languages[i];
            html += '  <td class="text-right">';
            html += '<div style="margin-bottom: 5px;">';
            html += '<img src="/vars/lang/be/' + lang.code + '-' + lang.image + '" style="height:16px;" />';
            html += '<input type="text" name="benefit[' + benefits_image_row + '][title][' + lang.language_id + ']" value="" placeholder="Title (' + lang.name + ')" class="form-control" style="display:inline-block; width:85%;" />';
            html += '</div>';
            html += '  </td>';
            html += '  <td class="text-right">';
            html += '<div style="margin-bottom: 5px;">';
            html += '<img src="/vars/lang/be/' + lang.code + '-' + lang.image + '" style="height:16px;" />';
            html += '<input type="text" name="benefit[' + benefits_image_row + '][description][' + lang.language_id + ']" value="" placeholder="Description (' + lang.name + ')" class="form-control" style="display:inline-block; width:85%;" />';
            html += '</div>';
            html += '  </td>';
        }
        html += '  <td class="text-left">';
        html += '    <button type="button" onclick="$(\'#benefits-image-row' + benefits_image_row + '\').remove();" data-toggle="tooltip" title="remove" class="btn btn-danger">';
        html += '      <i class="fa fa-minus-circle"></i>';
        html += '    </button>';
        html += '  </td>';
        html += '</tr>';
        $('#benefits-images tbody').append(html);
        benefits_image_row++;
    }

    $(document).ready(function() {
        $('body').on('click', '.benefits-image-picker', function(e) {
            e.preventDefault();
            var imageRowId = $(this).attr('id');
            var maxSize = 5 * 1024 * 1024;
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

                    if (file.size > maxSize) {
                        alert('The file is too large. Please select a file smaller than 5 MB.');
                        return;
                    }

                    var fd = new FormData();
                    fd.append('image', file);
                    $.ajax({
                        url: '/admin/?controller=product/uploadImages&token=<?php echo $token; ?>',
                        type: 'post',
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response['filename']) {
                                $('#' + imageRowId + ' .image-preview').attr('src', '../uploads/image/product/' + response['filename']);
                                $('#input-benefits-image' + imageRowId.replace('thumb-benefits-image', '')).val(response['filename']);
                            }
                        },
                    });
                }
            });
        });
    });
</script>

<script type="text/javascript">
    <?php foreach ($languages as $language) { ?>
        var lang = 'input-product_description<?php echo $language['language_id']; ?>';
        var code = '<?php echo $language["code"] ?>';
        var textarea = document.getElementById(lang);
        CKEDITOR.replace(textarea, {
            language: code,
            basicEntities: false
        });
    <?php } ?>
</script>

<script type="text/javascript">
    // JavaScript/jQuery for dynamic behavior of the show-in-footer checkbox
    document.getElementById('input-show-in-footer').addEventListener('change', function() {
        // Change value to 1 when checked, 0 when unchecked
        this.value = this.checked ? '1' : '0';
        // Apply custom styles for checked state
        if (this.checked) {
            this.style.accentColor = "blue"; // Works in modern browsers
        } else {
            this.style.accentColor = ""; // Reset to default
        }
    });
</script>