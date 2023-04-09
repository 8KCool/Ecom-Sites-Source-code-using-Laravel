<?php
// Fix: 404 error page don't know language and country objects.
$countryCode = 'us'; /* @fixme - Issue only in multi-countries mode. Get the real default country. */
$searchUrl = \App\Helpers\UrlGen::search();
?>
<div class="h-spacer"></div>
<div class="container">
    
<div class="text-center m-l-0 ocultar-pc">
		<h3 style="margin-top:50px;font-weight: 500!important;" class="m-t-0">Desculpa, página não encontrada.</h3>
</div>

<div class=" rounded-bottom ocultar-pc">
				<div class="container text-center">
					<div class="search-row fadeInUp">
						<form id="seach" name="search" action="{{ $searchUrl }}" method="GET">
							<div class="row m-0">
								<div class="col-sm-12 col-12 search-col relative">
									<a href="https://paiaki.com/search"><img class="lazyload" src="/images/pesquisa.svg" width="16px" style="position: absolute;top: 17px;left: 25px;"></a>
									<input style="font-size: 15px;" type="text" name="q" class="form-control has-icon" placeholder="O que está procurando?" value="">
								</div>
								{!! csrf_field() !!}
							</div>
						</form>
					</div>
		</div>
	</div>
    
    <h2 style="margin-top:30px;" class="title-2 text-center hidden-sm">
						<strong>Desculpa, página não encontrada.</strong>
						</h2>
	<div class=" rounded-bottom">
				<div class="container text-center hidden-sm">
					<div class="search-row fadeInUp">
						<form id="seach" name="search" action="{{ $searchUrl }}" method="GET">
							<div class="row m-0">
								<div class="col-sm-12 col-12 search-col relative">
									<img class="lazyload" src="/images/pesquisa.svg" width="20px" style="position: absolute;top: 26px;left: 24px;">
									<input style="font-size: 20px;" type="text" name="q" class="form-control has-icon" placeholder="O que procuras?" value="">
								</div>
								{!! csrf_field() !!}
							</div>
						</form>
					</div>
		</div>
	</div>
	
	<div style="margin-top:20px; margin-bottom:60px;" class="mb20 text-center">
							<a href="https://paiaki.com/" class="promover">
							 Ir à página inicial
							</a>
						</div>
	
</div>

<style>
#wrapper {padding-top: 80px!important;}
.title-2 {
    border-bottom: 1px solid #f2f4f5!important;
    font-size: 30px;
}

.search-row .search-col:first-child .form-control {
    border-radius: 5px!important;
    border-right: 1px solid #f9f9f9!important;
}.search-row .has-icon {
    padding-left: 62px;
}
.search-row .icon-append {
    color: #6d6d6d!important;
}</style>