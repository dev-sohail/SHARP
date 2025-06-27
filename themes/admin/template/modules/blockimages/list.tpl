<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Block Images</h3>
        </div>
        <div class="sec-head-btns" style="display: none;">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Block Image </a>
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
                            <table class="table table-striped table-bordered table-hover" id="food-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Unique Text</th>
                                        <th class="text-left" >Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                    <th><input type="text" placeholder="Title"></th>
                                    <th><input type="text" placeholder="Unique Text"></th>
                                    <th id="block-status"></th>
                                    <th></th>
                                     </tr>
                                </thead>
                                <tbody>
                                    <?php if ($blockimages) { ?>
                                    <?php foreach ($blockimages as $block) { ?>
                                    <tr class="stdfilters">
                                        <td class="text-left">
                                            <?php echo $block['title']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $block['unique_text']; ?>
                                        </td>
                                        <td class="text-left">
                                        <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input status-toggle" id="statusToggle<?php echo $block['block_id']; ?>" <?php echo ($block['publish']) ? 'checked' : ''; ?> data-status-id="<?php echo $block['block_id']; ?>">
                                                        <label class="custom-control-label" for="statusToggle<?php echo $block['block_id']; ?>">
                                                            <?php echo ($block['publish']) ? 'Active' : 'Inactive'; ?>
                                                        </label>
                                        </div>
                                        </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $block['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $block['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_team<?php echo $block['block_id']; ?>">
                                                <input type="hidden" name="block_id"
                                                    value="<?php echo $block['block_id']; ?>">
                                                <button style="display: none;" type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_team<?php echo $block['block_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
      // $('#food-table thead tr').clone(true).addClass('stdfilters').appendTo('#food-table thead');
      var table = $('#food-table').DataTable({
        "language": {
            "emptyTable": "No record found."
        },
         // dom: 'Bfrtip',
         "pageLength": 10,
         "ordering": false,
         scrollX: true,
         orderCellsTop: true,
         fixedHeader: true,
         buttons: false,
         initComplete: function () {
            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function (colIdx) {
               var column = this;
               // alert(i);
               if (i == 3)
               {
                  var select = $('<select><option value="">Choose</option><option value=" Active ">Active</option><option value="Inactive">Inactive</option></select>')
                           .appendTo($('#block-status').empty())
                           .on('change', function() {
                              var val = $(this).val();
                              column.search($.fn.dataTable.util.escapeRegex(val), true, false).draw(true);

                           });
               }else{
                  var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                  var title = $(cell).text();
                     $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                     .off('keyup change')
                     .on('keyup change', function (e) {
                        e.stopPropagation();
                        var val = $(this).val().trim();
                        column.search($.fn.dataTable.util.escapeRegex(val), true, false).draw(true);
                        var cursorPosition = this.selectionStart;
                        $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                     });
               }
               i = i+1;
            });
         }
      });
</script> 


<script>
    $(document).on('change', 'input[type="checkbox"]', function() {
        // $('.alert').remove();
        var checkbox = $(this);
        var statusLabel = checkbox.next('label');
        var blockId = checkbox.data('status-id');
        var newStatus = checkbox.is(':checked') ? 1 : 0;
        var newStatusText = newStatus ? 'Active ' : 'Inactive';
        statusLabel.text(newStatusText);
                // Show loader
                $('#loader').show();

        $.ajax({
            url: '<?php echo $ajaxBlockImagesStatusUpdate; ?>',
            method: 'POST',
            data: {
                id: blockId,
                status: newStatus
            },
            success: function(response) {
                $('#loader').hide();
                if (response.success) {
                    if (response.success) {

                        // $('.card').before(
                        //     '<div class="alert alert-success"><i class="fa fa-check-circle"></i>' +
                        //     'Status updated successfully.' +
                        //     '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                        //     '</div>'
                        // );
                        var row = $('#food-table').DataTable().row(checkbox.closest('tr'));
                        var rowData = row.data();
                        rowData[2] = '<div class="custom-control custom-switch"><input type="checkbox" class="custom-control-input status-toggle" id="statusToggle' + blockId + '" ' + (newStatus ? 'checked' : '') + ' data-status-id="' + blockId + '"> <label class="custom-control-label" for="statusToggle' + blockId + '"> ' + newStatusText + '</label> </div>';
                        row.data(rowData).draw(false);
                    }
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                $('#loader').hide();
                console.error('Error updating status:', error);
                checkbox.prop('checked', !checkbox.is(':checked'));
                statusLabel.text(checkbox.is(':checked') ? 'Active' : 'Inactive');
            }
        });
    });
</script>
<?php echo $footer; ?>