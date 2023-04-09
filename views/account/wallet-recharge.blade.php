@extends('layouts.master')
@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])

	<?php date_default_timezone_set("Africa/Luanda"); ?>
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/google-libphonenumber@3.2.17/dist/libphonenumber.js" integrity="sha256-y7g6xQm+MB2sFTvdhBwEMDWg9sAUz9msCc2973e0wjg=" crossorigin="anonymous"></script>
	<div class="main-container">
		<div class="container">
			<div class="row">

				<div class="col-md-12 page-content">
				     <div style="clear:both"></div>
				     @if ($errors->any())
							<div class="alert alert-danger">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<div id="error-message"></div>
						@if ($message = Session::get('success_message'))
							<div class="alert alert-success">
								<span>Confirme o pagamento no seu Multicaixa Express dentro de 60 segundos.</span>
							</div>
						@endif
							
				 <div class="alert alert-warning"> <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><i style="font-size: 12px;" class="far fa-question-circle"></i> Carregue a sua conta do Paiaki de forma automática e segura.</div> 
					
				<div id="alert-pay-alert-scope">
				    </div>
			    <div id="alert-pay-alert" class="alert alert-success" style="display: none;">
			        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<ul>
						<li id="alert-pay-msg"></li>
					</ul>
				</div>
		
		<div style="background: #f2f4f5!important;" class="inner-box">
						<h2 style="display:none;" class="title-2">Carregar conta</h2>
						<div style="clear:both"></div>

						<form class="form-horizontal" id="walletForm" method="POST" action="{{ request()->fullUrl() }}" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            
                            <input id="block-two-request" type="hidden" value="0">
                             <?php $amountError = (isset($errors) && $errors->has('amount')) ? ' is-invalid' : ''; ?>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="amount"> Montantes <sup>*</sup></label>
                                <div style="display: flex;flex-wrap: wrap;" class="col-md-7">
                                        <div class="pacotes bloco-cada2"> <div class="bloco-right"> <input checked style="margin-right:3px;" class="form-check-input package-selection" type="radio" name="amount" id="amount" value="2000" data-name="amount" data-kzprice="2000.00"> <label style="font-weight: 400!important;" for="amount" class="mb-0" >2.000 KZ <span style="font-weight: 400!important;margin-left: 10px;color: #bababa;">4 €</span></label></div> </div>
              
										<div class="pacotes bloco-cada2"> <div class="bloco-right"> <input style="margin-right:3px;" class="form-check-input package-selection" type="radio" name="amount" id="amount" value="5000" data-name="amount" data-kzprice="5000.00"> <label style="font-weight: 400!important;" for="amount" class="mb-0" >5.000 KZ <span style="font-weight: 400!important;margin-left: 10px;color: #bababa;">10 €</span></label></div></div>
										
										<div class="pacotes bloco-cada2"> <div class="bloco-right"><input style="margin-right:3px;" class="form-check-input package-selection" type="radio" name="amount" id="amount" value="10000" data-name="amount" data-kzprice="10000.00"> <label style="font-weight: 400!important;" for="amount" class="mb-0">10.000 KZ <span style="font-weight: 400!important;margin-left: 10px;color: #bababa;">20 €</span></label></div></div>
											
										<div class="pacotes bloco-cada2"> <div class="bloco-right"><input style="margin-right:3px;" class="form-check-input package-selection" type="radio" name="amount" id="amount" value="20000" data-name="amount" data-kzprice="20000.00"> <label style="font-weight: 400!important;" for="amount" class="mb-0">20.000 KZ <span style="font-weight: 400!important;margin-left: 10px;color: #bababa;">40 €</span></label></div></div>
										
										<div class="pacotes bloco-cada2"> <div class="bloco-right"><input style="margin-right:3px;" class="form-check-input package-selection" type="radio" name="amount" id="amount" value="50000" data-name="amount" data-kzprice="50000.00"> <label style="font-weight: 400!important;" for="amount" class="mb-0">50.000 KZ <span style="font-weight: 400!important;margin-left: 10px;color: #bababa;">100 €</span></label></div></div>
		
                                </div>
                            </div>
                            
                            <?php $payment_methodError = (isset($errors) && $errors->has('payment_method')) ? ' is-invalid' : ''; ?>
                            <div style="margin-bottom: 4px;" class="form-group row required">
                                <label class="col-md-3 col-form-label" for="payment_method">Métodos de pagamento<sup>*</sup></label>
                                <div style="flex-direction: row;flex-wrap: wrap;display: flex;" class="col-md-7">

                                     <div class="pacotes bloco-cada3" style="padding-right: 38px;"> 
                                     	<div class="bloco-right" style="width: 100%; ">
                                     	    <input id="radio_appypay" style="margin-right:3px; margin-top: 7px;" name="payment_method" class="form-check-input {{ $payment_methodError }}" type="radio" value="appypay">
                                     	    <img style="padding-top: 4px;width: 90px;" class="text-center" src="/images/mcx-logo.svg">
                                        </div>
                                        
										<div class=" d-flex justify-content-end pr-2"  role="status">
											<span class="loader" style="display:none;"></span>
										</div>

                                     	<div id="is_appypay_wrap" style="display: none;">
                                     		<div id="state" class="wg-card">
								                <div class="wg-notice">
								                    <label class="mb-0">Multicaixa Express</label>
								                    <p class="number-notice" style="font-size: 12px;color: #7fa4a6;">O número deve estar registado no Multicaixa Express</p>
								                </div>

								                <div class="input-container">
								                    <input style=" background-color: #f2f4f5!important; border: 1px solid #f2f4f5!important; " value="" class="form-control float" id="appypay-phone"  name="telephone" type="text" placeholder="Digite o número de telemóvel" maxlength="9"> 
								                </div>
								            </div>
                                     	</div>

                                 	</div>
                                </div>
                            </div>
                            <div class="form-group row required">
                                <label class="col-md-3 col-form-label" for="payment_method"></label>
                                <div style="flex-direction: row;flex-wrap: wrap;display: flex;" class="col-md-7">
                                     <div class="pacotes bloco-cada3" style="padding-right: 38px;"> 
                                     	<div class="bloco-right" style="width: 100%; ">
                                     	    <input id="radio_paypal" style="margin-right:3px; margin-top: 4px;" name="payment_method" class="form-check-input {{ $payment_methodError }}" type="radio" value="paypal">
                                     	    <img style="width: 75px;" class="text-center" src="https://paiaki.com/public/images/paypal.svg">
                                        </div>
                                 	</div>
                                </div>
                            </div>
                           
							<div style="margin-top: 20px;" class="form-group row">
							 <label class="col-md-3 col-form-label" for="receipt"></label>
							<div class="col-md-8">
								<!--<input type="submit" name="upload" id="uploadReceipt" class="btn btn-primary" value="Pagar"/>-->
								<input style="background-color: #002f34! important; border-color: #002f34!important; color: white!important;" type="button" id="btn-appypay" class="btn btn-primary" value="Pagar"/>
								<input type="hidden" name="hiddenkzprice" value="2000.00">
							</div>
							</div>
                        </form>
						
						<p class="text-center" style="font-size: 11px; margin-top: 80px;">Todos os pagamentos são processados pela ANGOVITECH <img style="width: 8px;" src="/images/mcx-lock.svg"></p>
						
						<div style="clear:both"></div>
					
					</div>
				</div>
				<!--/.page-content-->
				
			</div>
			<!--/.row-->
		</div>
		<!--/.container-->
	</div>
	<!-- /.main-container -->


