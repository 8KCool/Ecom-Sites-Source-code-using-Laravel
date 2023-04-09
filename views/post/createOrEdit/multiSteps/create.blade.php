@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	
		@if (!auth()->check())
		<?php
        echo "<script> location.href='https://paiaki.com/login'; </script>";
        exit;
        ?>
	     @endif
	
	@if (auth()->check())
	<div class="main-container">
		<div class="container">
			<div class="row">
				
				@includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'])

				<?php $postInput = $postInput ?? []; ?>
		
				<div class="col-md-9 page-content">
				    
			<div style="padding-top: 35px;" class="inner-box category-content">
						<div class="row">
							<div class="col-xl-12">
								<h2 class="title-2 text-center">
							Publicar anúncio</h2>
								<form class="form-horizontal" id="postForm" method="POST" action="{{ request()->fullUrl() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<fieldset>

										<!-- category_id -->
										<?php $categoryIdError = (isset($errors) && $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label{{ $categoryIdError }}">{{ t('category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div id="catsContainer" class="rounded">
													<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="0">
														{{ t('select_a_category') }}
													</a>
												</div>
											</div>
											<input type="hidden" name="category_id" id="categoryId" value="{{ old('category_id', data_get($postInput, 'category_id', 0)) }}">
											<input type="hidden" name="category_type" id="categoryType" value="{{ old('category_type', data_get($postInput, 'category_type')) }}">
										</div>
										
										@if (config('settings.single.show_post_types'))
											<!-- post_type_id -->
											@if (isset($postTypes))
												<?php $postTypeIdError = (isset($errors) && $errors->has('post_type_id')) ? ' is-invalid' : ''; ?>
												<div id="postTypeBloc" class="form-group row required">
													<label class="col-md-3 col-form-label">{{ t('type') }} <sup>*</sup></label>
													<div class="col-md-8">
														@foreach ($postTypes as $postType)
														<div class="form-check form-check-inline pt-2">
															<input name="post_type_id"
																id="postTypeId-{{ $postType->id }}"
																value="{{ $postType->id }}"
																type="radio"
																class="form-check-input{{ $postTypeIdError }}"
																{{ (old('post_type_id', data_get($postInput, 'post_type_id'))==$postType->id) ? ' checked="checked"' : '' }}
															>
															<label class="form-check-label" for="postTypeId-{{ $postType->id }}">
																{{ $postType->name }}
															</label>
														</div>
														@endforeach
														
													</div>
												</div>
											@endif
										@endif

										<!-- title -->
										<?php $titleError = (isset($errors) && $errors->has('title')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="title">{{ t('title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="Ex: iPhone 6s 64GB" class="form-control input-md{{ $titleError }}"
													   type="text" value="{{ old('title', data_get($postInput, 'title')) }}">
												<small id="" class="form-text text-muted">{{ t('a_great_title_needs_at_least_60_characters') }}</small>
											</div>
										</div>

										<!-- description -->
										<?php $descriptionError = (isset($errors) && $errors->has('description')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<?php
												$descriptionErrorLabel = '';
												$descriptionColClass = 'col-md-8';
												if (config('settings.single.wysiwyg_editor') != 'none') {
													$descriptionColClass = 'col-md-12';
													$descriptionErrorLabel = $descriptionError;
												}
											?>
											<label class="col-md-3 col-form-label{{ $descriptionErrorLabel }}" for="description">
												{{ t('Description') }} <sup>*</sup>
											</label>
											<div class="{{ $descriptionColClass }}">
												<textarea class="form-control{{ $descriptionError }}"
														  id="description"
														  name="description"
														  rows="15"
												>{{ old('description', data_get($postInput, 'description')) }}</textarea>
												<small id="" class="form-text text-muted">{{ t('describe_what_makes_your_ad_unique') }}...</small>
											</div>
										</div>
										
										<!-- cfContainer -->
										<div id="cfContainer"></div>

										<!-- price -->
										<?php $priceError = (isset($errors) && $errors->has('price')) ? ' is-invalid' : ''; ?>
										<div id="priceBloc" class="form-group row">
											<label class="col-md-3 col-form-label" for="price">{{ t('price') }}</label>
											<div class="col-md-8">
												<div class="input-group">
												
													<?php
													$price = \App\Helpers\Number::format(old('price', data_get($postInput, 'price')), 2, '.', '');
													?>
													<input id="price"
														   name="price"
														   class="form-control{{ $priceError }}"
														   placeholder="Ex: 10.500"
														   type="text"
														   min="0"
														   step="{{ getInputNumberStep((int)config('currency.decimal_places', 2)) }}"
														   value="{!! $price !!}"
													>
													
													<div class="input-group-append">
														<span class="input-group-text">
															<input id="negotiable" name="negotiable" type="checkbox"
																   value="1" {{ (old('negotiable', data_get($postInput, 'negotiable'))=='1') ? 'checked="checked"' : '' }}>&nbsp;
															<small>{{ t('negotiable') }}</small>
														</span>
													</div>
												</div>
												<small id="" class="form-text text-muted">{{ t('price_hint') }}</small>
											</div>
										</div>
										
										<!-- Entregas ao domicilio -->
										<?php $tagsError = (isset($errors) and $errors->has('tags')) ? ' is-invalid' : ''; ?>
										<div class="form-group row">
											<label class="col-md-3 col-form-label">Entregas ao domicílio</label>
											<div class="col-md-8">
			
												<div class="form-check form-check-inline pt-2"> <input name="tags"  value="Entregas" type="radio" > <label class="form-check-label" for="postTypeId-3">&nbsp;Sim</label> </div>
											</div>
										</div>
										
										<!-- country_code -->
										<?php $countryCodeError = (isset($errors) && $errors->has('country_code')) ? ' is-invalid' : ''; ?>
										@if (empty(config('country.code')))
											<div class="form-group row required">
												<label class="col-md-3 col-form-label{{ $countryCodeError }}" for="country_code">{{ t('your_country') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="countryCode" name="country_code" class="form-control sselecter{{ $countryCodeError }}">
														<option value="0" {{ (!old('country_code') || old('country_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('select_a_country') }}
														</option>
														@foreach ($countries as $item)
															<option value="{{ $item->get('code') }}" {{
																	(
																		old(
																			'country_code',
																			(!empty(config('ipCountry.code'))) ? config('ipCountry.code') : 0
																		) == $item->get('code')
																	)
																	? 'selected="selected"' : ''
																}}
															>
																{{ $item->get('name') }}
															</option>
														@endforeach
													</select>
												</div>
											</div>
										@else
											<input id="countryCode" name="country_code" type="hidden" value="{{ config('country.code') }}">
										@endif
										
										<?php
										/*
										@if (\Illuminate\Support\Facades\Schema::hasColumn('posts', 'address'))
										<!-- address -->
										<div class="form-group required <?php echo ($errors->has('address')) ? ' is-invalid' : ''; ?>">
											<label class="col-md-3 control-label" for="title">{{ t('Address') }} </label>
											<div class="col-md-8">
												<input id="address" name="address" placeholder="{{ t('Address') }}" class="form-control input-md"
													   type="text" value="{{ old('address') }}">
												<span class="help-block">{{ t('Fill an address to display on Google Maps') }} </span>
											</div>
										</div>
										@endif
										*/
										?>
										
										@if (config('country.admin_field_active') == 1 && in_array(config('country.admin_type'), ['1', '2']))
											<!-- admin_code -->
											<?php $adminCodeError = (isset($errors) && $errors->has('admin_code')) ? ' is-invalid' : ''; ?>
											<div id="locationBox" class="form-group row required">
												<label class="col-md-3 col-form-label{{ $adminCodeError }}" for="admin_code">{{ t('location') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="adminCode" name="admin_code" class="form-control sselecter{{ $adminCodeError }}">
														<option value="0" {{ (!old('admin_code') || old('admin_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('select_your_location') }}
														</option>
													</select>
												</div>
											</div>
										@endif
									
										<!-- city_id -->
										<?php $cityIdError = (isset($errors) && $errors->has('city_id')) ? ' is-invalid' : ''; ?>
										<div id="cityBox" class="form-group row required">
											<label class="col-md-3 col-form-label{{ $cityIdError }}" for="city_id">{{ t('city') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="cityId" name="city_id" class="form-control sselecter{{ $cityIdError }}">
													<option value="0" {{ (!old('city_id') || old('city_id')==0) ? 'selected="selected"' : '' }}>
														{{ t('select_a_city') }}
													</option>
												</select>
											</div>
										</div>
									
										<!-- is_permanent -->
										@if (config('settings.single.permanent_posts_enabled') == '3')
											<input type="hidden" name="is_permanent" id="isPermanent" value="0">
										@else
											<?php $isPermanentError = (isset($errors) && $errors->has('is_permanent')) ? ' is-invalid' : ''; ?>
											<div id="isPermanentBox" class="form-group row required hide">
												<label class="col-md-3 col-form-label"></label>
												<div class="col-md-8">
													<div class="form-check">
														<input name="is_permanent" id="isPermanent"
															   class="form-check-input mt-1{{ $isPermanentError }}"
															   value="1"
															   type="checkbox" {{ (old('is_permanent', data_get($postInput, 'is_permanent'))=='1') ? 'checked="checked"' : '' }}
														>
														<label class="form-check-label mt-0" for="is_permanent">
															{!! t('is_permanent_label') !!}
														</label>
													</div>
													<small id="" class="form-text text-muted">{{ t('is_permanent_hint') }}</small>
													<div style="clear:both"></div>
												</div>
											</div>
										@endif
										
										<!-- contact_name -->
										<?php $contactNameError = (isset($errors) && $errors->has('contact_name')) ? ' is-invalid' : ''; ?>
										@if (auth()->check())
											<input id="contact_name" name="contact_name" type="hidden" value="{{ auth()->user()->name }}">
										@else
											<div class="form-group row required">
												<label class="col-md-3 col-form-label" for="contact_name">Nome <sup>*</sup></label>
												<div class="col-md-8">
													<input id="contact_name"
														   name="contact_name"
														   placeholder="{{ t('your_name') }}"
														   class="form-control input-md{{ $contactNameError }}"
														   type="text"
														   value="{{ old('contact_name', data_get($postInput, 'contact_name')) }}"
													>
												</div>
											</div>
										@endif
										
										<?php
											if (auth()->check()) {
												$formPhone = (auth()->user()->country_code == config('country.code')) ? auth()->user()->phone : '';
											} else {
												$formPhone = data_get($postInput, 'phone');
											}
										?>
										<!-- phone -->
										<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="phone">{{ t('phone_number') }} <sup>*</sup>
												@if (!isEnabledField('email'))
													<sup>*</sup>
												@endif
											</label>
											<div class="input-group col-md-8">
												
												<input pattern="[0-9]*" inputmode="numeric" id="phone" name="phone"
													   placeholder="{{ t('phone_number') }}"
													   class="form-control input-md{{ $phoneError }}" type="number"
													   value="{{ phoneFormat(old('phone', $formPhone), old('country', config('country.code'))) }}"
												>

                                        <div class="input-group-append">
													<span class="input-group-text">
														<input name="phone_hidden" id="phoneHidden" type="checkbox"
															   value="1" {{ (old('phone_hidden', data_get($postInput, 'phone_hidden'))=='1') ? 'checked="checked"' : '' }}>&nbsp;
														<small>{{ t('Hide') }}</small>
													</span>
												</div>
												
											</div>
										</div>
										
										<!-- email -->
										<?php $emailError = (isset($errors) && $errors->has('email')) ? ' is-invalid' : ''; ?>
										<div style="display:none;" class="form-group row required">
											<label class="col-md-3 col-form-label" for="email">{{ t('email') }}
												@if (!isEnabledField('phone') || !auth()->check())
													<sup>*</sup>
												@endif
											</label>
											<div class="input-group col-md-8">
											
												<input id="email" name="email"
													   class="form-control{{ $emailError }}"
													   placeholder="{{ t('email') }}"
													   type="text"
													   value="{{ old(
																	'email',
																	(
																		(auth()->check() && isset(auth()->user()->email))
																		? auth()->user()->email
																		: data_get($postInput, 'email')
																	)
																) }}"
												>
											</div>
										</div>
										
										<!-- Button  -->
										<div class="form-group row pt-3">
											<div class="col-md-12 text-center">
												<button id="nextStepBtn" class="btn btn-primary btn-lg"> {{ t('Next') }} </button>
											</div>
										</div>

									</fieldset>
								</form>

							</div>
						</div>
					</div>
				</div>
				<!-- /.page-content -->

				<div class="col-md-3 reg-sidebar">
					@includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.right-sidebar', 'post.createOrEdit.inc.right-sidebar'])
				</div>
				
			</div>
		</div>
	</div>
@endif

	<style> ul.tagit li.tagit-choice {
    -webkit-border-radius: 0px;font-size: 14px;} ul.tagit input[type=text] {font-size: 14px;
    border: 1px solid #fff!important;
    color: black!important;}
	#catsContainer {
    border: 1px solid #f2f4f5;
    background-color: #f2f4f5;
    min-height: 38px;
    padding: .5rem .75rem;
    border-radius: 0px 0px 0px 0px!important;} 
    .select2-container--default .select2-selection--single {
    background: #f2f4f5!important;
    border: 1px solid #f2f4f5!important;}
    .select2-container--open .select2-dropdown--below {
    background: #f2f4f5!important;}
    .select2-container--default .select2-search--dropdown .select2-search__field {border: 1px solid #fff!important;} 
    input {border: 1px solid #f2f4f5!important;} .form-control {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .input-group-text {border-radius: 0px;background: #f2f4f5;border: 1px solid #f2f4f5;} 
input:checked {border: 5px solid #002f34!important;}
input[type="radio" i] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    border: 2px solid #999;
    transition: 0.2s all linear;
    margin-top: 2px;}
input[type="checkbox" i] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 30%;
    width: 16px;
    height: 16px;
    border: 2px solid #999;
    transition: 0.2s all linear;
    margin-top: 2px;}
input {border: 2px solid #002f34!important;}
.home-search {display:none!important;
</style>
	
	
	@includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.category-modal', 'post.createOrEdit.inc.category-modal'])
@endsection

@section('after_styles')
@endsection

@section('after_scripts')
@endsection

@includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.form-assets', 'post.createOrEdit.inc.form-assets'])
