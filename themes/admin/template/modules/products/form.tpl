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
                <?php $_SESSION['error_warning'] = null; } ?>
                <?php if (isset($this->session->data['success'])) { ?>
                    <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                        <?php echo $this->session->data['success']; ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                <?php $this->session->data['success'] = null; } ?>
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
                                        <div class="col-lg-12 col-md-12">
                                            <div class="form-group required">
                                                <!-- Title input -->
                                                <label class="control-label" for="input-title-<?php echo $language['language_id']; ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][title]" value="<?php echo isset($product_description[$language['language_id']]['title']) ? $product_description[$language['language_id']]['title'] : ''; ?>" placeholder="Title" id="input-title-<?php echo $language['language_id']; ?>" class="form-control" />
                                                <?php if (isset($error_title[$language['language_id']])) { ?>
                                                    <div class="text-danger"><?php echo $error_title[$language['language_id']]; ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group required">
                                                <!-- Designation input -->
                                                <label class="control-label" for="input-designation-<?php echo $language['language_id']; ?>">
                                                    Designation
                                                </label>
                                                <input type="text" name="product_description[<?php echo $language['language_id']; ?>][designation]" value="<?php echo isset($product_description[$language['language_id']]['designation']) ? $product_description[$language['language_id']]['designation'] : ''; ?>" placeholder="Designation" id="input-designation-<?php echo $language['language_id']; ?>" class="form-control" />
                                                <?php if (isset($error_designation[$language['language_id']])) { ?>
                                                    <div class="text-danger"><?php echo $error_designation[$language['language_id']]; ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="form-group required">
                                                <!-- Description input -->
                                                <label class="control-label" for="input-description-<?php echo $language['language_id']; ?>">
                                                    Description
                                                </label>
                                                <textarea name="product_description[<?php echo $language['language_id']; ?>][description]" placeholder="Description" id="input-description-<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]['description']) ? $product_description[$language['language_id']]['description'] : ''; ?></textarea>
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
                                    <label class="control-label" for="input-stars">Number of Stars</label>
                                    <input type="number" name="number_of_stars" value="<?php echo $number_of_stars; ?>" placeholder="Number of Stars" id="input-stars" class="form-control" min="1" max="5" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-sort-order">Sort Order</label>
                                    <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="Sort Order" id="input-sort-order" class="form-control" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label class="control-label" for="input-icon">Icon</label>
                                        <input onchange="loadFile(event,'bimage')" type="file" name="icon" value="<?php echo $icon; ?>" id="input-icon" accept=".png,.jpg,.jpeg,.gif" class="form-control" style="display: block;">
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
                                    </div>
                                </div>
                        </div>
                    </div>
                        <!-- Bottom action buttons -->
                        <div class="col-lg-6 col-md-6 bottom-inline-btns">
                            <button type="submit" form="form-product" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                        </div>
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
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
    };
</script>
<script>
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