<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><i class="fa fa-flag"></i> <?php echo $text_form; ?></h3>
        </div>
        <div class="sec-head-btns">
            <button type="submit" form="form-country" data-toggle="tooltip" title="Save" class="btn btn-primary"><i class="fa fa-save"></i></button>
            <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="Cancel" class="btn btn-default"><i class="fa fa-reply"></i></a>
        </div>
    </div>
    <div class="main-employee-box">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-country" class="form-horizontal">
            <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-name">Country Name</label>
                <div class="col-sm-10">
                    <input type="text" name="name" value="<?php echo $name; ?>" placeholder="Country Name" id="input-name" class="form-control" />
                    <?php if ($error_name) { ?>
                    <div class="text-danger"><?php echo $error_name; ?></div>
                    <?php } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-iso-code-2">ISO Code (2)</label>
                <div class="col-sm-10">
                    <input type="text" name="iso_code_2" value="<?php echo $iso_code_2; ?>" placeholder="ISO Code (2)" id="input-iso-code-2" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-iso-code-3">ISO Code (3)</label>
                <div class="col-sm-10">
                    <input type="text" name="iso_code_3" value="<?php echo $iso_code_3; ?>" placeholder="ISO Code (3)" id="input-iso-code-3" class="form-control" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-address-format">Address Format</label>
                <div class="col-sm-10">
                    <textarea name="address_format" rows="5" placeholder="Address Format" id="input-address-format" class="form-control"><?php echo $address_format; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Postcode Required</label>
                <div class="col-sm-10">
                    <label class="radio-inline">
                        <?php if ($postcode_required) { ?>
                        <input type="radio" name="postcode_required" value="1" checked="checked" /> Yes
                        <?php } else { ?>
                        <input type="radio" name="postcode_required" value="1" /> Yes
                        <?php } ?>
                    </label>
                    <label class="radio-inline">
                        <?php if (!$postcode_required) { ?>
                        <input type="radio" name="postcode_required" value="0" checked="checked" /> No
                        <?php } else { ?>
                        <input type="radio" name="postcode_required" value="0" /> No
                        <?php } ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status">Status</label>
                <div class="col-sm-10">
                    <select name="status" id="input-status" class="form-control">
                        <?php if ($status) { ?>
                        <option value="1" selected="selected">Enabled</option>
                        <option value="0">Disabled</option>
                        <?php } else { ?>
                        <option value="1">Enabled</option>
                        <option value="0" selected="selected">Disabled</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>
<?php echo $footer; ?> 