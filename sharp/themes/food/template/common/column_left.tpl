<?php if ($modules) { ?>
<div class="col-sm-3">
    <aside id="sidebar" class="admin-sidebar">
      <?php foreach ($modules as $module) { ?>
        <?php echo $module; ?>
      <?php } ?>
    </aside>
</div>
<?php } ?>