
@extends('layouts.master')

@section('wizard')
    @includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'])
@endsection

<?php
// The Next Step URL
$nextStepUrl = url($nextStepUrl);
$nextStepUrl = qsUrl($nextStepUrl, request()->only(['package']), null, false);
?>
@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
    <div class="main-container">
        <div class="container">
            <div class="row">
    
                @includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'])

                <div class="col-md-12 page-content">
                    <div style="padding-top: 35px;"  class="inner-box">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="title-2 text-center">Atualizar imagens</h2>
                                <form class="form-horizontal" id="postForm" method="POST" action="{{ request()->fullUrl() }}" enctype="multipart/form-data">
                                    {!! csrf_field() !!}
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <fieldset>
                                        @if (isset($picturesLimit) and is_numeric($picturesLimit) and $picturesLimit > 0)
											{{-- pictures --}}
											<?php $picturesError = (isset($errors) and $errors->has('pictures')) ? ' is-invalid' : ''; ?>
                                            <div id="picturesBloc" class="form-group row">
											
												<div class="col-md-8"></div>
												<div class="col-md-12 text-center pt-2" style="position: relative; float: {!! (config('lang.direction')=='rtl') ? 'left' : 'right' !!};">
													<div {!! (config('lang.direction')=='rtl') ? 'dir="rtl"' : '' !!} class="file-loading">
														<input id="pictureField" name="pictures[]" type="file" multiple class="file picimg{{ $picturesError }}">
													</div>
														
													<small style=" text-align: center!important; margin-top: 18px; " class="form-text text-muted control-label{{ $picturesError }}">
														{{ t('add_up_to_x_pictures_text', ['pictures_number' => $picturesLimit]) }}
													</small>
												</div>
                                            </div>
                                        @endif

										{{-- button --}}
                                        <div class="form-group row mt-4">
                                            <div class="col-md-12 text-center">
												<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-lg">{{ t('Previous') }}</a>
                                                <a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-lg">Concluir</a>
                                            </div>
                                        </div>
                                    	
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.page-content -->
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
    <style>
        .krajee-default.file-preview-frame:hover:not(.file-preview-error) {
            box-shadow: 0 0 5px 0 #666666;
        }
		.file-loading:before {
			content: " {{ t('Loading') }}...";
		}
		.home-search {display:none!important;}
		.fileinput-remove {display: none!important;}
    </style>
@endsection

