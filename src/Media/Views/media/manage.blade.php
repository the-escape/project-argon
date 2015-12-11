@extends('argon::layout.master')

@section('content')
    <div class="main">
	<h1 class="page-header">Media</h1>

	@if (session('message'))
	    <div class="alert alert-success" role="alert">
		{{ session('message') }}
	    </div>
	@endif

	<button type="button" class="btn btn-primary btn-upload">Upload</button>

	<div class="media-library" style="position: relative;">
	    <div class="media-library-sidebar" style="position: absolute; width: 200px; left: 0; top: 0; bottom: 0; background: #ccc;">
		<div id="folders">
		    <ul>
			@each('argon::media.folder', $root->children, 'folder')
		    </ul>
		</div>
	    </div>
	    <form class="dz" style="border: 1px dashed red; margin-left: 200px; min-height: 100px;">
		<input type="hidden" name="current-folder" id="current-folder" value="1">
		<div class="files">

		</div>
	    </form>
	</div>
    </div>

    <div style="display: none;" id="preview-template">
	<div class="media-item">
	    <img class="thumb" data-dz-thumbnail>
	    <span class="filename" data-dz-name></span>
	    <span class="filesize" data-dz-size></span>

	    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
	    <progress class="progress" value="25" max="100"></progress>
	    <div class="btn-group">
		<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    &hellip;
		</button>
		<div class="dropdown-menu">
		    <a class="dropdown-item" href="#">Delete</a>
		    <a class="dropdown-item" href="#">Edit</a>
		</div>
	    </div>
	</div>
    </div>
@stop

@section('styles')
    <link rel="stylesheet" href="/argon/js/jstree/style.min.css" />
@stop

@section('footer')
    <script src="/argon/js/dropzone.min.js"></script>
    <script>
	var dropzone = new Dropzone(
	    'form.dz',
	    {
		url: '/admin/media/upload',
		clickable: '.btn-upload',
		headers: {
		    "X-CSRF-TOKEN": "{{ csrf_token() }}"
		},
		thumbnailWidth: 100,
		thumbnailHeight: 100,
		previewTemplate: $('#preview-template').html(),
		previewsContainer: '.media-library .files',
	    }
	);
	dropzone.on('success', function(e, response) {
	    loadItems($('#current-folder').val());
	});

	dropzone.on('error', function(file, errorMessage, xhr) {
	    console.log(errorMessage);
	});

	dropzone.on('uploadprogress', function(file, progress, bytesSent) {
	    $('progress', file.previewElement).val(progress);

	    if (progress == 100) {
		$('progress', file.previewElement).hide();
	    }
	});

	dropzone.on('addedfile', function(file) {
	    console.log(file);
	    sortItems();
	});
    </script>

    <script src="/argon/js/jstree.min.js"></script>
    <script>
	$('#folders').jstree({
	    plugins: [
		'dnd',
		'search'
	    ],
	    "core" : {
		// so that create works
		"check_callback" : true,
		"multiple": false
	    }
	});

	$('#folders').on("changed.jstree", function (e, data) {
	    if (data.selected) {
		var id = data.selected[0].split('-')[1];

		loadItems(id);
	    }
	});

	function loadItems(id) {
	    $.ajax(
		'media/items',
		{
		    data: {
			folderId: id
		    }
		}
	    ).done(function(data) {
		$('#current-folder').val(id);

		$('form.dz .files').empty();

		for (var i in data) {
		    var file = data[i];
		    console.log(file);

		    var node = $('#preview-template .media-item').clone();

		    node.find('img').attr('src', "http://placehold.it/100x100");
		    node.find('[data-dz-name]').text(file.filename);
		    node.find('[data-dz-size]').html(filesize(file.filesize));
		    node.find('progress').hide();

		    $('form.dz .files').append(node);
		}

		sortItems();
	    });
	}

	loadItems(1);

	function sortItems() {
	    var list = $('.files .media-item').get();
	    list.sort(compareItems);
	    for (var i = 0; i < list.length; i++) {
		list[i].parentNode.appendChild(list[i]);
	    }
	}

	function compareItems(a, b) {
	    var nameA = $(a).find('.filename').text(),
		nameB = $(b).find('.filename').text();
	    return nameA.localeCompare(nameB);
	}

	function filesize(size) {
	    var cutoff, i, selectedSize, selectedUnit, unit, units, _i, _len;
	    selectedSize = 0;
	    selectedUnit = "b";
	    if (size > 0) {
		units = ['TB', 'GB', 'MB', 'KB', 'b'];
		for (i = _i = 0, _len = units.length; _i < _len; i = ++_i) {
		    unit = units[i];
		    cutoff = Math.pow(1000, 4 - i) / 10;
		    if (size >= cutoff) {
			selectedSize = size / Math.pow(1000, 4 - i);
			selectedUnit = unit;
			break;
		    }
		}
		selectedSize = Math.round(10 * selectedSize) / 10;
	    }
	    return "<strong>" + selectedSize + "</strong>" + selectedUnit;
	};
    </script>
@stop
