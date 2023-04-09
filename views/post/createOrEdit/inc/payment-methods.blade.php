<?php $paymentMethodIdError = (isset($errors) and $errors->has('payment_method_id')) ? ' is-invalid' : ''; ?>

<div style="color: red;" class="paymnterror"></div>

<div style="display:none!important;" class="form-group row">
	<?php //echo "<pre>"; print_r($paymentMethods); echo "</pre>"; ?>
	
	<div style="display:none!important;" class="row col-md-3"> 
		<select style="display:none!important;" class="form-control selecter{{ $paymentMethodIdError }}" name="payment_method_id" id="paymentMethodId">
		    <option style="display:none!important;" value="6" data-name="wallet" {{ (old('payment_method_id', $currentPaymentMethodId)==6) ? 'selected="selected"' : '' }} selected>Carteira</option>
		</select>
	</div>
</div>

<style>
small {font-size: 13px!important;;}  
</style>