<style type="text/css">
	#is_emis_wrap {
		width: 100%;
		float: left;
	}
	#catsContainer {
	    border: 1px solid #fff;
	    background-color: #fff;
	    min-height: 38px;
	    padding: .5rem .75rem;
	    border-radius: 0px 0px 0px 0px!important;} 
	.select2-container--default .select2-selection--single {
	    background: #fff!important;
	    border: 1px solid #fff!important;}
	    .select2-container--open .select2-dropdown--below {
	    background: #fff!important;}
	.select2-container--default .select2-search--dropdown .select2-search__field {
	    border: 1px solid #fff!important;} 
	.form-control {border: 1px solid #f2f4f5!important;} .input-group-text {
	    border-radius: 0px;
	    background: #f2f4f5;
	    border: 1px solid #f2f4f5;} 
	.bloco-cada2 {
	    padding-top: 15px;
	    padding-bottom: 15px;
	    padding-left: 38px;
	    border-radius: 4px;
	    background: #fff;
	    width: 100%;
	    margin-bottom: 10px;}
	    .bloco-cada3 {
	    display:block!important;
	    padding-top: 15px;
	    padding-bottom: 15px;
	    padding-left: 38px;
	    border-radius: 4px;
	    background: #fff;
	    width: 100%;
	    margin-bottom: 10px;}
	input {border: 2px solid #002f34!important;}
	input:checked {
	  border: 5px solid #002f34!important;}
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
	hr {margin-bottom: 2rem;}
	
	.swal-title {
	    color: #575757 !important;
        font-size: 17px !important;
        font-weight: 600 !important;
        margin: 4px 0 !important;
        text-transform: none !important;
        position: relative !important;
        text-align: center !important;
        padding: 0 !important;
        line-height: 40px !important;
        display: block !important;
        margin-top: 16px !important;
        font-weight: 500 !Important;
    }
    
    .swal-text {
        color: #5f5f5f !important;
        font-size: 14px!important;
        font-weight: 400!important;
    }
    
    .swal-footer {
        margin-top: 0px !important;
        text-align: center !important;
    }
    
    .swal-button-container {
        margin-top: 0px !important;
    }
    
    .swal-button {
        background-color: #fe754f!important;
        font-size: 12px!important;
        font-weight: 400!important;
        border-radius: 4px!important;
        padding: 9px 12px!important;
        margin: 14px 5px 0 5px!important;
    }
</style>

@endsection

@section('after_scripts')
<script>
	$(".allow_decimal").on("input", function(evt) {
    	var self = $(this);
    	self.val(self.val().replace(/[^0-9\.]/g, ''));
    	if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
    	{
    		evt.preventDefault();
    	}
	});
</script>
<script type="text/javascript">
const ONE_SECOND = 1000;
var mobile = "";
var state = "initial";
var timer = null;
var numberIsAdded = false;

function isValidPhoneNumber(mobile) {
  if (isSandboxNumber(mobile)) {
    return true;
  } else {
    var phoneUtil = libphonenumber.PhoneNumberUtil.getInstance();
    var number = phoneUtil.parse("+244" + mobile);
    return phoneUtil.isValidNumberForRegion(number, "AO");
  }
}

function isSandboxNumber(mobile) {
  switch (mobile) {
    case '900000000':
      return true;
    case '900002004':
      return true;
    case '900003000':
      return true;
    default:
      return false;
  }
}

function checkMobileNumber(phoneNum) {
    return this.isValidPhoneNumber(phoneNum);
}

function showErrorMessage(status_reason) {
  switch(status_reason) {
    case "3000":
      document.getElementById("error-message").innerText = "Pagamento recusado pelo cliente";
      break;
    case "2004":
      document.getElementById("error-message").innerText = "Tempo limite de pagamento esgotado";
      break;
    case "2003":
      document.getElementById("error-message").innerText = "Limite de rede ou de cartão ultrapassado";
      break;
    case "2002":
      document.getElementById("error-message").innerText = "Pagamento recusado pelo emissor de cartão";
      break;
    case "2001":
      document.getElementById("error-message").innerText = "Pagamento recusado por saldo insuficiente na conta";
      break;
    case "2000":
      document.getElementById("error-message").innerText = "Processador de pagamentos não disponível";
      break;
    case "1000":
      document.getElementById("error-message").innerText = "Serviço não disponível";
      break;
    default:
      document.getElementById("error-message").innerText = "Erro desconhecido";
    }
}

function formatMobileNumber(mobile) {
    let formattedMobile = mobile.match(/.{1,3}/g);
    return formattedMobile.join(' ');
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function doPay() {
    var isHook = getCookie("IS_APPYPAY_HOOK");
    var merchantId = getCookie("MERCHANT_ID");
    var phone = getCookie("PHONE");
    
    if (isHook == "YES") {
	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
	        '<ul>' +
	        '<li id="alert-pay-msg">Confirme o pagamento no seu Multicaixa Express em 90 segundos.</li>' +
	        '</ul>' + 
	        '</div>'
	        );
	    
        $.ajax({
            url: "{{ route('wallet.appypay_finish') }}",
            type: "POST",
            data: {
                merchantTransactionId: merchantId,
                phone: phone
            },
            success: function (data) {
                if (data.result == 'success') {
                    $('#user_name_wallet').html(data['amount']);
                    $('.paid-status-' + data['prevWalletId']).html("<span>Pago</span>");
            	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success" style="color: white !important; background-color: #3bbb58db; border-radius: 6px;">' + 
            	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            	        '<ul>' +
            	        '<li id="alert-pay-msg">Pagamento feito</li>' +
            	        '</ul>' + 
            	        '</div>'
            	        );
	    
                } else if (data.result == 'failed') {
            	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
            	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
            	        '<ul>' +
            	        '<li id="alert-pay-msg">' + data.error + '</li>' +
            	        '</ul>' + 
            	        '</div>'
            	        );
                } else {
                    swal.close();
            	    $('#alert-pay-alert-scope').html('');
                }
                
                setCookie("IS_APPYPAY_HOOK", "NO", 1);
                setCookie("MERCHANT_ID", data.merchantTransactionId, 1);
            },
            error: function (err) {
                var error = err.responseJSON;
                swal.close();
            	$('#alert-pay-alert-scope').html('');
            	
                setCookie("IS_APPYPAY_HOOK", "NO", 1);
                setCookie("MERCHANT_ID", data.merchantTransactionId, 1);
            }
        });
    } else {
        setCookie("IS_APPYPAY_HOOK", "NO", 1);
        setCookie("MERCHANT_ID", data.merchantTransactionId, 1);
    }
}

$(document).ready(function() {
	$(".package-selection").click(function(){
		var selectedPKG= $('.package-selection:checked').attr("data-kzprice");
		$('input[name="hiddenkzprice"]').val(selectedPKG);
	});
	
	$('#radio_appypay').click(function() {
	    var isChecked = document.getElementById('radio_appypay').checked;
	    $('#is_appypay_wrap').css('display', 'block');
	});
	
	$('#btn-appypay1').click(function() {
	    var phone = $("#appypay-phone").val();
	    var amount = $('input[name="hiddenkzprice"]').val();
	    
	    if (phone == "" || !checkMobileNumber(phone)) {
    	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
    	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
    	        '<ul>' +
    	        '<li id="alert-pay-msg">Número de telemóvel inválido.</li>' +
    	        '</ul>' + 
    	        '</div>'
    	        );
			
	        return ;
	    }
	    
	    if ($('#block-two-request').val() == "1")
	        return;
	    
	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
	        '<ul>' +
	        '<li id="alert-pay-msg">Confirme o pagamento no seu Multicaixa Express em 90 segundos.</li>' +
	        '</ul>' + 
	        '</div>'
	        );
	    
	    $('#block-two-request').val("1");
	    $('#btn-appypay').prop('disabled', true);
        $.ajax({
            url: "{{ route('wallet.appypay_init') }}",
            type: "POST",
            data: {
                phone: phone,
                amount: amount
            },
            success: function (data) {
                if (data.result == 'pending') {
                    setCookie("IS_APPYPAY_HOOK", "YES", 1);
                    setCookie("PHONE", data.phone, 1);
                    setCookie("MERCHANT_ID", data.merchantTransactionId, 1);
                    window.location.reload();
                }
	            $('#block-two-request').val("0");
	            $('#btn-appypay').prop('disabled', false);
            },
            error: function (err) {
                var error = err.responseJSON;
                swal.close();
            	$('#alert-pay-alert-scope').html('');
	            $('#block-two-request').val("0");
	            $('#btn-appypay').prop('disabled', false);
            }
        });
	});
	
	$('#btn-appypay').click(function() {
	    var phone = $("#appypay-phone").val();
	    var amount = $('input[name="hiddenkzprice"]').val();
	    
	    if($("#radio_paypal").is(':checked')){
            window.location.href = "{{ route('paypal_payment') }}?amount="+amount;
	    }else{
    	    if (phone == "" || !checkMobileNumber(phone)) {
        	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
        	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
        	        '<ul>' +
        	        '<li id="alert-pay-msg">Número de telemóvel inválido.</li>' +
        	        '</ul>' + 
        	        '</div>'
        	        );
    			
    	        return ;
    	    }
    	    
    	    if ($('#block-two-request').val() == "1")
    	        return;
    	    
    	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
    	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
    	        '<ul>' +
    	        '<li id="alert-pay-msg">Confirme o pagamento no seu Multicaixa Express em 90 segundos.</li>' +
    	        '</ul>' + 
    	        '</div>'
    	        );
    	    
    	    $('#block-two-request').val("1");
    	    $('#btn-appypay').prop('disabled', true);
            $.ajax({
                url: "{{ route('wallet.appypay') }}",
                type: "POST",
                data: {
                    phone: phone,
                    amount: amount
                },
                success: function (data) {
                    if (data.result == 'success') {
                        $('#user_name_wallet').html(data['amount']);
                	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success" style="color: white !important; background-color: #3bbb58db; border-radius: 6px;">' + 
                	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                	        '<ul>' +
                	        '<li id="alert-pay-msg">Pagagamento feito</li>' +
                	        '</ul>' + 
                	        '</div>'
                	        );
    	    
                    } else if (data.result == 'failed') {
                	    $('#alert-pay-alert-scope').html('<div id="alert-pay-alert" class="alert alert-success">' + 
                	        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                	        '<ul>' +
                	        '<li id="alert-pay-msg">' + data.error + '</li>' +
                	        '</ul>' + 
                	        '</div>'
                	        );
                    } else {
                        swal.close();
                	    $('#alert-pay-alert-scope').html('');
                    }
    	            $('#block-two-request').val("0");
    	            $('#btn-appypay').prop('disabled', false);
                },
                error: function (err) {
                    var error = err.responseJSON;
                    swal.close();
                	$('#alert-pay-alert-scope').html('');
    	            $('#block-two-request').val("0");
    	            $('#btn-appypay').prop('disabled', false);
                }
            });
        }
	});
});
</script>
<script type="script/javascript" src="{{ url('/js/appypay.js?v=' . $randNum) }}"></script>
@endsection