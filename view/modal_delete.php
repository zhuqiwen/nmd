<div class="modal fade" id="modal-delete" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">DO YOU CONFIRM YOU WANT TO DELETE THIS RECORD?</h4>
			</div>
			<div class="modal-body">
				<form id="form-delete" method="DELETE">
					<input type="hidden" name="id" id="input-id">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-md-12">
								<label for="name">Program</label>
								<input type="text" class="form-control" id="input-name" name="name" disabled="disabled">
							</div>
							<div class="form-group col-md-12">
								<label for="select-school">School</label>
								<select class="form-control" id="select-school" name="school_id" disabled="disabled">
									<?php
									foreach ($schools as $school)
									{
										$id = $school['id'];
										$school_name = $school['school'];
										echo "<option value='$id'>$school_name</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group col-md-12">
								<label for="input-link">Link</label>
								<input type="text" class="form-control" id="input-link" name="link" disabled="disabled">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group col-md-12">
								<label for="input-bp">Bachelor Degrees</label>
								<input type="text" class="form-control" id="input-bp" name="bp" disabled="disabled">
							</div>
							<div class="form-group col-md-12">
								<label for="input-mp">Master Degrees</label>
								<input type="text" class="form-control" id="input-mp" name="mp" disabled="disabled">
							</div>
							<div class="form-group col-md-12">
								<label for="input-dp">Phd</label>
								<input type="text" class="form-control" id="input-dp" name="dp" disabled="disabled">
							</div>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default" form="form-delete">CONFIRM</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>

	</div>
</div>