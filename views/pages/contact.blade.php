
@extends('layouts.master')

@section('search')
	@parent
	@includeFirst([config('larapen.core.customizedViewPath') . 'pages.inc.contact-intro', 'pages.inc.contact-intro'])
@endsection

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row clearfix">
				
				@if (isset($errors) and $errors->any())
					<div class="col-xl-12">
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
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-12">
								@include('flash::message')
							</div>
						</div>
					</div>
				@endif
				
				<div class="col-md-12">
					<div class="contact-form">
						<div style="background: #f2f4f5!important;" class="inner-box relative">
						<h1 class="title-2"></h1>
						
						<section class="col-sm-12 page-content main-advantages">
<div class="row d-flex">
<div class="text-block">
<h2 style="font-weight: 800!important; line-height: 30px;">Sinta-se a vontade em nos contactar, nós metemos os nossos visitantes, parceiros e clientes em primeiro lugar e estamos aqui para vos servir.</h2>
<div>
<p><span style="font-size: 12pt;">Email: geral@paiaki.com <br>Telefone: +244 923 692 678  <br>Horário: Segunda à sexta-feira: 08 às 16 horas <br> Localização: Urbanização Nova Vida, Rua 181, Casa 6024, Luanda, Angola<br> ANGOVITECH Platforms (SU) Lda. NIF: 5001277014<br></span></p>
</div>
</div>
<div class="img-block"><img src="../../../images/pc.png" /></div>
</div>
</section>
<p>&nbsp;</p>
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

#catsContainer {
    border: 1px solid #fff;
    background-color: #fff;
    min-height: 38px;
    padding: .5rem .75rem;
    border-radius: 0px 0px 0px 0px!important;
} .select2-container--default .select2-selection--single {
    background: #fff!important;
    border: 1px solid #fff!important;}
    
    .select2-container--open .select2-dropdown--below {
    background: #fff!important;
}

.select2-container--default .select2-search--dropdown .select2-search__field {
    border: 1px solid #fff!important;
} input {background-color:#fff!important; border: 1px solid #fff!important;} .form-control {background-color:#fff!important; border: 1px solid #fff!important;} .input-group-text {
    border-radius: 0px;
    background: #fff;
    border: 1px solid #fff;
} 
</style>