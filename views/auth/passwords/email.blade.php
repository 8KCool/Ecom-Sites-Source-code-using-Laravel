
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
				
				@if (session()->has('status'))
					<div class="col-xl-12">
						<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('status') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('email'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('email') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('phone'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('phone') }}</p>
						</div>
					</div>
				@endif
				
				@if (session()->has('login'))
					<div class="col-xl-12">
						<div class="alert alert-danger">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<p class="mb-0">{{ session('login') }}</p>
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

				<div class="col-lg-5 col-md-8 col-sm-10 col-12 login-box">
					<div class="card card-default">

						<h2 style="border-bottom: 0px solid #fff;margin-top: 20px;margin-bottom: 3px;" class="title-2 text-center">
							Recuperar senha
						</h2>
						
						<div class="card-body">
							<form id="pwdForm" role="form" method="POST" action="{{ url('password/email') }}">
								{!! csrf_field() !!}
								
								<!-- login -->
								<?php $loginError = (isset($errors) and $errors->has('login')) ? ' is-invalid' : ''; ?>
								<div class="form-group">
									<label for="login" class="col-form-label">Email</label>
									<div>
										<input id="login"
											   name="login"
											   type="text"
											   placeholder="Email registado"
											   class="form-control{{ $loginError }}"
											   value="{{ old('login') }}"
										>
									</div>
								</div>
								
								@includeFirst([config('larapen.core.customizedViewPath') . 'layouts.inc.tools.captcha', 'layouts.inc.tools.captcha'], ['noLabel' => true])
								
								<!-- Submit -->
								<div class="form-group">
									<button id="pwdBtn" type="submit" class="btn btn-primary">Recuperar</button>
									<a href="https://paiaki.com/register" class="btn btn-default">Criar conta</a>
								</div>
							</form>
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
			$("#pwdBtn").click(function () {
				$("#pwdForm").submit();
				return false;
			});
		});
	</script>
@endsection