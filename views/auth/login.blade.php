
@extends('layouts.master')

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (isset($errors) and $errors->any())
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (session()->has('flash_notification'))
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<div class="col-lg-5 col-md-8 col-sm-10 col-12 login-box mt-3">
					<form id="loginForm" role="form" method="POST" action="{{ url()->current() }}">
						{!! csrf_field() !!}
						<input type="hidden" name="country" value="{{ config('country.code') }}">
						<div class="card card-default">
							
						<h2 style="border-bottom: 0px solid #fff;margin-top: 20px;margin-bottom: 3px;" class="title-2 text-center">
							{{ t('log_in') }}
						</h2>
	
							@if (
					config('settings.social_auth.social_login_activation')
					and (
						(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
						or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
						or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
						or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
						)
					)

							<div class="col-xl-12">
							<div class="row d-flex justify-content-center">
							<div class="col-xl-12">
								<div style="margin-bottom: 2px!important;" class="row mb-3 d-flex justify-content-center pl-3 pr-3">
									@if (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-fb">
											<a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i class="icon-facebook-rect"></i> Entrar com Facebook</a>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
								
						<div class="row d-flex justify-content-center">
							<div class="col-xl-12">
								<div class="row mb-3 d-flex justify-content-center pl-3 pr-3">
									@if (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-1 pl-1 pr-1">
										<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 btn btn-lg btn-danger">
											<a style="color: #fff!important;" href="{{ lurl('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i> Entrar com Google</a>
										</div>
									</div>
									@endif
								</div>
							</div>
						</div>
						</div>
						@endif
						
							<div class="row d-flex justify-content-center loginOr">
								<div class="col-xl-12 mb-1">
									<hr class="hrOr">
									<span class="spanOr rounded">ou</span>
								</div>
							</div>
						
							
							<div class="card-body">
								<?php
									$loginValue = (session()->has('login')) ? session('login') : old('login');
									$loginField = getLoginField($loginValue);
									if ($loginField == 'phone') {
										$loginValue = phoneFormat($loginValue, old('country', config('country.code')));
									}
								?>
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label">Email</label>
									<div class="input-group">
										<input id="login" name="login" type="text" placeholder="Email registado" class="form-control{{ $loginError }}" value="{{ $loginValue }}">
									</div>
								</div>
								
								<!-- password -->
								<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="password" class="col-form-label">{{ t('password') }}</label>
									<div class="input-group show-pwd-group">
										<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}" autocomplete="off">
										<span class="icon-append show-pwd">
											<button type="button" class="eyeOfPwd">
												<i class="far fa-eye-slash"></i>
											</button>
										</span>
									</div>
								</div>
								
								<!-- Submit -->
								<div class="form-group">
									<button id="loginBtn" class="btn btn-primary"> {{ t('log_in') }} </button>
									<a href="https://paiaki.com/register" class="btn btn-default">Criar conta</a>
								</div>
							</div>
							
							<div class="card-footer">
								<label class="checkbox pull-left mt-2 mb-2">
									<input type="checkbox" value="1" name="remember" id="remember">
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description"> {{ t('keep_me_logged_in') }}</span>
								</label>
								<div class="text-center pull-right mt-2 mb-2">
									<a href="{{ url('password/reset') }}"> {{ t('lost_your_password') }} </a>
								</div>
								<div style=" clear:both"></div>
							</div>
						</div>
					</form>

				</div>
				
			</div>
		</div>
	</div>
@endsection

<style>
.home-search {display:none!important;}
.select2-container--default .select2-selection--single {
    background: #f2f4f5!important;
    border: 1px solid #f2f4f5!important;}
    
    .select2-container--open .select2-dropdown--below {
    background: #f2f4f5!important;}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #fff!important;} input {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .form-control {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .input-group-text {
    border-radius: 0px;
    background: #f2f4f5;
    border: 1px solid #f2f4f5;
    
    input:checked {border: 5px solid #002f34!important;}
	</style>

@section('after_scripts')
	<script>
		$(document).ready(function () {
			$("#loginBtn").click(function () {
				$("#loginForm").submit();
				return false;
			});
		});
	</script>
@endsection
