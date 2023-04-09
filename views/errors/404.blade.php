
@extends('errors.layouts.master')

@section('title', t('Page not found'))

@section('search')
	@parent
	@include('errors.layouts.inc.search')
@endsection

@section('content')
	@if (!(isset($paddingTopExists) and $paddingTopExists))
		<div class="h-spacer"></div>
	@endif
	<div style="padding-top:40px;" class="main-container inner-page">
		<div class="container">
			<div class="section-content">
				<div class="row">

					<div class="col-md-12 page-content">
						<div class="error-page">
							<div class="text-left m-l-0">
									<div style="margin-bottom:20px;" class="sitepopularbox__item sitepopularbox__item--searches overh brtop-1 pding15_0">
                            <h3 class="lheight16 c73 fbold inline">Pesquisas populares:</h3>
                                                            <a href="https://paiaki.com/search?c=&q=ps4&location=&l=&r=" class="link gray2 tunder"><span>PS4</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Fifa&location=&l=&r=" title="Dyson" class="link gray2 tunder"><span>Fifa</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Arrenda&location=&l=&r=" title="Arrenda" class="link gray2 tunder"><span>Arrenda</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=i10&location=&l=&r=" title="i10" class="link gray2 tunder"><span>i10</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Bicicleta&location=&l=&r=" title="Bicicleta" class="link gray2 tunder"><span>Bicicleta</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Bmw&location=&l=&r=" title="Bmw" class="link gray2 tunder"><span>Bmw</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Mercedes&location=&l=&r=" title="Mercedes" class="link gray2 tunder"><span>Mercedes</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Autocarro&location=&l=&r=" title="Autocaravanas usadas" class="link gray2 tunder"><span>Autocarros usadas</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Elantra&location=&l=&r=" title="Elantra" class="link gray2 tunder"><span>Elantra</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Piscina&location=&l=&r=" title="Piscina" class="link gray2 tunder"><span>Piscina</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Kia+Rio&location=&l=&r=" title="Caravana" class="link gray2 tunder"><span>Kia Rio</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Fatos&location=&l=&r=" title="Fatos" class="link gray2 tunder"><span>Fatos</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Sofas&location=&l=&r=" title="Sofas" class="link gray2 tunder"><span>Sofas</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Computador&location=&l=&r=" title="Computador" class="link gray2 tunder"><span>Computador</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=iPhone&location=&l=&r=" title="iPhone" class="link gray2 tunder"><span>iPhone</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Memoria+RAM&location=&l=&r=" title="Memoria RAM" class="link gray2 tunder"><span>Memoria RAM</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Vivenda&location=&l=&r=" title="Vivenda" class="link gray2 tunder"><span>Vivenda</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Apartamento&location=&l=&r=" title="Apartamento" class="link gray2 tunder"><span>Apartamento</span></a>,                                                            <a href="https://paiaki.com/location/luanda/11" title="Luanda" class="link gray2 tunder"><span>Luanda</span></a>,                                                            <a href="https://paiaki.com/search?c=&q=Sapato&location=Luanda&l=11&r=" title="Sapato" class="link gray2 tunder"><span>Sapato</span></a>  <a href="https://paiaki.com/category/moda/roupa" title="Roupas de mulheres" class="link gray2 tunder"><span>Roupas de mulheres, </span></a>     
                                                            
                                                            <a href="https://paiaki.com/search?c=&q=Relogios&location=&l=&r=" title="Relogios" class="link gray2 tunder"><span>Relogios, </span></a>
                                                            
                                                            <a href="https://paiaki.com/search?c=&q=Jeep&location=&l=&r=" title="Jeep" class="link gray2 tunder"><span>Jeep, </span></a> 
                                                            
                                                             <a href="https://paiaki.com/search?c=&q=Range+Rover&location=&l=&r=" title="Range Rover" class="link gray2 tunder"><span>Range Rover, </span></a>  
                                                             
                                                              <a href="https://paiaki.com/search?c=&q=condom%C3%ADnio&location=&l=&r=" title="Casas no condominio" class="link gray2 tunder"><span>Casas no condominio</span></a>                                                    </div>
					
					  <div class="sitepopularbox__item sitepopularbox__item--searches overh brtop-1 pding15_0">
                        <h3 class="lheight16 c73 fbold inline">Categorias populares:</h3>
                                                    <a href="https://paiaki.com/category/telemoveis" title="Telemóveis e Tablets em Angola" class="link gray2 tunder"><span>Telemóveis e Tablets</span></a>,                                                    <a href="https://paiaki.com/category/equipamentos" title="Angola Classificados Paiaki" class="link gray2 tunder"><span>Equipamentos e Ferramentas</span></a>,                                                    <a href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda e Beleza</span></a>,                                                    <a href="https://paiaki.com/category/eletronicos" title="Eletrónicos e Tecnologia em Angola" class="link gray2 tunder"><span>Eletrónicos e Tecnologia</span></a>,                                                    <a href="https://paiaki.com/category/lazer-e-desportos" title="Lazer em Angola" class="link gray2 tunder"><span>Lazer e Desporto</span></a>,                                                    <a href="https://paiaki.com/category/servicos" title="Serviços em Portugal" class="link gray2 tunder"><span>Serviços</span></a>,                                                    <a href="https://paiaki.com/category/animais" title="Animais em Angola" class="link gray2 tunder"><span>Animais</span></a>,                                                    <a href="https://paiaki.com/category/moda" title="Moda em Angola" class="link gray2 tunder"><span>Moda</span></a>,                                                    <a href="https://paiaki.com/category/moveis-e-mobilias" title="Móveis, Casa e Jardim em Angola" class="link gray2 tunder"><span>Móveis e Mobilias</span></a>,                                                    <a href="https://paiaki.com/category/eletronicos/electronica" title="Tecnologia em Angola" class="link gray2 tunder"><span>Electronicos</span></a>,                                                    <a href="https://paiaki.com/category/veiculos/" title="Carros, motos e barcos em Angola" class="link gray2 tunder"><span>Carros, motos e barcos</span></a>,                                                    <a href="https://paiaki.com/category/imoveis/" title="Imóveis em Angola" class="link gray2 tunder"><span>Imóveis e Casas</span></a>,                                                    <a href="https://paiaki.com/category/empregos" title="Emprego em Angola" class="link gray2 tunder"><span>Emprego</span></a>,                                                    <a href="https://paiaki.com/category/eletronicos/videojogos-consolas/" title="Consolas em Portugal" class="link gray2 tunder"><span>Consolas</span></a>,                                                    <a href="https://paiaki.com/category/outras-vendas/" title="Outras Vendas em Portugal" class="link gray2 tunder"><span>Outras Vendas</span></a>                                            </div>
							</div>
						</div>
						
					</div>

				</div>
			</div>
		</div>
	</div>
