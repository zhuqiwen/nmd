<div class="modal fade" id="modal-edit" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit</h4>
			</div>
			<div class="modal-body">
				<form id="form-edit" method="PUT">
					<input type="hidden" name="id" id="input-id">

					<div class="row">
						<div class="col-md-6">
							<div class="form-group col-md-12">
								<label for="name">Program</label>
								<input type="text" class="form-control" id="input-name" name="name">
							</div>
							<div class="form-group col-md-12">
								<label for="select-school">School</label>
								<select class="form-control" id="select-school" name="school_id">
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
								<input type="text" class="form-control" id="input-link" name="link">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group col-md-12">
								<label for="input-bp">Bachelor Degrees</label>
								<input type="text" class="form-control" id="input-bp" name="bp">
							</div>
							<div class="form-group col-md-12">
								<label for="input-mp">Master Degrees</label>
								<input type="text" class="form-control" id="input-mp" name="mp">
							</div>
							<div class="form-group col-md-12">
								<label for="input-dp">Phd</label>
								<input type="text" class="form-control" id="input-dp" name="dp">
							</div>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-default" form="form-edit">Update</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
			</div>
		</div>

	</div>
</div>
