<?php echo $header; ?>
<style>
    .image-container {
        position: relative;
        text-align: center;
    }

    .image-wrapper {
        position: relative;
        display: inline-block;
    }

    .delete-btn {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: transparent;
        border: none;
        font-size: 24px;
        color: red;
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .image-wrapper:hover .delete-btn {
        opacity: 1;
    }

    .dropdown-menu {
        width: 100%;

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
</style>
<style>
    /* Remove default browser checkbox styling */
    #input-show-on-home {
        -webkit-appearance: none; 
        -moz-appearance: none; 
        appearance: none; 
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        position: relative;
    }
    #input-show-on-home:checked {
        border-color: blue;
        background-color: blue;
    }
    #input-show-on-home:checked::after {
        color: white;
        font-size: 16px;
        position: absolute;
        top: 2px;
        left: 3px;
    }
    #tab-data .form-check-label{
      line-height: 25px;
      margin-left: 10px;
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
                                    <li><a href="#language<?php echo $lang['language_id'] ?>" data-toggle="tab"><img src="/vars/lang/be/<?php echo $lang['code']; ?>-<?php echo $lang['image']; ?>" /> <?php echo $lang['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $lang) { ?>
                                    <div class="tab-pane" id="language<?php echo $lang['language_id'] ?>">
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-title<?php echo $lang['language_id'] ?>">
                                                    Title
                                                </label>
                                                <input type="text" name="news_events_description[<?php echo $lang['language_id'] ?>][title]" value="<?php echo isset($news_events_description[$lang['language_id']]) ? $news_events_description[$lang['language_id']]['title'] : ''; ?>" placeholder="Title" id="input-title<?php echo $lang['language_id'] ?>" class="form-control" />
                                                <?php if (isset($error_title[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_title[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group required">
                                                <label class="control-label" for="input-description<?php echo $lang['language_id'] ?>">
                                                    Description
                                                </label>
                                                <textarea name="news_events_description[<?php echo $lang['language_id'] ?>][description]" placeholder="Description" id="input-description<?php echo $lang['language_id'] ?>" class="form-control"> <?php echo isset($news_events_description[$lang['language_id']]) ? $news_events_description[$lang['language_id']]['description'] : ''; ?></textarea>
                                                <?php if (isset($error_description[$lang['language_id']])) { ?>
                                                    <div class="text-danger">
                                                        <?php echo $error_description[$lang['language_id']]; ?>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_title<?php echo $lang['language_id'] ?>">
                                                    Meta Title
                                                </label>
                                                <input type="text" name="news_events_description[<?php echo $lang['language_id'] ?>][meta_title]" value="<?php echo isset($news_events_description[$lang['language_id']]) ? $news_events_description[$lang['language_id']]['meta_title'] : ''; ?>" placeholder="Meta Title" id="input-meta_title<?php echo $lang['language_id'] ?>" class="form-control" />

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_keyword<?php echo $lang['language_id'] ?>">
                                                    Meta Keyword
                                                </label>
                                                <input type="text" name="news_events_description[<?php echo $lang['language_id'] ?>][meta_keyword]" value="<?php echo isset($news_events_description[$lang['language_id']]) ? $news_events_description[$lang['language_id']]['meta_keyword'] : ''; ?>" placeholder="Meta Keyword" id="input-meta_keyword<?php echo $lang['language_id'] ?>" class="form-control" />

                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="form-group">
                                                <label class="control-label" for="input-meta_description<?php echo $lang['language_id'] ?>">
                                                    Meta Description
                                                </label>
                                                <textarea name="news_events_description[<?php echo $lang['language_id'] ?>][meta_description]" placeholder="Meta Description" rows="5" id="input-meta_description<?php echo $lang['language_id'] ?>" class="form-control"><?php echo isset($news_events_description[$lang['language_id']]) ? $news_events_description[$lang['language_id']]['meta_description'] : ''; ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab-data">
                                   <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                            <div class="form-check">
                                <input type="hidden" name="show_on_home" value="0">
                                <input 
                                    type="checkbox" 
                                    name="show_on_home" 
                                    id="input-show-on-home" 
                                    value="1"  
                                    class="form-check-input"
                                    <?php echo isset($show_on_home) && $show_on_home == '1' ? 'checked' : ''; ?> />
                                <label class="form-check-label" for="input-show-on-home">
                                    Show on home page
                                </label>
                            </div>
                        </div>
                    </div>
                           <div class="col-lg-6 col-md-6">
                            <div class="form-group required">
                                <label class="control-label" for="input-category-id">
                                    Category
                                </label>
                                <select name="ne_category_id" id="input-category-id" class="form-control">
                                    <option value="">Choose Category</option>
                                    <?php foreach ($news_categories as $categ) { ?>
                                        <option value="<?php echo $categ['ne_category_id']; ?>"
                                            <?php echo ($categ['ne_category_id'] == $ne_category_id) ? "selected" : ""; ?>>
                                            <?php echo $categ['title']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            <?php if (isset($error_ne_category_id[$lang['language_id']])) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_ne_category_id[$lang['language_id']]; ?>
                                        </div>
                                    <?php } ?>
                            </div>
                        </div>
                            <div class="row col-md-12">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group required">
                                    <label class="control-label" for="input-image">
                                    Thumb Image (534 × 355px)
                                    </label>
                                        <input onchange="loadFile(event)" type="file" name="thumbnail" id="image"
                                            accept=".png,.jpg,.jpeg" style="display: block;">
                                        <?php if ($error_thumbnail) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_thumbnail; ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($thumbnail) { ?>
                                    <img id="bimage" src="../uploads/image/newsevents/<?= $thumbnail ?>"
                                        style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                    <img id="bimage" src="../uploads/image/no-image.png"
                                        style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='thumbnail' value="<?= $thumbnail ?>">
                                </div>
                            </div>

                            <div class="row col-md-12">
                                <div class="col-lg-4 col-md-4">
                                    <div class="form-group required">
                                    <label class="control-label" for="input-banner-image">
                                    Banner Image (1116 × 600px)
                                    </label>
                                        <input onchange="loadFile1(event)" type="file" name="banner_image" id="banner-image"
                                            accept=".png,.jpg,.jpeg" style="display: block;">
                                        <?php if ($error_banner_image) { ?>
                                        <div class="text-danger">
                                            <?php echo $error_banner_image; ?>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-2 ">
                                    <?php if ($banner_image) { ?>
                                    <img id="bimage1" src="../uploads/image/newsevents/<?= $banner_image ?>"
                                        style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } else { ?>
                                    <img id="bimage1" src="../uploads/image/no-image.png"
                                        style="width: 100%; height: 89px;margin-top: 12px;">
                                    <?php } ?>
                                    <input type="hidden" name='banner_image' value="<?= $banner_image ?>">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-seo_url">
                                        Seo Url
                                    </label>
                                    <input type="text" name="seo_url" value="<?php echo $seo_url; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_seo_url)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_seo_url; ?>
                                    </div>
                                <?php } ?>
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
                                <div class="form-group required">
                                    <label class="control-label" for="input-publish_date">
                                        Publish Date
                                    </label>
                                    <input type="date" name="publish_date" value="<?php echo $publish_date; ?>" class="form-control" />
                                </div>
                                <?php if (isset($error_publish_date)) { ?>
                                    <div class="text-danger">
                                        <?php echo $error_publish_date; ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="input-publish">
                                        Publish
                                    </label>
                                    <select name="publish" id="input-publish" class="form-control">
                                        <?php if ($publish) { ?>
                                            <option value="1" selected="selected">Publish</option>
                                            <option value="0">Unpublish</option>
                                        <?php } else { ?>
                                            <option value="1">Publish</option>
                                            <option value="0" selected="selected">Unpublish</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="col-lg-6 col-md-6 bottom-inline-btns">
                        <?php if (!$viewer) { ?>
                            <button type="submit" form="form-customer" data-toggle="tooltip" title="Save" class="btn btn-success"> <i class="fa fa-save"></i> Submit</button>
                        <?php } ?>
                        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-danger"><i class="fa fa-reply"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#language a:first').tab('show');
</script>
<?php echo $footer; ?>

<script language="javascript" type="text/javascript">
</script>
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
var loadFile1 = function(event) {
    var file = event.target.files[0];
    var output = document.getElementById('bimage1');
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
<!-- 
<script>
function loadFile1(event) {
    document.getElementById('bimage1').src = URL.createObjectURL(event.target.files[0]);
}
function loadFile2(event) {
    document.getElementById('bimage2').src = URL.createObjectURL(event.target.files[0]);
}
function loadFile3(event) {
    document.getElementById('bimage3').src = URL.createObjectURL(event.target.files[0]);
}
</script> -->
