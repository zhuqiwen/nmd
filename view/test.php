<!DOCTYPE html>
<html lang="en">
<head>
	<title>New Media Developer</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

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
		<?php require ('guide.php'); ?>
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

			school = '<a href=' + link + '>' + school + '</a>';
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
				console.log(response);
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
		console.log(data);
		$.ajax({
			type: 'GET',
			url: 'index.php?controller=test&action=search',
			dataType: 'json',
			data: data,
			success: function (response) {
				console.log(response);
				let table = makeTable(response);
				$('#div-list').html(table);

//				location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var e = window.open();
				e.document.write(xhr.responseText);

			}
		});
	}

	function makeTable(data_array) {
		var table = '<table class="table table-striped"> ' +
			'<thead> ' +
			'<tr> ' +
			'<th>' + '' + '</th> ' +
			'<th>' + 'Program' + '</th> ' +
			'<th>' + 'School' + '</th> ' +
			'<th>' + 'DELETE' + '</th> ' +
			'</tr> ' +
			'</thead> ' +
			'<tbody>';

		$.each(data_array, function (i, object) {
			let program = object.name;
			let school = object.school;
			let link = object.link;
			let id = object.id;

			program = '<a href=' + link + '>' + program + '</a>';
			let row = '<tr data-id=' + id + ' class="parent-row">';
			row += '<td class="col-md-1"></td>';
			row += '<td class="col-md-5">' + program + '</td>';
			row += '<td class="col-md-4">' + school + '</td>';
			row += '<td class="col-md-2">' + "<button type='button' class='btn btn-info btn-sm'>DELETE</button>" + '</td>';
			row += '</tr>';

			table += row;
		});

		table += '</tbody></table>';
		return table;
	}


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
		var id = $(this).data('id');

		var program = $.map(programs, function (item, key) {
			if(item.id == id)
			{
				return item;
			}
		});

		program = program[0];

		var key_array = ['name', 'link', 'bp', 'mp', 'dp', 'id'];
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
	})




</script>

</html>