
@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row clearfix">
				
				@if (isset($errors) and $errors->any())
					<div class="col-md-12">
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
					
				<div class="col-md-12">
				    
				    <div class="alert alert-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i style="font-size: 12px;" class="far fa-question-circle"></i>  O seu contributo é bastante importante para a nossa comunidade.</div>
				    
					<div class="contact-form">
						
						<h4 class="gray mt-0">
							<a style="font-weight: 800;" href="{{ \App\Helpers\UrlGen::post($post) }}">{{ $title }}</a>
						</h4>
						
						<hr class="mt-1">
						
						<form role="form" method="POST" action="{{ url('posts/' . $post->id . '/report') }}">
							{!! csrf_field() !!}
							<fieldset>
								<!-- report_type_id -->
								<?php $reportTypeIdError = (isset($errors) and $errors->has('report_type_id')) ? ' is-invalid' : ''; ?>
								<div class="form-group required">
									<label style="margin-bottom:5px;" for="report_type_id" class="control-label{{ $reportTypeIdError }}">{{ t('Reason') }} <sup>*</sup></label>
									<select id="reportTypeId" name="report_type_id" class="form-control selecter{{ $reportTypeIdError }}">
										<option value="">{{ t('Select a reason') }}</option>
										@foreach($reportTypes as $reportType)
											<option value="{{ $reportType->id }}" {{ (old('report_type_id', 0)==$reportType->id) ? 'selected="selected"' : '' }}>
												{{ $reportType->name }}
											</option>
										@endforeach
									</select>
								</div>
								
								<!-- email -->
								@if (auth()->check() and isset(auth()->user()->email))
									<input type="hidden" name="email" value="{{ auth()->user()->email }}">
								@else
									<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
									<div class="form-group required">
										<label style="margin-bottom:5px;" for="email" class="control-label">Email <sup>*</sup></label>
										<div class="input-group">
											<input id="email" name="email" type="text" maxlength="60" class="form-control{{ $emailError }}" value="{{ old('email') }}">
										</div>
									</div>
								@endif
							
								<!-- message -->
								<?php $messageError = (isset($errors) and $errors->has('message')) ? ' is-invalid' : ''; ?>
								<div class="form-group required">
									<label style="margin-bottom:5px;" for="message" class="control-label">Descrição <sup>*</sup> <span class="text-count"></span></label>
									<textarea id="message" name="message" class="form-control{{ $messageError }}" rows="10">{{ old('message') }}</textarea>
								</div>
							
								<input type="hidden" name="post_id" value="{{ $post->id }}">
								<input type="hidden" name="abuseForm" value="1">
								
								<div class="form-group">
								    <button type="submit" class="btn btn-primary">Denunciar</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				
			</div>
		</div>
	</div>
@endsection

<style>.home-search {display:none!important;}
#catsContainer {border: 1px solid #fff;background-color: #fff;min-height: 38px;padding: .5rem .75rem;border-radius: 0px 0px 0px 0px!important;} 
.select2-container--default .select2-selection--single {background: #fff!important;border: 1px solid #fff!important;}
.select2-container--open .select2-dropdown--below {background: #fff!important;}
.select2-container--default .select2-search--dropdown .select2-search__field {border: 1px solid #fff!important;} 
input {background-color:#fff!important; border: 1px solid #fff!important;} .form-control {background-color:#fff!important; border: 1px solid #fff!important;} 
.input-group-text {border-radius: 0px;background: #fff;border: 1px solid #fff;}</style>

@section('after_scripts')
	<script src="{{ url('assets/js/form-validation.js') }}"></script>
@endsection