@endsection

<style>

.fbold {
    font-weight: 500!important;
    font-size: 14px;
}

.inline {
    display: inline;
}

.wrapper .sitepopularbox__wrapper {
    text-align: left;
    width: 1238px;
    font-size: 12px;
    margin-right: auto;
    margin-left: auto;
    padding-right: 24px;
    padding-left: 24px;
}

.sitepopularbox__item {
    flex: 1;
    border-top: none;
    padding: 0;
    font-size: 14px;
    line-height: 24px;
}

.pding15_0 {
    padding: 15px 0px;
}
.overh {
    overflow: hidden;
}

 .sitepopularbox__item {
    flex: 1;
    border-top: none;
    padding: 0;
    font-size: 14px;
    line-height: 24px;
}

.homepage .wrapper .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper .offersview .wrapper .offersview .offersview .offersview .sitepopularbox__wrapper .offersview .sitepopularbox__wrapper .detailpage .wrapper .detailpage .detailpage .detailpage .sitepopularbox__wrapper .detailpage .sitepopularbox__wrapper {
    width: 1029px;
}

.homepage .wrapper, .homepage .homepage .sitepopularbox__wrapper .homepage .sitepopularbox__wrapper {
    position: relative;
}

.sitepopularbox__wrapper {
    display: flex;
}

.promover {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 500;
    font-style: normal;
    line-height: 1.25;
    border: none;
    padding: 0 30px;
    height: 35px;
    cursor: pointer;
    -webkit-box-shadow: inset 0 0 0 2px #002f34;
    -moz-box-shadow: inset 0 0 0 2px #002f34;
    -ms-box-shadow: inset 0 0 0 2px #002f34;
    -o-box-shadow: inset 0 0 0 2px #002f34;
    box-shadow: inset 0 0 0 2px #002f34;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

</style>