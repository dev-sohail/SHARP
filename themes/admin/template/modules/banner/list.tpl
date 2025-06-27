<?php echo $header; ?>

<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Banners</h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Banner </a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="employee-table-out-box">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <?php $_SESSION['error_warning'] = null;  ?>
                    <?php if ($success) { ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                            <?php echo $success; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php  }  ?>
                    <div class="card">
                        <div class="card-bodys">
                            <table class="table table-striped table-bordered table-hover" id="noir-tabale" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <th><input type="text" placeholder="Title"></th>
                                        <th id="banner-status"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($banners) { ?>
                                        <?php foreach ($banners as $banner) { ?>
                                            <tr class="stdfilters">
                                                <td class="text-left">
                                                    <?php echo $banner['name']; ?>
                                                </td>
                                                <td class="text-left">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $banner['banner_id']; ?>" <?php echo ($banner['status']) ? 'checked' : ''; ?> data-status-id="<?php echo $banner['banner_id']; ?>">
                                                        <label class="custom-control-label" for="statusToggle<?php echo $banner['banner_id']; ?>">
                                                            <?php echo ($banner['status']) ? 'Active' : 'Inactive'; ?>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td class="text-right">
                                                    <a style="display: inline-block;" href="<?php echo $banner['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                                    <form style="display: inline-block;" action="<?php echo $banner['delete']; ?>" method="post" enctype="multipart/form-data" id="del_banner<?php echo $banner['banner_id']; ?>">
                                                        <input type="hidden" name="banner_id" value="<?php echo $banner['banner_id']; ?>">
                                                        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onClick='submitDeleteForm("del_banner<?php echo $banner['banner_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loader HTML -->
<div id="loader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>


<script language="javascript" type="text/javascript">
    function submitDeleteForm(formname) {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $("#" + formname).submit();
        } else {
            return false;
        }
    }
</script>

<script type="text/javascript">
    var table = $('#noir-tabale').DataTable({
        "language": {
            "emptyTable": "No record found."
        },
        "pageLength": 10,
        "ordering": false,
        scrollX: true,
        orderCellsTop: true,
        fixedHeader: true,
        buttons: false,
        initComplete: function() {
            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function(colIdx) {
                var column = this;
                if (i == 3) {
                    var select = $('<select><option value="">Choose</option><option value=" Active ">Active</option><option value="Inactive">Inactive</option></select>')
                        .appendTo($('#banner-status').empty())
                        .on('change', function() {
                            var val = $(this).val();
                            column.search(val, true, false)
                                .draw(true);
                        });
                } else {
                    var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();
                    $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function(e) {
                            e.stopPropagation();
                            $(this).attr('title', $(this).val());
                            var regexr = '({search})';
                            var cursorPosition = this.selectionStart;
                            api
                                .column(colIdx)
                                .search((this.value != "") ? regexr.replace('{search}', '(((' + this.value + ')))') : "", this.value != "", this.value == "")
                                .draw();
                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        });
                }
                i = i + 1;
            });
        }
    });
</script>

<script>
    $(document).on('change', 'input[type="checkbox"]', function() {
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var bannerId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active' : 'Inactive';

        // Show loader
        $('#loader').show();

        // Delay to simulate loader display
        // setTimeout(function() {
            $.ajax({
                url: '<?php echo $ajaxbannerstatus; ?>',
                method: 'POST',
                data: {
                    id: bannerId,
                    status: newStatus
                },
                success: function(response) {
                    $('#loader').hide();
                    if (response.success) {
                        var row = $('#noir-tabale').DataTable().row(checkbox.closest('tr'));
                        var rowData = row.data();
                        rowData[1] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + bannerId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + bannerId + '"> <label class="custom-control-label" for="statusToggle' + bannerId + '">' + newStatusText + '</label> </div>';
                        row.data(rowData).draw(false);
                    }
                },
                error: function(xhr, status, error) {
                    $('#loader').hide();
                    console.error('Error updating status:', error);
                    checkbox.prop('checked', !checkbox.is(':checked'));
                    statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
                }
            });
        // }, 3000); // 3 seconds delay
    });
</script>
<?php echo $footer; ?>
