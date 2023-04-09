
@extends('layouts.master')

@section('wizard')
    @includeFirst([config('larapen.core.customizedViewPath') . 'post.createOrEdit.multiSteps.inc.wizard', 'post.createOrEdit.multiSteps.inc.wizard'])
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<style>
		.paymnterror{
			color: red;
		}
	</style>
    <div class="main-container">
        <div class="container">
            
            <div class="row">
    
                @includeFirst([config('larapen.core.customizedViewPath') . 'post.inc.notification', 'post.inc.notification'])

                <div class="col-md-12 page-content">
                    
                    <div style="padding-top: 35px;" class="inner-box">
                        <div class="row">
                            <div class="col-sm-12">
                                <h2 class="title-2 text-center">
								@if (isset($selectedPackage) && !empty($selectedPackage))
									 Pacotes de anúncios
								@else
									 Pacotes de anúncios
								@endif
						</h2>
                                <form class="form" id="postForm" method="POST" action="{{ url()->current() }}">
                                    {!! csrf_field() !!}
                                    <fieldset>
										
										@if (isset($selectedPackage) && !empty($selectedPackage))
											<?php $currentPackagePrice = $selectedPackage->price; ?>
											@includeFirst([
												config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.packages.selected',
												'post.createOrEdit.inc.packages.selected'
											])
										@else
											@includeFirst([
												config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.packages',
												'post.createOrEdit.inc.packages'
											])
                                        @endif
											
                                        <!-- Button  -->
                                        <div class="form-group">
                                            <div class="col-md-12 text-center mt-4">
												<a href="{{ url('posts/create/photos') }}" class="btn btn-default btn-lg">
													{{ t('Previous') }}
												</a>
                                                <button id="submitPostForm" class="btn btn-primary btn-lg submitPostForm"> {{ t('Pay') }} </button>
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
@endsection

@section('after_scripts')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>
    @if (file_exists(public_path() . '/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js'))
        <script src="{{ url('/assets/plugins/forms/validation/localization/messages_'.config('app.locale').'.min.js') }}" type="text/javascript"></script>
    @endif

    <script>
        @if (isset($packages) && isset($paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0)
			
			var currentPackagePrice = {{ isset($currentPackagePrice) ? $currentPackagePrice : 0 }};
			var currentPaymentIsActive = {{ isset($currentPaymentIsActive) ? $currentPaymentIsActive : 0 }};
			var isCreationFormPage = true;
			$(document).ready(function ()
			{
				/* Show price & Payment Methods */
				var selectedPackage = $('input[name=package_id]:checked').val();
				var packagePrice = getPackagePrice(selectedPackage);
				var packageCurrencySymbol = $('input[name=package_id]:checked').data('currencysymbol');
				var packageCurrencyInLeft = $('input[name=package_id]:checked').data('currencyinleft');
				var paymentMethod = $('#paymentMethodId').find('option:selected').data('name');
				showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
				showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod, isCreationFormPage);
				
				/* Select a Package */
				$('.package-selection').click(function () {
					selectedPackage = $(this).val();
					packagePrice = getPackagePrice(selectedPackage);
					packageCurrencySymbol = $(this).data('currencysymbol');
					packageCurrencyInLeft = $(this).data('currencyinleft');
					showAmount(packagePrice, packageCurrencySymbol, packageCurrencyInLeft);
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod, isCreationFormPage);
				});
				
				/* Select a Payment Method */
				$('#paymentMethodId').on('change', function () {
					paymentMethod = $(this).find('option:selected').data('name');
					showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod, isCreationFormPage);
				});
				
				/* Form Default Submission */
				$('#submitPostForm').on('click', function (e) {
					e.preventDefault();
					
					/*if (packagePrice <= 0) {
						$('#postForm').submit();
					}*/
					$('#postForm').submit();
					return false;
				});
			});
        
        @endif

		/* Show or Hide the Payment Submit Button */
		/* NOTE: Prevent Package's Downgrading */
		/* Hide the 'Skip' button if Package price > 0 */
		function showPaymentSubmitButton(currentPackagePrice, packagePrice, currentPaymentIsActive, paymentMethod, isCreationFormPage = true)
		{	
			/* console.log("currentPackagePrice:- "+currentPackagePrice);
			console.log("packagePrice:- "+packagePrice);
			console.log("currentPaymentIsActive:- "+currentPaymentIsActive);
			console.log("paymentMethod:- "+paymentMethod);
			console.log("isCreationFormPage:- "+isCreationFormPage); */

			let submitBtn = $('#submitPostForm');
			let submitBtnLabel = {
				'pay': '{{ t('Pay') }}',
				'submit': '{{ t('submit') }}',
			};
			let skipBtn = $('#skipBtn');
			submitBtn.removeAttr("disabled");
			$(".paymnterror").empty();
			if (packagePrice > 0) {
				if(paymentMethod=="wallet"){
					submitBtn.attr("disabled","disabled");
					$.ajax({
						method: "POST",
						url: "{{ route('wallet.ajax_checkwallet_balance') }}",
						data: { check:"check",packagePrice:packagePrice }
					})
					.done(function( msg ) {
						var result= JSON.parse(msg);
						if(result.status=="error"){
							$(".paymnterror").html('<small>'+result.message+'</small>');
						} else if(result.status=="success"){
							submitBtn.removeAttr("disabled");
						}
					});

				} else {
					submitBtn.html(submitBtnLabel.pay).show();
					skipBtn.hide();
					
					if (currentPackagePrice > packagePrice) {
						submitBtn.hide().html(submitBtnLabel.submit);
					}
					if (currentPackagePrice == packagePrice) {
						if (paymentMethod == 'offlinepayment') {
							if (!isCreationFormPage && currentPaymentIsActive != 1) {
								submitBtn.hide().html(submitBtnLabel.submit);
								skipBtn.show();
							}
						}
					}
				}
			} else {
				skipBtn.show();
				submitBtn.html(submitBtnLabel.submit);
			}
		}
    </script>
@endsection

<style>.home-search {display:none!important;}</style>
