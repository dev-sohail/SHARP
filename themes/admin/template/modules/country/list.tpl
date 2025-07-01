<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3><i class="fa fa-flag"></i> Countries</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" data-toggle="tooltip" title="Add New" class="btn btn-primary"><i class="fa fa-plus"></i></a>
            <button type="button" data-toggle="tooltip" title="Delete" class="btn btn-danger" onclick="confirm('Are you sure?') ? $('#form-country').submit() : false;"><i class="fa fa-trash-o"></i></button>
        </div>
    </div>
    <div class="main-employee-box">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <?php if ($success) { ?>
        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-country">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                            <td class="text-left">Country Name</td>
                            <td class="text-left">ISO Code (2)</td>
                            <td class="text-left">ISO Code (3)</td>
                            <td class="text-right">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($countries) { ?>
                        <?php foreach ($countries as $country) { ?>
                        <tr>
                            <td class="text-center"><?php if (in_array($country['country_id'], $selected)) { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" checked="checked" />
                                <?php } else { ?>
                                <input type="checkbox" name="selected[]" value="<?php echo $country['country_id']; ?>" />
                                <?php } ?></td>
                            <td class="text-left"><?php echo $country['name']; ?></td>
                            <td class="text-left"><?php echo $country['iso_code_2']; ?></td>
                            <td class="text-left"><?php echo $country['iso_code_3']; ?></td>
                            <td class="text-right"><a href="<?php echo $country['edit']; ?>" data-toggle="tooltip" title="Edit" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                        </tr>
                        <?php } ?>
                        <?php } else { ?>
                        <tr>
                            <td class="text-center" colspan="5">No results!</td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
<?php echo $footer; ?> 