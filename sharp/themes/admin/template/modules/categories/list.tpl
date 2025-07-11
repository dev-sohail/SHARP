<?php echo $header; ?>
<div class="main-panel">
    <div class="sec-head">
        <div class="sec-head-title">
            <h3>Categories </h3>
        </div>
        <div class="sec-head-btns">
            <a href="<?php echo $add; ?>" class="btn bts89067 btn890-890-890 opt"> + Add Category </a>
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
                            <table class="table table-striped table-bordered table-hover" id="sharp-table" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <thead>
                                    <tr>
                                        <th class="text-left">Title</th>
                                        <th class="text-left">Sort Order</th>
                                        <th class="text-left">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    <tr class="stdfilters">
                                    <th><input type="text" placeholder="Title"></th>
                                    <th><input type="text" placeholder="Sort Order"></th>
                                    <th id="case-study"></th>
                                    <th></th>
                                     </tr>
                                </thead>
                                <tbody>
                                    <?php if ($sc_categories) { ?>
                                    <?php foreach ($sc_categories as $sc_category) { ?>
                                    <tr class="stdfilters">
                                        <td class="text-left">
                                            <?php echo $sc_category['title']; ?>
                                        </td>
                                        <td class="text-left">
                                            <?php echo $sc_category['sort_order']; ?>
                                        </td>
                                        
                                        <td class="text-left">
                                            <?php echo ($sc_category['status']) ? ' Active ' : 'Inactive'; ?>
                                        </td>
                                        <td class="text-right">
                                            <a style="display: inline-block;" href="<?php echo $sc_category['edit']; ?>"
                                                data-toggle="tooltip" title="<?php echo $button_edit; ?>"
                                                class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                            <form style="display: inline-block;"
                                                action="<?php echo $sc_category['delete']; ?>" method="post"
                                                enctype="multipart/form-data"
                                                id="del_sc_category<?php echo $sc_category['category_id']; ?>">
                                                <input type="hidden" name="category_id"
                                                    value="<?php echo $sc_category['category_id']; ?>">
                                                <button type="button" data-toggle="tooltip"
                                                    title="<?php echo $button_delete; ?>" class="btn btn-danger"
                                                    onClick='submitDeleteForm("del_sc_category<?php echo $sc_category['category_id']; ?>")'><i class="fa fa-trash-o"></i></button>
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
      // $('#sharp-table thead tr').clone(true).addClass('stdfilters').appendTo('#sharp-table thead');
      var table = $('#sharp-table').DataTable({
         "language": {
            "emptyTable": "No record found."
        },
         // dom: 'Bfrtip',
         "pageLength": 10,
         "ordering": false,
         orderCellsTop: true,
         fixedHeader: true,
         buttons: false,
         scrollX: true,
         initComplete: function () {
            
            var api = this.api();
            var i = 1;
            api.columns().eq(0).each(function (colIdx) {
               var column = this;
               // alert(i);
               if (i == 3)
               {
                  var select = $('<select><option value="">Choose</option><option value=" Active ">Active</option><option value="Inactive">Inactive</option></select>')
                           .appendTo($('#case-study').empty())
                           .on('change', function() {
                              var val = $(this).val();

                              column.search(val, true, false)
                                 .draw(true);
                           });

                        
               }else{
                  var cell = $('.stdfilters th').eq($(api.column(colIdx).header()).index());
                  var title = $(cell).text();
                  // $(cell).html('<input type="text" placeholder="' + title + '" />');
   
                     $('input', $('.stdfilters th').eq($(api.column(colIdx).header()).index()))
                     .off('keyup change')
                     .on('keyup change', function (e) {
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
               i = i+1;



            });
         }
      });
</script>

<?php echo $footer; ?>
