"use strict";

var uploadPhoto = function () {

	const Tus = Uppy.Tus;
	const ProgressBar = Uppy.ProgressBar;
	const Informer = Uppy.Informer;
	const xhr = Uppy.XHRUpload;

	var initUppy = function(){
		var id = '#uploadPhoto';
		const table = $(id).data('table');
		const content_id = $(id).data('id');
		const url = $(id).data('url');

		console.log('id: ' + content_id);

		var uppyDrag = Uppy.Core({
			autoProceed: true,
			locale: Uppy.locales.tr_TR,
			restrictions: {
				maxFileSize: 5000000, // 5mb
				maxNumberOfFiles: 20,
				minNumberOfFiles: 1,
				allowedFileTypes: ['image/*', 'video/*'],
				showProgressDetails: true,
				note: 'Images and video only, 2–3 files, up to 1 MB',
			}
		});

		uppyDrag.use(Uppy.DragDrop, { target: id + ' .uppy-drag' });
		uppyDrag.use(ProgressBar, {
			target: id + ' .uppy-progress',
			hideUploadButton: false,
			hideAfterFinish: false
		});
		uppyDrag.use(Informer, { target: id + ' .uppy-informer'  });
		uppyDrag.use(xhr, { endpoint: url+'upload/set' });

		uppyDrag.on('complete', function(file) {
			var imagePreview = "";
			$.each(file.successful, function(index, value){
				var imageType = /image/;
				var thumbnail = "";
				if (imageType.test(value.type)){
					thumbnail = '<div class="uppy-thumbnail"><img src="'+value.uploadURL+'"/></div>';
				}
				var sizeLabel = "bytes";
				var filesize = value.size;
				if (filesize > 1024){
					filesize = filesize / 1024;
					sizeLabel = "kb";
					if(filesize > 1024){
						filesize = filesize / 1024;
						sizeLabel = "MB";
					}
				}
				console.log('value: ' +JSON.stringify(value));
				const fileName = value.name.split('.').slice(0, -1).join('.');
				const fileExtension = value.extension;

				// $.ajax({
				// 	type: 'post',
				// 	url : url+'upload/set/',
				// 	data: 'table='+table+'&id='+content_id,
				// 	success: function (response) {
				//
				// 	}
				// });

				imagePreview += '<div class="uppy-thumbnail-container" data-id="'+value.id+'">'+thumbnail+' <span class="uppy-thumbnail-label"><input type="text" class="form-control" value="'+fileName+'"><input type="hidden" class="form-control" value="'+fileExtension+'"></span><span data-id="'+value.id+'" class="uppy-remove-thumbnail"><i class="flaticon2-cancel-music"></i></span></div>';
			});

			$(id + ' .uppy-thumbnails').append(imagePreview);
		});

		$(document).on('click', id + ' .uppy-thumbnails .uppy-remove-thumbnail', function(){
			var imageId = $(this).attr('data-id');
			uppyDrag.removeFile(imageId);
			$(id + ' .uppy-thumbnail-container[data-id="'+imageId+'"').remove();
		});
	}

	return {
		init: function() {
			initUppy();
		}
	};
}();
