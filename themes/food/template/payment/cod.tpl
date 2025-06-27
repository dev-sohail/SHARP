<h2><?php echo $text_instruction; ?></h2>
<div class="well well-sm">
  <p><?php echo $codinstruction; ?></p>
</div>
<div class="buttons">
  <div class="pull-right">
    <input type="button" value="<?php echo $button_confirm; ?>" id="button-confirm" class="btn btn-primary" />
  </div>
</div>
<script type="text/javascript"><!--
$('#button-confirm').on('click', function() {
	$.ajax({
		type: 'get',
		url: 'index.php?route=payment/cod/confirm',
		cache: false,
		beforeSend: function() {
			$('#button-confirm').button('loading');
		},
		complete: function() {
			//$('#button-confirm').button('reset');
			location = '<?php echo $continue; ?>';
		},
		success: function() {
			location = '<?php echo $continue; ?>';
		}
	});
});
//--></script>
