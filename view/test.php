<!DOCTYPE html>
<html lang="en">
<head>
	<title>New Media Developer</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	<style>
		.file-input-container
		{
			display: table;
			min-height: 300px;
			min-width: 100%;
		}
		.file-input-wrapper
		{
			display: table-cell;
			vertical-align: middle;
			text-align: center;
		}
	</style>
</head>
<body>

<div class="container">
	<div>
			<h1>New Media Developer Code Challenge One</h1>
	</div>

	<hr />

	<div class="row">
		<?php require ('left_column.php'); ?>
		<?php require ('contents.php'); ?>
	</div>

</div>

</body>

<script>

	var json_to_server = {};
	var programs = <?php echo json_encode($programs) ?>;

	$('#button-import-to-database').attr("disabled","disabled");

	function makePreviewTable(json_data) {
		var table = '<table class="table table-striped"> ' +
			'<thead> ' +
			'<tr> ' +
			'<th>' + 'Program' + '</th> ' +
			'<th>' + 'School' + '</th> ' +
			'<th>' + 'Bp' + '</th> ' +
			'<th>' + 'Mp' + '</th> ' +
			'<th>' + 'Dp' + '</th> ' +
			'</tr> ' +
			'</thead> ' +
			'<tbody>';

		var data = json_data.degree;
		$.each(data, function (i, object) {
			let program = object['@attributes'].name;
			let school = object['@attributes'].school;
			let bp = object['@attributes'].bp;
			let mp = object['@attributes'].mp;
			let dp = object['@attributes'].dp;
			let link = object['@attributes'].link;

			json_to_server[i] = {
				'name': program,
				'school': school,
				'bp': bp,
				'mp': mp,
				'dp': dp,
				'link': link
			};

			program = '<a href=' + link + '>' + program + '</a>';
			let row = '<tr>';
			row += '<td>' + program + '</td>';
			row += '<td>' + school + '</td>';
			row += '<td>' + bp + '</td>';
			row += '<td>' + mp + '</td>';
			row += '<td>' + dp + '</td></tr>';

			table += row;
		});

		table += '</tbody></table>';
		return table;
	}

	function parsDegreesXML(form_data) {
		$.ajax({
			type: 'POST',
			url: 'index.php?controller=test&action=handleFileUpload',
			dataType: 'json',
			data: form_data,
			processData: false,
			contentType: false,
			success: function (response) {
				var table = makePreviewTable(response);
				$('#uploader-container').html(table);
				$('#button-import-to-database').removeAttr('disabled');

			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);
			}
		});
	}

	function wipeDB() {
		$.ajax({
			type: 'GET',
			url: 'index.php?controller=test&action=wipe',
			dataType: 'text',
			data: {},
			success: function (response) {
				alert('wiped');
				location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);

			}
		});
	}

	function importIntoDB(json_data) {
		var data = {'degrees': JSON.stringify(json_data)};

		$.ajax({
			type: 'POST',
			url: 'index.php?controller=test&action=import',
			dataType: 'text',
			data: data,
			success: function (response) {
				$('#uploader-container').html(response);
				location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);
			}
		});
	}

	function updateProgram(data) {
		$.ajax({
			type: 'PUT',
			url: 'index.php?controller=test&action=update',
			dataType: 'json',
			data: data,
			success: function (response) {
				console.log(response);
				location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);

			}
		});
	}

	function search(data) {
		$.ajax({
			type: 'GET',
			url: 'index.php?controller=test&action=search',
			dataType: 'json',
			data: data,
			success: function (response) {
				programs = response;
				showTable(programs);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);

			}
		});
	}

	function makeTable(data) {
		var table = '<table class="table table-striped table-hover"> ' +
			'<thead> ' +
			'<tr> ' +
			'<th>' + '' + '</th> ' +
			'<th>' + 'Program' + '</th> ' +
			'<th>' + 'School' + '</th> ' +
			'<th>' + 'DELETE' + '</th> ' +
			'</tr> ' +
			'</thead> ' +
			'<tbody>';

		$.each(data, function (i, object) {
			let program = object.name;
			let school = object.school;
			let link = object.link;
			let id = object.id;

			program = '<a href=' + link + '>' + program + '</a>';
			let row = '<tr data-id=' + id + ' class="parent-row">';
			row += '<td class="col-md-1"></td>';
			row += '<td class="col-md-5">' + program + '</td>';
			row += '<td class="col-md-4">' + school + '</td>';
			row += '<td class="col-md-2">' + "<button id='button-delete' type='button' class='btn btn-info btn-sm'>DELETE</button>" + '</td>';
			row += '</tr>';
			table += row;
		});

		table += '</tbody></table>';
		return table;
	}

	function showTable(data) {
		let table = makeTable(data);
		$('#div-list').html(table);
	}

	function deleteOne(id) {
		$.ajax({
			url: 'index.php?controller=test&action=delete',
			type: 'DELETE',
			data: {id:id},
			contentType:'application/json',
			dataType: 'text',
			success: function(response) {
				console.log(response);
				toastr.success('Record Deleted', 'Miracle Max Says');
				location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);

			}
		});

	}


	$(document).ready(function () {
		showTable(programs);
	});

	$(document).on('click', '#button-wipe-database', function () {
		wipeDB();
	});

	$(document).on('click', '#button-import-to-database', function () {
		importIntoDB(json_to_server);
	});

	$(document).on('submit', '#form-xml-upload', function (e) {
		e.preventDefault();
		parsDegreesXML(new FormData($(this)[0]));
	});

	$(document).on('submit', '#form-edit', function (e) {
		e.preventDefault();
		updateProgram($(this).serialize());
		$('#modal-edit').modal('hide');

	});

	$(document).on('dblclick', '.parent-row', function () {
		let id = $(this).data('id');
		console.log(id);

		let program = $.map(programs, function (item, key) {
			if(item.id == id)
			{
				return item;
			}
		});

		program = program[0];
		let key_array = ['name', 'link', 'bp', 'mp', 'dp', 'id'];
		$.each(key_array, function (k, v) {
			let id = '#input-' + v;
			let val = program[v];
			$('#form-edit').find(id).val(val);
		});
		$('#form-edit').find('#select-school').val(program.school_id);
		$('#modal-edit').modal('show');

	});

	$(document).on('submit', '#form-search', function (e) {
		e.preventDefault();
		search($(this).serialize());
	});

	$(document).on('submit', '#form-delete', function (e) {
		e.preventDefault();
		let id = $(this).find('input[type="hidden"]').val();
		deleteOne(id);
	});

	$(document).on('change', '.filter-condition', function () {
		let form = $(this).parents('#form-filter'),
			school_id = form.find('#select_school').val(),
			academic_level = form.find('#select_academic_level').val();

		let filtered = programs.filter(function (item) {
			return (item[academic_level] != null) && (item.school_id == school_id);
		});

		showTable(filtered);
	});

	$(document).on('click', '#input_filter_reset', function (e) {
		e.preventDefault();
		location.reload();
	});

	$(document).on('click', '#button-delete', function () {
		let tr = $(this).closest('tr'),
			id = tr.data('id');

		let program = $.map(programs, function (item, key) {
			if(item.id == id)
			{
				return item;
			}
		});

		program = program[0];
		console.log(program);


		let key_array = ['name', 'link', 'bp', 'mp', 'dp', 'id'];
		$.each(key_array, function (k, v) {
			let id = '#input-' + v;
			let val = program[v];
			$('#form-delete').find(id).val(val);
		});
		$('#form-delete').find('#select-school').val(program.school_id);
		$('#modal-delete').modal('show');

	});

	$(document).on('change', '#input-xml-file-loader', function () {
		$('#input-xml-preview').removeAttr('disabled');
	})

</script>

</html>