@section('after_scripts')
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
    <script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/fileinput/locales/' . config('app.locale') . '.js') }}" type="text/javascript"></script>
    <script>
        /* Initialize with defaults (pictures) */
        @if (isset($post, $picturesLimit) && is_numeric($picturesLimit) && $picturesLimit > 0)
        <?php
            // Get Upload Url
			$uploadUrl = url('posts/' . $post->id . '/photos/');
            $uploadUrl = qsUrl($uploadUrl, request()->only(['package']), null, false);
        ?>
            $('#pictureField').fileinput(
            {
				theme: 'fas',
                language: '{{ config('app.locale') }}',
				@if (config('lang.direction') == 'rtl')
					rtl: true,
				@endif
                overwriteInitial: false,
                showCaption: false,
                showPreview: true,
                allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
				uploadUrl: '{{ $uploadUrl }}',
                uploadAsync: false,
				showBrowse: true,
				showCancel: true,
				showUpload: false,
				showRemove: false,
				minFileSize: {{ (int)config('settings.upload.min_image_size', 0) }}, {{-- in KB --}}
                maxFileSize: {{ (int)config('settings.upload.max_image_size', 1000) }}, {{-- in KB --}}
                browseOnZoneClick: true,
                minFileCount: 0,
                maxFileCount: {{ (int)$picturesLimit }},
                validateInitialCount: true,
				initialPreviewAsData: true,
				initialPreviewFileType: 'image',
                @if (isset($post->pictures))
					/* Retrieve current images */
					/* Setup initial preview with data keys */
					initialPreview: [
					@for($i = 0; $i <= $picturesLimit-1; $i++)
						@continue(!$post->pictures->has($i) || !isset($post->pictures->get($i)->filename))
						'{{ imgUrl($post->pictures->get($i)->filename, 'medium') }}',
					@endfor
					],
					/* Initial preview configuration */
					initialPreviewConfig: [
					@for($i = 0; $i <= $picturesLimit-1; $i++)
						@continue(!$post->pictures->has($i) || !isset($post->pictures->get($i)->filename))
						<?php
						// Get the file path
						$filePath = $post->pictures->get($i)->filename;
						
						// Get the file's deletion URL
						$initialPreviewConfigUrl = url('posts/' . $post->id . '/photos/' . $post->pictures->get($i)->id . '/delete');
						
						// Get the file size
						try {
							$fileSize = (isset($disk) && $disk->exists($filePath)) ? (int)$disk->size($filePath) : 0;
						} catch (\Exception $e) {
							$fileSize = 0;
						}
						?>
						{
							caption: '{{ basename($filePath) }}',
							size: {{ $fileSize }},
							url: '{{ $initialPreviewConfigUrl }}',
							key: {{ (int)$post->pictures->get($i)->id }}
						},
					@endfor
					],
                @endif
				/* Customize the previews footer */
				fileActionSettings: {
					showDrag: true, /* Show/hide move (rearrange) icon */
					showZoom: true, /* Show/hide zoom icon */
					removeIcon: '<i class="far fa-trash-alt" style="color: red;background-color: #FFF;"></i>',
					indicatorNew: '<i class="fas fa-check-circle" style="color: #09c509;font-size: 20px;margin-top: -15px;display: block;"></i>'
				},
				
                elErrorContainer: '#uploadError',
				msgErrorClass: 'alert alert-block alert-danger',
				
				uploadClass: 'btn btn-success'
            });
        @endif

		/* Auto-upload files */
		$('#pictureField').on('filebatchselected', function(event, files) {
			$(this).fileinput('upload');
		});
		
		/* Show upload status message */
        $('#pictureField').on('filebatchpreupload', function(event, data, id, index) {
            $('#uploadSuccess').html('<ul></ul>').hide();
        });
		
		/* Show success upload message */
        $('#pictureField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
            /* Show uploads success messages */
            var out = '';
            $.each(data.files, function(key, file) {
                if (typeof file !== 'undefined') {
                    var fname = file.name;
                    out = out + {!! t('Uploaded file X successfully') !!};
                }
            });
            $('#uploadSuccess ul').append(out);
            $('#uploadSuccess').fadeIn('slow');
            
            /* Change button label */
            $('#nextStepAction').html('{{ $nextStepLabel }}').removeClass('btn-default').addClass('btn-primary');
            
            /* Check redirect */
            var maxFiles = {{ (isset($picturesLimit)) ? (int)$picturesLimit : 1 }};
            var oldFiles = {{ (isset($post) and isset($post->pictures)) ? $post->pictures->count() : 0 }};
            var newFiles = Object.keys(data.files).length;
            var countFiles = oldFiles + newFiles;
            if (countFiles >= maxFiles) {
                var nextStepUrl = '{{ $nextStepUrl }}';
				redirect(nextStepUrl);
            }
        });
		
		/* Reorder (Sort) files */
		$('#pictureField').on('filesorted', function(event, params) {
			reorderPictures(params);
		});
		
		/* Before Picture Deletion */
        $('#pictureField').on('filepredelete', function(jqXHR) {
            var abort = true;
            if (confirm("{{ t('Are you sure you want to delete this picture') }}")) {
                abort = false;
            }
            return abort;
        });
		/* Picture Deleted */
		$('#pictureField').on('filedeleted', function(event, key, jqXHR, data) {
			/* Check local vars */
			if (typeof jqXHR.responseJSON === 'undefined') {
				return false;
			}
			
			let obj = jqXHR.responseJSON;
			if (typeof obj.status === 'undefined' || typeof obj.message === 'undefined') {
				return false;
			}
			
			let errorEl = $('#uploadError');
			let successEl = $('#uploadSuccess');
			
			/* Deletion Notification */
			if (parseInt(obj.status) === 1) {
				errorEl.hide().empty();
				errorEl.removeClass('alert alert-block alert-danger');
				
				successEl.html('<ul></ul>').hide();
				successEl.find('ul').append(obj.message);
				successEl.fadeIn('slow');
			} else {
				successEl.empty().hide();
				
				errorEl.html('<ul></ul>').hide();
				errorEl.addClass('alert alert-block alert-danger');
				errorEl.find('ul').append(obj.message);
				errorEl.fadeIn('slow');
			}
		});

		/**
		 * Reorder (Sort) pictures
		 * @param params
		 * @returns {boolean}
		 */
		function reorderPictures(params)
		{
			if (typeof params.stack === 'undefined') {
				return false;
			}
			
			waitingDialog.show('{{ t('Processing') }}...');
			
			let postId = '{{ request()->segment(2) }}';
			
			$.ajax({
				method: 'POST',
				url: siteUrl + '/posts/' + postId + '/photos/reorder',
				data: {
					'params': params,
					'_token': $('input[name=_token]').val()
				}
			}).done(function(data) {
				
				setTimeout(function() {
					waitingDialog.hide();
				}, 250);
				
				if (typeof data.status === 'undefined') {
					return false;
				}
				
				let errorEl = $('#uploadError');
				let successEl = $('#uploadSuccess');
				
				/* Reorder Notification */
				if (parseInt(data.status) === 1) {
					errorEl.hide().empty();
					errorEl.removeClass('alert alert-block alert-danger');
					
					successEl.html('<ul></ul>').hide();
					successEl.find('ul').append(data.message);
					successEl.fadeIn('slow');
				} else {
					successEl.empty().hide();
					
					errorEl.html('<ul></ul>').hide();
					errorEl.addClass('alert alert-block alert-danger');
					errorEl.find('ul').append(data.message);
					errorEl.fadeIn('slow');
				}
				
				return false;
			});
			
			return false;
		}
    </script>
    
@endsection
