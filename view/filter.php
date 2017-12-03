<div id="div-filter">
	<form id="form-filter">
		<div class="form-group col-md-5 col-sm-12">
			<label for="input_school">School</label>
			<select class="form-control filter-condition" id="select_school" name="school_id">
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
		<div class="form-group col-md-5 col-sm-12">
			<label for="input_academic_level">Academic Level</label>
			<select class="form-control filter-condition" id="select_academic_level" name="academic_level">
				<?php
				foreach ($academic_levels as $key => $level)
				{
					echo "<option value='$key'>$level</option>";
				}
				?>
			</select>
		</div>
		<div class="form-group col-md-2 col-sm-12 pull-right">
			<label for="input_filter_submit">&nbsp</label>
			<input type="reset" class="btn btn-default form-control" id="input_filter_reset" value="Reset" />
		</div>
	</form>
</div>