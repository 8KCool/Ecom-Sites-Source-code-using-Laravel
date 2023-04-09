
@extends('layouts.master')

@section('wizard')
	@includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'])
@endsection

<?php
// Category
if ($post->category) {
    if (empty($post->category->parent_id)) {
        $postCatParentId = $post->category->id;
    } else {
	    $postCatParentId = $post->category->parent_id;
	}
} else {
	$postCatParentId = 0;
}
?>
@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">

			<div class="row">
				
				@includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'])

				<div class="col-md-9 page-content">
					<div style="padding-top: 35px;" class="inner-box category-content">
						<div class="row">
							<div class="col-12">
								<h2 class="title-2 text-center">Editar anúncio</h2>
								<form class="form-horizontal" id="postForm" method="POST" action="{{ url()->current() }}" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<input name="_method" type="hidden" value="PUT">
									<input type="hidden" name="post_id" value="{{ $post->id }}">
									<fieldset>
										
										<!-- category_id -->
										<?php $categoryIdError = (isset($errors) and $errors->has('category_id')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label{{ $categoryIdError }}">{{ t('category') }} <sup>*</sup></label>
											<div class="col-md-8">
												<div id="catsContainer" class="rounded">
													<a href="#browseCategories" data-toggle="modal" class="cat-link" data-id="0">
														{{ t('select_a_category') }}
													</a>
												</div>
											</div>
											<input type="hidden" name="category_id" id="categoryId" value="{{ old('category_id', $post->category->id) }}">
											<input type="hidden" name="category_type" id="categoryType" value="{{ old('category_type', $post->category->type) }}">
										</div>
										
										@if (config('settings.single.show_post_types'))
											<!-- post_type_id -->
											@if (isset($postTypes))
												<?php $postTypeIdError = (isset($errors) and $errors->has('post_type_id')) ? ' is-invalid' : ''; ?>
												<div id="postTypeBloc" class="form-group row required">
													<label class="col-md-3 col-form-label">{{ t('type') }} <sup>*</sup></label>
													<div class="col-md-8">
														@foreach ($postTypes as $postType)
															<div class="form-check form-check-inline">
																<input name="post_type_id"
																	id="postTypeId-{{ $postType->id }}" value="{{ $postType->id }}"
																	type="radio"
																	class="form-check-input{{ $postTypeIdError }}"
																	{{ (old('post_type_id', $post->post_type_id)==$postType->id) ? ' checked="checked"' : '' }}
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
										<?php $titleError = (isset($errors) and $errors->has('title')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="title">{{ t('title') }} <sup>*</sup></label>
											<div class="col-md-8">
												<input id="title" name="title" placeholder="{{ t('ad_title') }}" class="form-control input-md{{ $titleError }}"
													   type="text" value="{{ old('title', $post->title) }}">
												<small id="" class="form-text text-muted">{{ t('a_great_title_needs_at_least_60_characters') }}</small>
											</div>
										</div>

										<!-- description -->
										<?php $descriptionError = (isset($errors) and $errors->has('description')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<?php
												$descriptionErrorLabel = '';
												$descriptionColClass = 'col-md-8';
												if (config('settings.single.wysiwyg_editor') != 'none') {
													$descriptionColClass = 'col-md-12';
													$descriptionErrorLabel = $descriptionError;
												} else {
													$post->description = strip_tags($post->description);
												}
											?>
											<label class="col-md-3 col-form-label{{ $descriptionErrorLabel }}" for="description">
												{{ t('Description') }} <sup>*</sup>
											</label>
											<div class="{{ $descriptionColClass }}">
												<textarea
														class="form-control{{ $descriptionError }}"
														id="description"
														name="description"
														rows="15"
												>{{ old('description', $post->description) }}</textarea>
												<small id="" class="form-text text-muted">{{ t('describe_what_makes_your_ad_unique') }}</small>
                                            </div>
										</div>
										
										<!-- cfContainer -->
										<div id="cfContainer"></div>

										<!-- price -->
										<?php $priceError = (isset($errors) and $errors->has('price')) ? ' is-invalid' : ''; ?>
										<div id="priceBloc" class="form-group row required">
											<label class="col-md-3 col-form-label" for="price">{{ t('price') }}</label>
											<div class="col-md-8">
												<div class="input-group">
													<?php
													$price = \App\Helpers\Number::format(old('price', $post->price), 2, '.', '');
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
																   value="1" {{ (old('negotiable', $post->negotiable)=='1') ? 'checked="checked"' : '' }}>
															&nbsp;<small>{{ t('negotiable') }}</small>
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
										<input id="countryCode" name="country_code" type="hidden" value="{{ !empty($post->country_code) ? $post->country_code : config('country.code') }}">
									
										@if (config('country.admin_field_active') == 1 and in_array(config('country.admin_type'), ['1', '2']))
											<!-- admin_code -->
											<?php $adminCodeError = (isset($errors) and $errors->has('admin_code')) ? ' is-invalid' : ''; ?>
											<div id="locationBox" class="form-group row required">
												<label class="col-md-3 col-form-label{{ $adminCodeError }}" for="admin_code">{{ t('location') }} <sup>*</sup></label>
												<div class="col-md-8">
													<select id="adminCode" name="admin_code" class="form-control sselecter{{ $adminCodeError }}">
														<option value="0" {{ (!old('admin_code') or old('admin_code')==0) ? 'selected="selected"' : '' }}>
															{{ t('select_your_location') }}
														</option>
													</select>
												</div>
											</div>
										@endif
									
										<!-- city_id -->
										<?php $cityIdError = (isset($errors) and $errors->has('city_id')) ? ' is-invalid' : ''; ?>
										<div id="cityBox" class="form-group row required">
											<label class="col-md-3 col-form-label{{ $cityIdError }}" for="city_id">{{ t('city') }} <sup>*</sup></label>
											<div class="col-md-8">
												<select id="cityId" name="city_id" class="form-control sselecter{{ $cityIdError }}">
													<option value="0" {{ (!old('city_id') or old('city_id')==0) ? 'selected="selected"' : '' }}>
														{{ t('select_a_city') }}
													</option>
												</select>
											</div>
										</div>
										
										<!-- is_permanent -->
										@if (config('settings.single.permanent_posts_enabled') == '3')
											<input type="hidden" name="is_permanent" id="isPermanent" value="{{ old('is_permanent', $post->is_permanent) }}">
										@else
											<?php $isPermanentError = (isset($errors) and $errors->has('is_permanent')) ? ' is-invalid' : ''; ?>
											<div id="isPermanentBox" class="form-group row required hide">
												<label class="col-md-3 col-form-label"></label>
												<div class="col-md-8">
													<div class="form-check">
														<input name="is_permanent" id="isPermanent"
															   class="form-check-input mt-1{{ $isPermanentError }}"
															   value="1"
															   type="checkbox" {{ (old('is_permanent', $post->is_permanent)=='1') ? 'checked="checked"' : '' }}
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

										<!-- phone -->
										<?php $phoneError = (isset($errors) and $errors->has('phone')) ? ' is-invalid' : ''; ?>
										<div class="form-group row required">
											<label class="col-md-3 col-form-label" for="phone">{{ t('phone_number') }} <sup>*</sup>
												@if (!isEnabledField('email'))
													<sup>*</sup>
												@endif
											</label>
											<div class="input-group col-md-8">
												<input id="phone" name="phone"
													   placeholder="{{ t('phone_number') }}" class="form-control input-md{{ $phoneError }}"
													   type="number" value="{{ phoneFormat(old('phone', $post->phone), $post->country_code) }}"
												>
											</div>
										</div>
										
										<!-- email -->
										<?php $emailError = (isset($errors) and $errors->has('email')) ? ' is-invalid' : ''; ?>
										<div style="display:none;" class="form-group row required">
											<label class="col-md-3 col-form-label" for="email">{{ t('email') }}
												@if (!isEnabledField('phone') or !auth()->check())
													<sup>*</sup>
												@endif
											</label>
											<div class="input-group col-md-8">
												<input id="email" name="email" class="form-control{{ $emailError }}"
													   placeholder="{{ t('email') }}" type="text"
													   value="{{ old('email', $post->email) }}">
											</div>
										</div>

										<!-- Button  -->
										<div class="form-group row pt-3">
											<div class="col-md-12 text-center">
												<a href="{{ \App\Helpers\UrlGen::post($post) }}" class="btn btn-default btn-lg"> {{ t('Back') }}</a>
												<button id="nextStepBtn" class="btn btn-primary btn-lg"> {{ t('Update') }} </button>
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
	
<style> ul.tagit li.tagit-choice {
    -webkit-border-radius: 0px;font-size: 14px;} ul.tagit input[type=text] {font-size: 14px;
    border: 1px solid #fff!important;
    color: black!important;} #catsContainer {
    border: 1px solid #f2f4f5;
    background-color: #f2f4f5;
    min-height: 38px;
    padding: .5rem .75rem;
    border-radius: 0px 0px 0px 0px!important;
} .select2-container--default .select2-selection--single {
    background: #f2f4f5!important;
    border: 1px solid #f2f4f5!important;}
    .select2-container--open .select2-dropdown--below {
    background: #f2f4f5!important;}
.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #fff!important;} input {border: 1px solid #f2f4f5!important;} .form-control {background-color:#f2f4f5!important; border: 1px solid #f2f4f5!important;} .input-group-text {
    border-radius: 0px;
    background: #f2f4f5;
    border: 1px solid #f2f4f5;} 
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
