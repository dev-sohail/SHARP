<!-- Header section -->
<?php echo $header; ?>
<!-- Main content section -->
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <!-- Page title -->
            <h3><?php echo $heading_title; ?></h3>
        </div>
        <div class="sec-head-btns">
            <!-- Add Product button -->
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Product </a>
        </div>
    </div>
    <div class="main-employee-box">
        <div class="employee-table-out-box">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-bodys">
                            <!-- Display error and success messages -->
                            <?php if ($error_warning) { ?>
                                <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i>
                                    <?php echo $error_warning; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php $_SESSION['error_warning'] = null; } ?>
                            <?php $_SESSION['error_warning'] = null;  ?>
                            <?php if ($success) { ?>
                                <div class="alert alert-success"><i class="fa fa-check-circle"></i>
                                    <?php echo $success; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php  }  ?>
                            <!-- Product table -->
                            <table id="product-table" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Publish Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                    <tr class="stdfilters">
                                        <!-- Filter inputs for title -->
                                        <th><input type="text" placeholder="Title"></th>
                                        <th></th>
                                        <th id="drop-searc"></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($products) { ?>
                                    <?php foreach ($products as $product) { ?>
                                        <tr>
                                            <td>
                                                <?php echo $product['title']; ?>
                                            </td>
                                            <td>
                                                <?php echo date('Y-m-d', strtotime($product['publish_date'])); ?>
                                            </td>
                                            <td>
                                                <!-- Status toggle switch -->
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $product['product_id']; ?>" <?php echo ($product['status']) ? 'checked' : ''; ?> data-product-id="<?php echo $product['product_id']; ?>">
                                                    <label class="custom-control-label" for="statusToggle<?php echo $product['product_id']; ?>">
                                                        <?php echo ($product['status']) ? 'Enabled' : 'Disabled'; ?>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-right">
                                                <!-- Edit button -->
                                                <a style="display: inline-block;" href="<?php echo $product['edit']; ?>"
                                                    data-toggle="tooltip" class="btn btn-primary" title="<?php echo $button_edit; ?>"><i class="fa fa-pencil"></i></a>
                                                <!-- Delete button (with confirmation) -->
                                                <form style="display: inline-block;" action="<?php echo $product['delete']; ?>" method="post" enctype="multipart/form-data" id="del_product_<?php echo $product['product_id']; ?>">
                                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                                    <button type="button" data-toggle="tooltip" class="btn btn-danger" title="<?php echo $button_delete; ?>" onClick='submitDeleteForm("del_product_<?php echo $product['product_id']; ?>")'><i class="fa fa-trash-o"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php } else { ?>
                                    <tr>
                                        <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                                    </tr>
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

<!-- Loader overlay for AJAX requests -->
<div id="loader" class="loader-overlay" style="display: none;">
    <div class="loader"></div>
</div>

<!-- Delete confirmation script -->
<script language="javascript" type="text/javascript">
    // Confirm before submitting the delete form
    function submitDeleteForm(formname) {
        var x = confirm("Are you sure you want to delete?");
        if (x) {
            $("#" + formname).submit();
        } else {
            return false;
        }
    }
</script>
<!-- DataTables initialization script -->
<script type="text/javascript">
    // Initialize DataTables for Product table with filters and custom options
    var table = $('#product-table').DataTable({
        "language": {
            "emptyTable": "No record found."
        },
        // dom: 'Bfrtip',
        "pageLength": 10,
        "ordering": true,
        "order": [],
        orderCellsTop: true,
        fixedHeader: true,
        buttons: false,
        "columnDefs": [{
                "orderable": false,
                "targets": [1, 2]
            } // Disable sorting for the Status and Actions columns
        ],
        initComplete: function() {
            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function(colIdx) {
                var column = this;
                if (i == 2) {
                    // Status filter dropdown
                    var select = $('<select><option value="">Choose</option><option value="Enabled">Enabled</option><option value="Disabled">Disabled</option></select>')
                        .appendTo($('#drop-searc').empty())
                        .on('change', function() {
                            var val = $(this).val();
                            column.search(val, true, false).draw(true);
                        });
                } else {
                    // Text filter for title
                    var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();
                    $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                        .off('keyup change')
                        .on('keyup change', function(e) {
                            e.stopPropagation();
                            var val = $(this).val();
                            column.search(val, true, false).draw(true);
                        });
                }
                i = i + 1;
            });
        }
    });
</script>
<!-- Status toggle script -->
<script>
    // Handle status toggle via AJAX
    $(document).on('change', 'input.status-toggle', function() {
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var productId = checkbox.data('product-id');
        var newstatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newstatus ? 'Enabled' : 'Disabled';
        statusLabel.text(newStatusText);
        $('#loader').show();
        let data = {
            product_id: productId,
            status: newstatus
        };
        $.ajax({
            url: '<?php echo $ajaxupdateproductstatus; ?>',
            method: 'POST',
            data,
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    // Update row status in DataTable
                    var row = $('#product-table').DataTable().row(checkbox.closest('tr'));
                    var rowData = row.data();
                    rowData[2] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + productId + '" ' + (newstatus ? 'checked' : '') + ' data-product-id="' + productId + '"> <label class="custom-control-label" for="statusToggle' + productId + '">' + newStatusText + '</label> </div>';
                    row.data(rowData).draw(false);
                }
                console.log(response);
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating status:', error);
                // Revert checkbox and label on error
                checkbox.prop('checked', !checkbox.is(':checked'));
                statusLabel.text(checkbox.is(':checked') ? 'Enabled' : 'Disabled');
            }
        });
    });
</script>
<!-- Footer section -->
<?php echo $footer; ?> 