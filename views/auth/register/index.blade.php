
@extends('layouts.master')

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div class="main-container">
		<div class="container">
			<div class="row">

				@if (isset($errors) and $errors->any())
					<div class="col-md-8 login-box">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><strong>{{ t('oops_an_error_has_occurred') }}</strong></h5>
							<ul class="list list-check">
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					</div>
				@endif

				@if (session()->has('flash_notification'))
					<div class="col-md-8 login-box">
						<div class="row">
							<div class="col-md-8 login-box">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif

				<div class="col-md-8 login-box page-content">
					<div class="inner-box">
						<h2 style="margin-top:20px!important;border-bottom: 0px solid #fff;margin-bottom: 0px;" class="title-2 text-center">
							{{ t('create_your_account_it_is_free') }}
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
											<a href="{{ lurl('auth/facebook') }}" class="btn-fb"><i class="icon-facebook-rect"></i> Registar com Facebook</a>
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
											<a style="color: #fff!important;" href="{{ lurl('auth/google') }}" class="btn-danger"><i class="icon-googleplus-rect"></i> Registar com Google</a>
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
						
						<div class="row mt-5">
							<div class="col-xl-12">
								<form id="signupForm" class="form-horizontal" method="POST" action="{{ url()->current() }}">
									{!! csrf_field() !!}
									<fieldset>

										<!-- name -->
										<?php $nameError = (isset($errors) and $errors->has('name')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label">Nome <sup>*</sup></label>
											<div class="col-md-6">
												<input name="name" placeholder="{{ t('Name') }}" class="form-control input-md{{ $nameError }}" type="text" value="{{ old('name') }}">
											</div>
										</div>

										<!-- country_code -->
										@if (empty(config('country.code')))
											<?php $countryCodeError = (isset($errors) and $errors->has('country_code')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label{{ $countryCodeError }}" for="country_code">{{ t('your_country') }} <sup>*</sup></label>
												<div class="col-md-6">
													<select id="countryCode" name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') or old('country_code')==0) ? 'selected="selected"' : '' }}>{{ t('Select') }}</option>
														@foreach ($countries as $code => $item)
															<option value="{{ $code }}" {{ (old('country_code', (!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0)==$code) ? 'selected="selected"' : '' }}>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
										@endif

										@if (isEnabledField('phone'))
											<!-- phone -->
											<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label">{{ t('phone') }}
													@if (!isEnabledField('email'))
														<sup>*</sup>
													@endif
												</label>
												<div class="col-md-6">
													<div class="input-group">
														<input name="phone"
															   placeholder="{{ (!isEnabledField('email')) ? t('Mobile Phone Number') : t('phone_number') }}"
															   class="form-control input-md{{ $phoneError }}"
															   type="text"
															   value="{{ phoneFormat(old('phone'), old('country', config('country.code'))) }}">
													</div>
												</div>
											</div>
										@endif
									
										@if (isEnabledField('email'))
											<!-- email -->
											<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email">{{ t('email') }}
													@if (!isEnabledField('phone'))
														<sup>*</sup>
													@endif
												</label>
												<div class="col-md-6">
													<div class="input-group">
													
														<input id="email"
															   name="email"
															   type="email"
															   class="form-control{{ $emailError }}"
															   placeholder="{{ t('email') }} válido"
															   value="{{ old('email') }}"
														>
													</div>
												</div>
											</div>
										@endif
									
										@if (isEnabledField('username'))
											<!-- username -->
											<?php $usernameError = (isset($errors) and $errors->has('username')) ? ' is-invalid' : ''; ?>
											<div class="form-group row required">
												<label class="col-md-4 col-form-label" for="email">{{ t('Username') }}</label>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="icon-user"></i></span>
														</div>
														<input id="username"
															   name="username"
															   type="text"
															   class="form-control{{ $usernameError }}"
															   placeholder="{{ t('Username') }}"
															   value="{{ old('username') }}"
														>
													</div>
												</div>
											</div>
										@endif
										
										<!-- password -->
										<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-4 col-form-label" for="password">{{ t('password') }} <sup>*</sup></label>
											<div class="col-md-6">
												<div class="input-group show-pwd-group">
													<input id="password" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="{{ t('password') }}" autocomplete="off">
													<span class="icon-append show-pwd">
														<button type="button" class="eyeOfPwd">
															<i class="far fa-eye-slash"></i>
														</button>
													</span>
												</div>
												<br>
												<input id="password_confirmation" name="password_confirmation" type="password" class="form-control{{ $passwordError }}"
													   placeholder="{{ t('Password Confirmation') }}" autocomplete="off">
												<small id="" class="form-text text-muted">
													{{ t('at_least_num_characters', ['num' => config('larapen.core.passwordLength.min', 6)]) }}
												</small>
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row">
											<label class="col-md-4 col-form-label"></label>
											<div class="col-md-6">
												<button id="signupBtn" class="btn btn-primary"> {{ t('register') }} </button>
											</div>
										</div>

										<div class="mb-5"></div>

									</fieldset>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<style>

.home-search {
    display:none!important;
}

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
		
	</style>

@section('after_scripts')
	<script>
		$(document).ready(function () {
			/* Submit Form */
			$("#signupBtn").click(function () {
				$("#signupForm").submit();
				return false;
			});
		});
	</script>
@endsection