@if (isset($packages, $paymentMethods) && $packages->count() > 0 && $paymentMethods->count() > 0)
	<div class="container well pb-0">
		<?php $packageIdError = (isset($errors) && $errors->has('package_id')) ? ' is-invalid' : ''; ?>
			<div style="display: flex;flex-wrap: wrap;flex-direction: row;align-content: center;justify-content: center;" id="packagesTable" class="checkboxtable">
				@foreach ($packages as $package)
					<?php
					$packageStatus = '';
					$badge = '';
					if (isset($currentPackageId, $currentPackagePrice, $currentPaymentIsActive)) {
						// Prevent Package's Downgrading
						if ($currentPackagePrice > $package->price) {
							$packageStatus = 'disabled';
							$badge = ' <span class="badge badge-danger">' . t('Not available') . '</span>';
						} elseif ($currentPackagePrice == $package->price) {
							$badge = '';
						} else {
							if ($package->price > 250) {
								$badge = ' <span class="badge badge-success">' . t('Upgrade') . '</span>';
							}
						}
						if ($currentPackageId == $package->id) {
							$badge = ' <span class="badge badge-secondary">' . t('Current') . '</span>';
							if ($currentPaymentIsActive == 250) {
								$badge .= ' <span class="badge badge-warning"></span>';
							}
						}
					} else {
						if ($package->price > 250) {
							$badge = ' <span class="badge badge-success">' . t('Upgrade') . '</span>';
						}
					}
					?>
					
					<?php
							$boxClass = ($package->recommended == 1) ? ' ' : '';
							$boxHeaderClass = ($package->recommended == 1) ? 'bg-primary' : '';
							$boxBtnClass = ($package->recommended == 1) ? 'btn-primary' : ' ';
						?>

									<div class="pacotes bloco-cada {{ $boxClass }}">
										<div class="bloco-right">
										    <input style="margin-right:3px;" class="form-check-input package-selection{{ $packageIdError }}"
									   type="radio"
									   name="package_id"
									   id="packageId-{{ $package->id }}"
									   value="{{ $package->id }}"
									   data-name="{{ $package->name }}"
									   data-currencysymbol="{{ $package->currency->symbol }}"
									   data-currencyinleft="{{ $package->currency->in_left }}"
										{{ (old('package_id', isset($currentPackageId) ? $currentPackageId : 0)==$package->id) ? ' checked' : (($package->price==250) ? ' checked' : '') }} {{ $packageStatus }}
								>
								<label style="font-size:15px; font-weight: 400!important;" class="form-check-label mb-0{{ $packageIdError }}">
									{!! $package->name . $badge !!}
								</label></br>
								
								<label class="form-check-label mb-0{{ $packageIdError }}">
								<ul style="font-size:12px;" class="list list-border">
										@if (is_array($package->description_array) and count($package->description_array) > 0)
											@foreach($package->description_array as $option)
												<li><i style="font-size: 10px; color: #fe8c00;margin-right: 5px;" class="fas fa-check"></i> {!! $option !!}</li>
											@endforeach
										@else
											<li> *** </li>
										@endif
									</ul> </label>
								
								<p style="font-weight: 500;margin-top: 8px;"  id="price-{{ $package->id }}" class="mb-0">
								@if ($package->currency->in_left == 1)
									<span class="price-currency">{!! $package->currency->symbol !!}</span>
								@endif
								<span class="price-int">{{ $package->price }}</span>
								@if ($package->currency->in_left == 0)
									<span class="price-currency">{!! $package->currency->symbol !!}</span>
								@endif
							</p>
										    
						     </div>
						    </div>
		@endforeach
		</div>

		<div style="margin-top:10px;" class="form-group">
			<div class="text-center align-middle p-3">
						@includeFirst([
							config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods',
							'post.createOrEdit.inc.payment-methods'
						])
		    </div>
		</div>
	</div>
	
<style>
.border-color-primary {
   border: 1px solid #fe9009!important;
}
#packagesTable .badge {
    font-size: 73%;
}
input {
    border: 2px solid #002f34!important;
}
.badge-success {
    color: #ffffff!important;
    background-color: #fe9009!important;
} .list-border>li {
    border-top: 0px solid #ffffff!important;
    line-height: 23px;
    position: relative;
} label {
    display: contents;
} .form-check-input {
    position: relative;
    display: inline-block;
} .pacotes {
    display: inline-block;
    margin-right: 15px;
} .bloco-right {float: left;} .bloco-cada {min-width: 260px;margin-bottom: 10px;padding-left: 35px; padding-right: 35px; padding-top: 15px; padding-bottom: 14px;border-radius: 4px; background-position: top;border: 1px solid #ebeef2;} input:checked {
  border: 5px solid #002f34!important;
}

input[type="radio" i] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border-radius: 50%;
    width: 16px;
    height: 16px;
    border: 2px solid #999;
    transition: 0.2s all linear;
    top: 2px;
} </style>
	
	@includeFirst([
		config('larapen.core.customizedViewPath') . 'post.createOrEdit.inc.payment-methods.plugins',
		'post.createOrEdit.inc.payment-methods.plugins'
	])

@endif