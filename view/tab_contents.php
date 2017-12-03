<div class="tab-content">
	<div id="tab-upload-xml" class="tab-pane fade">
		<button id="button-import-to-database" type="button" class="btn btn-primary">Import into database</button>
		<button id="button-wipe-database" type="button" class="pull-right btn btn-danger">Wipe database</button>
		<?php require ('uploader_container.php'); ?>
	</div>
	<div id="tab-filter-list" class="tab-pane fade in active">
		<?php require ('filter.php'); ?>
		<?php require ('list.php'); ?>


	</div>
</div>