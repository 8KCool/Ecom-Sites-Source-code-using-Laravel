@extends('layouts.master')
@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">
				<div class="col-md-12 page-content">
				    
					@include('flash::message')

					@if (isset($errors) and $errors->any())
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('oops_an_error_has_occurred') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
				
	<div id="avatarUploadError" class="center-block" style="width:100%; display:none"></div>
					<div id="avatarUploadSuccess" class="alert alert-success fade show" style="display:none;"></div>

					<div style="margin-bottom: 2px;padding-bottom: 30px;" class="ocultar-pc2 inner-box default-inner-box">
					     <span class="circle ocultar-circle"></span>
						<div class="row">
							<div class="col-md-5 col-sm-4 col-12">
								<div class="ima-foto">
								<img style="height: 75px;width: 75px;" id="userImg" class="userImg" src="{{ $user->photo_url }}" alt="user"></div>
	
								<span style="font-weight: 800!important;letter-spacing: -0.5px;font-size:20px;" >
										{{ $user->name }} @if($user->isOnline())<i style="color: #2ecc71!important;font-size: 11px;position: absolute;margin-top: 9px;margin-left: 6px;" title="Online" class="fa fa-circle online"></i>@endif</span></br>
										
										<span style="font-weight: 400!important;letter-spacing: -0.1px;" >
										Saldo disponível: {{ $wallet_amount }} KZ <i style="margin-left: 2px;font-size: 13px;color: #7f9799!important;" title="Este saldo é usado para publicar e destacar anúncios." class="fas fa-info-circle hidden-sm"></i> </span>
								<div class="botao-ad ocultar-pc"> <a href="https://paiaki.com/account/wallet/recharge">Carregar conta</a></div>
								
								<div class="botao-ad ocultar-pc"> <a href="https://paiaki.com/posts/create">Publicar anúncio</a></div>
							</div>
						</div>
					</div>
					
					<div style="margin-bottom: 2px;padding-bottom: 30px;" class="ocultar-phone1 inner-box default-inner-box">
						<div class="row">
							<div class="col-md-5 col-sm-4 col-12">
								<h3 class="no-padding text-center-480 useradmin">
									<span style="font-size: 24px!important;font-weight: 500!important;letter-spacing: -0.5px;" >
										<img style="height: 75px;width: 75px;" id="userImg" class="userImg" src="{{ $user->photo_url }}" alt="user">&nbsp; {{ $user->name }} @if($user->isOnline())<i style="color: #2ecc71!important;font-size: 10px;position: absolute;margin-top: 32px;margin-left: 6px;" title="Online" class="fa fa-circle online"></i>@endif</span>
								</h3>
								
							</div>
							
							<div class="col-md-7 col-sm-8 col-12">
								<div style="margin-top:4px!important;" class="ocultar-phone1 header-data text-center-xs">
									<div class="paybalance-box__inner">
            <div class="paybalance-box__balance">
                <div class="paybalance-box__credits-balance">
                    <span class="paybalance-box__balance-label ">
                        Saldo:
                        <span style="font-weight: 800;" class="js-balance-value-summary">{{ $wallet_amount }} KZ</span>  <i style="margin-left: 2px;font-size: 13px;color: #7f9799!important;" title="Este saldo é usado para publicar e destacar anúncios." class="hidden-sm fas fa-info-circle"></i>
                    </span>
                    <i class="paybalance-box__info-icon  js-paybalance-info-button" data-icon="circle_info_inverted">
                        <ul class="paybalance-box__dropdown js-paybalance-dropdown" style="display: none;">
    
                    	</ul>
                    </i>
                </div>
            </div>

                            <a style="margin-top:5px;" href="https://paiaki.com/account/wallet/recharge" class="botao-ad2">
                    <span>Carregar conta</span>
                </a>
                    </div>
								</div>
							</div>
							
						</div>
					</div>

                <div style="background: white;border-bottom: 24px solid #f2f4f5;margin-top: -25px;padding-bottom: 0px;" class="ocultar-phone1 inner-box">
					@includeFirst([config('larapen.core.customizedViewPath') . 'account.inc.sidebar', 'account.inc.sidebar'])
				</div>

                {{-- MENU --}}
					<div style="margin-top:10px;padding-bottom: 150px!important;background: #f2f4f5!important;" class="inner-box default-inner-box">

						<div id="accordion" class="panel-group">
					
							{{-- PHOTO --}}
							<div style="padding: 23px 23px 10px 24px !important;" class="card card-default">
									<span class="card-title">
										<a href="#photoPanel" data-toggle="collapse" data-parent="#accordion"><span class="titulo-menu"> Foto de perfil </span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a>
									</span>
								<?php
								$photoPanelClass = '';
								$photoPanelClass = request()->filled('panel')
									? (request()->get('panel') == 'photo' ? 'show' : $photoPanelClass)
									: ((old('panel')=='' || old('panel') =='photo') ? 'old' : $photoPanelClass);
								?>
								<div class="panel-collapse collapse {{ $photoPanelClass }}" id="photoPanel">
									<div class="card-body">
										<form name="details" class="form-horizontal" role="form" method="POST" action="{{ url('account/' . $user->id . '/photo') }}">
											<div class="row">
												<div class="col-xl-12 text-center">
													
													<?php $photoError = (isset($errors) and $errors->has('photo')) ? ' is-invalid' : ''; ?>
													<div class="photo-field">
														<div class="file-loading">
															<input id="photoField" name="photo" type="file" class="file {{ $photoError }}">
														</div>
													</div>
												
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							{{-- USER --}}
							<div style="padding: 23px 23px 10px 24px !important;"  class="card card-default">
									<span class="card-title">
										<a href="#userPanel" aria-expanded="true" data-toggle="collapse" data-parent="#accordion"><span class="titulo-menu"> Dados da conta </span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a>
									</span>
								
								<?php
								$userPanelClass = '';
								$userPanelClass = request()->filled('panel')
									? (request()->get('panel') == 'user' ? 'show' : $userPanelClass)
									: ((old('panel')=='' || old('panel')=='user') ? 'show' : $userPanelClass);
								?>
								<div class="panel-collapse collapse " id="userPanel">
									<div class="card-body">
										<form name="details"
											  class="form-horizontal"
											  role="form"
											  method="POST"
											  action="{{ url('account') }}"
											  enctype="multipart/form-data"
										>
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="user">

											{{-- gender_id --}}
											<?php $genderIdError = (isset($errors) && $errors->has('gender_id')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label">{{ t('gender') }}</label>
												<div class="col-md-9">
													@if ($genders->count() > 0)
                                                        @foreach ($genders as $gender)
															<div class="form-check form-check-inline pt-2">
																<input name="gender_id"
																	   id="gender_id-{{ $gender->id }}"
																	   value="{{ $gender->id }}"
																	   class="form-check-input{{ $genderIdError }}"
																	   type="radio" {{ (old('gender_id', $user->gender_id)==$gender->id) ? 'checked="checked"' : '' }}
																>
																<label class="form-check-label" for="gender_id-{{ $gender->id }}">
																	{{ $gender->name }}
																</label>
															</div>
                                                        @endforeach
													@endif
												</div>
											</div>
												
											{{-- name --}}
											<?php $nameError = (isset($errors) && $errors->has('name')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label">{{ t('Name') }} <sup>*</sup></label>
												<div class="col-md-9">
													<input name="name" type="text" class="form-control{{ $nameError }}" placeholder="" value="{{ old('name', $user->name) }}">
												</div>
											</div>
											
											{{-- username --}}
											<?php $usernameError = (isset($errors) && $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="email">{{ t('Username') }}</label>
												<div class="input-group col-md-9">
													
													<input id="username"
														   name="username"
														   type="text"
														   class="form-control{{ $usernameError }}"
														   placeholder="{{ t('Username') }}"
														   value="{{ old('username', $user->username) }}"
													>
												</div>
											</div>
												
											{{-- email --}}
											<?php $emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label">{{ t('email') }}
													@if (!isEnabledField('phone'))
														<sup>*</sup>
													@endif
												</label>
												<div class="input-group col-md-9">
													
													<input id="email"
														   name="email"
														   type="email"
														   class="form-control{{ $emailError }}"
														   placeholder="{{ t('email') }}"
														   value="{{ old('email', $user->email) }}"
													>
												</div>
											</div>
                                                
                                            {{-- country_code --}}
                                            <?php
                                            /*
                                            <?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-3 col-form-label{{ $countryCodeError }}" for="country_code">
                                            		{{ t('your_country') }} <sup>*</sup>
                                            	</label>
												<div class="col-md-9">
													<select name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('select_a_country') }}
														</option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{ (old('country_code', $user->country_code)==$item->get('code')) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
                                            */
                                            ?>
                                            <input name="country_code" type="hidden" value="{{ $user->country_code }}">
												
											{{-- phone --}}
											<?php $phoneError = (isset($errors) && $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label for="phone" class="col-md-3 col-form-label">{{ t('phone') }}
													@if (!isEnabledField('email'))
														<sup>*</sup>
													@endif
												</label>
												<div class="input-group col-md-9">

													<input id="phone" name="phone" type="text" class="form-control{{ $phoneError }}"
														   placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('phone_number') }}"
														   value="{{ phoneFormat(old('phone', $user->phone), old('country_code', $user->country_code)) }}">
														   
												</div>
											</div>

											<div class="form-group row">
												<div class="offset-md-3 col-md-9"></div>
											</div>
											
											{{-- button --}}
											<div class="form-group row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							
							{{-- SETTINGS --}}
							<div style="padding: 23px 23px 10px 24px !important;" class="card card-default">
									<span style="letter-spacing: -0.2px;" class="card-title"><a href="#settingsPanel" data-toggle="collapse" data-parent="#accordion"><span class="titulo-menu"> Definições de segurança </span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a></span>
								
								<?php
								$settingsPanelClass = '';
								$settingsPanelClass = request()->filled('panel')
									? (request()->get('panel') == 'settings' ? 'show' : $settingsPanelClass)
									: ((old('panel')=='settings') ? 'show' : $settingsPanelClass);
								?>
								<div class="panel-collapse collapse {{ $settingsPanelClass }}" id="settingsPanel">
									<div class="card-body">
										<form name="settings"
											  class="form-horizontal"
											  role="form"
											  method="POST"
											  action="{{ url('account/settings') }}"
											  enctype="multipart/form-data"
										>
											{!! csrf_field() !!}
											<input name="_method" type="hidden" value="PUT">
											<input name="panel" type="hidden" value="settings">
											
											<input name="gender_id" type="hidden" value="{{ $user->gender_id }}">
											<input name="name" type="hidden" value="{{ $user->name }}">
											<input name="phone" type="hidden" value="{{ $user->phone }}">
											<input name="email" type="hidden" value="{{ $user->email }}">
										
											{{-- password --}}
											<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="form-group row">
												<label class="col-md-3 col-form-label">{{ t('New Password') }}</label>
												<div class="col-md-9">
													<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}">
												</div>
											</div>
											
											{{-- password_confirmation --}}
											<?php $passwordError = (isset($errors) && $errors->has('password')) ? ' is-invalid' : ''; ?>
											<div class="form-group row">
												<label class="col-md-3 col-form-label">{{ t('Confirm Password') }}</label>
												<div class="col-md-9">
													<input id="password_confirmation" name="password_confirmation" type="password"
														   class="form-control{{ $passwordError }}" placeholder="{{ t('Confirm Password') }}">
												</div>
											</div>

											{{-- button --}}
											<div class="form-group row">
												<div class="offset-md-3 col-md-9">
													<button type="submit" class="btn btn-primary">{{ t('Update') }}</button>
												</div>
											</div>
										</form>
										</div>
									</div>
								</div>
							</div>
							
							<?php
								$estatisticas = '';
								$estatisticas = request()->filled('panel')
									? (request()->get('panel') == 'settings1' ? 'show' : $estatisticas)
									: ((old('panel')=='settings1') ? 'show' : $estatisticas);
								?>
							
							<div id="accordion" class="panel-group">
<div class="card card-default" style="margin-top: 10px; padding: 23px 23px 10px 24px !important;"><span class="card-title" style="letter-spacing: -0.2px;"><a class="collapsed" href="#estatisticas" data-toggle="collapse" data-parent="#accordion" aria-expanded="false"><span class="titulo-menu">Estatísticas gerais</span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a></span>
<div id="estatisticas" class="panel-collapse collapse">
<div class="card-body">
<p> Total de visualizações: <?php $totalPostsVisits = (isset($countPostsVisits) and $countPostsVisits->total_visits) ? $countPostsVisits->total_visits : 0 ?>
													{{ \App\Helpers\Number::short($totalPostsVisits) }} 
													</p>
<p> Total de mensagens: {{ isset($countThreads) ? \App\Helpers\Number::short($countThreads) : 0 }} </p>
<p> Total de anúncios publicados: {{ \App\Helpers\Number::short($countPosts) }}</p>
<p> Total de anúncios favoritos: {{ \App\Helpers\Number::short($countFavoritePosts) }}</p>
</div>
</div>
</div>
</div>
								
							<div style="margin-top: 10px;padding: 23px 23px 10px 24px !important;" class="card card-default">  <span class="card-title"> <a href="https://paiaki.com/page/regulamento"><span class="titulo-menu">Regulamentos</span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a></span> </div> 
							
							<div style="margin-top: 10px;padding: 23px 23px 10px 24px !important;" class="card card-default">  <span class="card-title"> <a href="https://paiaki.com/page/termos"><span class="titulo-menu">Termos e condições</span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a></span> </div> 
							
							<div style="margin-top: 10px;padding: 23px 23px 10px 24px !important;" class="card card-default">  <span class="card-title"> <a href="https://paiaki.com/contact"><span class="titulo-menu">Ajuda e contacto</span><i style="position: absolute!important;right: 20px!important;font-size: 25px!important;top: 25px!important;" class="icon-down-open-big fa"></i></a></span>  </div> 
						</div>
					</div>
				</div>
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->
@endsection

@section('after_styles')
	<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" rel="stylesheet">
	@if (config('lang.direction') == 'rtl')
		<link href="{{ url('assets/plugins/bootstrap-fileinput/css/fileinput-rtl.min.css') }}" rel="stylesheet">
	@endif
	
	<style>.list-inline {margin-bottom: -1px!important;} .user-panel-sidebar {background: #fff!important;} .row-featured-category {background: #ffffff!important;padding-left: 10px;} .user-panel-sidebar ul li a {background: #fff!important;}  @media screen and (min-width: 768px){.default-inner-box {padding: 27px!important;}} .card-header {
    padding: 0px;
    margin-bottom: 20px;
    padding-bottom: 10px!important;}
    
	.krajee-default.file-preview-frame:hover:not(.file-preview-error) {
			box-shadow: 0 0 5px 0 #666666;
		}
		.file-loading:before {
			content: " {{ t('Loading') }}...";
		}
	
	.hdata {
    width: 237px;
}
	
		/* Avatar Upload */
		.photo-field {
			display: inline-block;
			vertical-align: middle;
		}
		.photo-field .krajee-default.file-preview-frame,
		.photo-field .krajee-default.file-preview-frame:hover {
			margin: 0;
			padding: 0;
			border: none;
			box-shadow: none;
			text-align: center;
		}
		.photo-field .file-input {
			display: table-cell;
			width: 150px;
		}
		.photo-field .krajee-default.file-preview-frame .kv-file-content {
			width: 150px;
			height: 160px;
		}
		.kv-reqd {
			color: red;
			font-family: monospace;
			font-weight: normal;
		}
		
		.file-preview {
			padding: 2px;
		}
		.file-drop-zone {
			margin: 2px;
			min-height: 100px;
		}
		.file-drop-zone .file-preview-thumbnails {
			cursor: pointer;
		}
		
		.krajee-default.file-preview-frame .file-thumbnail-footer {
			height: 30px;
		}
		
		/* Allow clickable uploaded photos (Not possible) */
		.file-drop-zone {
			padding: 20px;
		}
		.file-drop-zone .kv-file-content {
			padding: 0
		}
		
		.hdata i {
    color: #002f34;
    font-size: 27px;
    box-shadow:none;
		}
		
		#catsContainer {
    border: 1px solid #f2f4f5;
    background-color: #f2f4f5;
    min-height: 38px;
    padding: .5rem .75rem;
    border-radius: 0px 0px 0px 0px!important;
} .select2-container--default .select2-selection--single {
    background: #f2f4f5!important;
    border: 1px solid #f2f4f5!important;}
    
    .select2-container--open .select2-dropdown--below {
    background: #f2f4f5!important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #fff!important;
} input {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .form-control {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .input-group-text {
    border-radius: 0px;
    background: #f2f4f5;
    border: 1px solid #f2f4f5;
     input {border: 1px solid #f2f4f5!important;} .form-control {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .input-group-text {border-radius: 0px;background: #f2f4f5;border: 1px solid #f2f4f5;} 
     
input:checked {border: 5px solid #002f34!important;}

input[type="radio"] {
    -webkit-appearance: none!important;
    -moz-appearance: none!important;
    appearance: none!important;
    border-radius: 50%!important;
    width: 16px!important;
    height: 16px!important;
    border: 2px solid #999!important;
    transition: 0.2s all linear!important;
    margin-top: 2px!important;}
    
input[type="checkbox"] {
    -webkit-appearance: none!important;
    -moz-appearance: none!important;
    appearance: none!important;
    border-radius: 30%!important;
    width: 16px!important;
    height: 16px!important;
    border: 2px solid #999!important;
    transition: 0.2s all linear!important;
    margin-top: 2px!important;}
    
	</style>
@endsection

@section('after_scripts')
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/plugins/sortable.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" type="text/javascript"></script>
	<script src="{{ url('assets/plugins/bootstrap-fileinput/themes/fas/theme.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/fileinput/locales/' . config('app.locale') . '.js') }}" type="text/javascript"></script>
	<script>
		var uploadExtraData = {
			_token:'{{ csrf_token() }}',
			_method:'PUT',
			name:'{{ $user->name }}',
			phone:'{{ $user->phone }}',
			email:'{{ $user->email }}'
		};
		var initialPreviewConfigExtra = uploadExtraData;
		initialPreviewConfigExtra.remove_photo = 1;
		
		var photoInfo = '<h6 class="text-muted pb-0">{{ t('Click to select') }}</h6>';
		var footerPreview = '<div class="file-thumbnail-footer pt-2">\n' +
			'    {actions}\n' +
			'</div>';
		
		$('#photoField').fileinput(
		{
			theme: 'fas',
			language: '{{ config('app.locale') }}',
			@if (config('lang.direction') == 'rtl')
				rtl: true,
			@endif
			overwriteInitial: true,
			showCaption: false,
			showPreview: true,
			allowedFileExtensions: {!! getUploadFileTypes('image', true) !!},
			uploadUrl: '{{ url('account/photo') }}',
			uploadExtraData: uploadExtraData,
			uploadAsync: false,
			showBrowse: false,
			showCancel: true,
			showUpload: false,
			showRemove: false,
			minFileSize: {{ (int)config('settings.upload.min_image_size', 0) }}, {{-- in KB --}}
			maxFileSize: {{ (int)config('settings.upload.max_image_size', 1000) }}, {{-- in KB --}}
			browseOnZoneClick: true,
			minFileCount: 0,
			maxFileCount: 1,
			validateInitialCount: true,
			uploadClass: 'btn btn-primary',
			defaultPreviewContent: '<img src="{{ !empty($gravatar) ? $gravatar : url('images/usuario.jpg') }}" alt="{{ t('Your Photo or Avatar') }}">' + photoInfo,
			/* Retrieve current images */
			/* Setup initial preview with data keys */
			initialPreview: [
				@if (isset($user->photo) && !empty($user->photo))
					'{{ imgUrl($user->photo, 'user') }}'
				@endif
			],
			initialPreviewAsData: true,
			initialPreviewFileType: 'image',
			/* Initial preview configuration */
			initialPreviewConfig: [
				{
					<?php
						// Get the file size
						try {
							$fileSize = (isset($disk) && $disk->exists($user->photo)) ? (int)$disk->size($user->photo) : 0;
						} catch (\Exception $e) {
							$fileSize = 0;
						}
					?>
					@if (isset($user->photo) && !empty($user->photo))
						caption: '{{ basename($user->photo) }}',
						size: {{ $fileSize }},
						url: '{{ url('account/photo/delete') }}',
						key: {{ (int)$user->id }},
						extra: initialPreviewConfigExtra
					@endif
				}
			],
			
			showClose: false,
			fileActionSettings: {
				showDrag: false, /* Show/hide move (rearrange) icon */
				removeIcon: '<i class="far fa-trash-alt"></i>',
				removeClass: 'btn btn-sm btn-danger',
				removeTitle: '{{ t('Remove file') }}'
			},
			
			elErrorContainer: '#avatarUploadError',
			msgErrorClass: 'alert alert-block alert-danger',
			
			layoutTemplates: {main2: '{preview} {remove} {browse}', footer: footerPreview}
		});
		
		/* Auto-upload added file */
		$('#photoField').on('filebatchselected', function(event, data, id, index) {
			$(this).fileinput('upload');
		});
		
		/* Show upload status message */
		$('#photoField').on('filebatchpreupload', function(event, data, id, index) {
			$('#avatarUploadSuccess').html('<ul></ul>').hide();
		});
		
		/* Show success upload message */
		$('#photoField').on('filebatchuploadsuccess', function(event, data, previewId, index) {
			/* Show uploads success messages */
			var out = '';
			$.each(data.files, function(key, file) {
				if (typeof file !== 'undefined') {
					var fname = file.name;
					out = out + {!! t('Uploaded file X successfully') !!};
				}
			});
			$('#avatarUploadSuccess ul').append(out);
			$('#avatarUploadSuccess').fadeIn('slow');
			
			$('#userImg').attr({'src':$('.photo-field .kv-file-content .file-preview-image').attr('src')});
		});
		
		/* Delete picture */
		$('#photoField').on('filepredelete', function(jqXHR) {
			var abort = true;
			if (confirm("{{ t('Are you sure you want to delete this picture') }}")) {
				abort = false;
			}
			return abort;
		});
		
		$('#photoField').on('filedeleted', function() {
			$('#userImg').attr({'src':'{!! !empty($gravatar) ? $gravatar : url('images/usuario.jpg') !!}'});
			
			var out = "{{ t('Your photo or avatar has been deleted') }}";
			$('#avatarUploadSuccess').html('<ul><li></li></ul>').hide();
			$('#avatarUploadSuccess ul li').append(out);
			$('#avatarUploadSuccess').fadeIn('slow');
		});
	</script>
@endsection
