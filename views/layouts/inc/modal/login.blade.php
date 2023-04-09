<div class="modal fade" id="quickLogin" tabindex="-1" role="dialog">
	<div class="modal-dialog  modal-sm">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 style="font-size: 24px; font-weight: 500!important;" class="modal-title"> {{ t('log_in') }} </h4>
				
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">{{ t('Close') }}</span>
				</button>
			</div>
			
			<form role="form" method="POST" action="{{ \App\Helpers\UrlGen::login() }}">
				{!! csrf_field() !!}
				<input type="hidden" name="language_code" value="{{ config('app.locale') }}">
				<div style="padding-top: 0px;" class="modal-body">

					@if (isset($errors) and $errors->any() and old('quickLoginForm')=='1')
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<ul class="list list-check">
								@foreach($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
					
					@if (
						config('settings.social_auth.social_login_activation')
						and (
							(config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
							or (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
							or (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
							or (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
							)
						)
						<div class="row mb-3 d-flex justify-content-center pl-2 pr-2">
							@if (config('settings.social_auth.facebook_client_id') and config('settings.social_auth.facebook_client_secret'))
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-fb">
									<a href="{{ url('auth/facebook') }}" class="btn-fb" title="{!! strip_tags(t('Login with Facebook')) !!}">
										<i class="icon-facebook-rect"></i> Entrar com Facebook
									</a>
								</div>
							</div>
							@endif
							@if (config('settings.social_auth.linkedin_client_id') and config('settings.social_auth.linkedin_client_secret'))
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-lkin">
									<a href="{{ url('auth/linkedin') }}" class="btn-lkin" title="{!! strip_tags(t('Login with LinkedIn')) !!}">
										<i class="icon-linkedin"></i> LinkedIn
									</a>
								</div>
							</div>
							@endif
							@if (config('settings.social_auth.twitter_client_id') and config('settings.social_auth.twitter_client_secret'))
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-tw">
									<a href="{{ url('auth/twitter') }}" class="btn-tw" title="{!! strip_tags(t('Login with Twitter')) !!}">
										<i class="icon-twitter-bird"></i> Twitter
									</a>
								</div>
							</div>
							@endif
							@if (config('settings.social_auth.google_client_id') and config('settings.social_auth.google_client_secret'))
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mb-1 pl-1 pr-1">
								<div class="col-xl-12 col-md-12 col-sm-12 col-12 btn btn-lg btn-danger">
									<a href="{{ url('auth/google') }}" class="btn-danger" title="{!! strip_tags(t('Login with Google')) !!}">
										<i class="icon-googleplus-rect"></i> Entrar com Google
									</a>
								</div>
							</div>
							@endif
						</div>
					@endif
					
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
						<label for="login" class="control-label">Email</label>
						<div class="input-group">
							<input style="background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;" id="mLogin" name="login" type="text" placeholder="{{ getLoginLabel() }}" class="form-control{{ $loginError }}" value="{{ $loginValue }}">
						</div>
					</div>
					
					<!-- password -->
					<?php $passwordError = (isset($errors) and $errors->has('password')) ? ' is-invalid' : ''; ?>
					<div class="form-group">
						<label for="password" class="control-label">Senha</label>
						<div class="input-group show-pwd-group">
							<input style="background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;" id="mPassword" name="password" type="password" class="form-control{{ $passwordError }}" placeholder="Senha" autocomplete="off">
							<span class="icon-append show-pwd">
								<button type="button" class="eyeOfPwd">
									<i class="far fa-eye-slash"></i>
								</button>
							</span>
						</div>
					</div>
					
					<!-- remember -->
					<?php $rememberError = (isset($errors) and $errors->has('remember')) ? ' is-invalid' : ''; ?>
					<div style="margin-bottom: 0px;" class="form-group">
						<label class="checkbox form-check-label pull-left mt-2" style="font-weight: normal;">
							<input type="checkbox" value="1" name="remember" id="mRemember" class="{{ $rememberError }}"> Lembrar
						</label>
						<p class="pull-right mt-2">
							<a href="{{ url('password/reset') }}">
								Recuperar senha
							</a>
						</p>
						<div style=" clear:both"></div>
					</div>

					<input type="hidden" name="quickLoginForm" value="1">
				</div>
				<div class="modal-footer">
				    <button type="submit" class="btn btn-primary pull-right">{{ t('log_in') }}</button>
					<a href="https://paiaki.com/register" class="btn btn-default">Criar conta</a>
				</div>
			</form>
			
		</div>
	</div>
</div>

