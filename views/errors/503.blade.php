@extends('errors::layout')

@section('title', 'Paiaki Classificados - Manutenção')

<?php
$data = [];
if (file_exists(storage_path('framework/down'))) {
	$buffer = file_get_contents(storage_path('framework/down'));
	$data = json_decode($buffer, true);
}
?>

<div style="padding-top: 80px;" class="container fundo-categoria2 ocultar-phone1">
	<div class="page-info page-info-lite rounded">
	<div class="text-center section-promo">
	
	<div class="text-center"> <img style="width: 240px;" src="/public/images/log222.svg"> </div>
	<h1> Manutenção </h1>
	<p style="line-height: 24px;color:#002f34;padding-top: 20px;">Estamos realizando algumas melhorias e  <br> com certeza voltaremos dentro de 1 mês, aguardamos a sua compreensão! <br><br> Tudo que nós queremos é que o Paiaki seja a melhor plataforma de compra e venda <br>  em Angola oferencendo a melhor interface e segurança à todos os usuarios.</p> 
  <a href="https://blog.paiaki.com/" class="footer-business-partner__btn" target="_blank"><span>Ir ao blog do Paiaki</span></a>
	</div>
	</div>
</div>

<div  ><img src=""></div>

<style>

.texto {
color: #002f34;
font-family: "Arista 2.0";
font-size: 90px;
font-weight: 400;
font-style: normal;
letter-spacing: normal;
line-height: normal;
text-align: center!important;
font-style: normal;
letter-spacing: normal;
line-height: normal;}

@font-face {font-family: "Geomanist"; font-style: "normal"!important; font-display: block; font-weight: normal; src: url("/public/assets/fonts/Geomanist-Regular.woff2") format('woff2'), url("/public/assets/fonts/Geomanist-Regular.woff") format('woff'), url("/public/assets/fonts/Geomanist-Regular.ttf") format('truetype');}@font-face {font-family: "Geomanist"; font-style: "500"!important; font-display: block; font-weight: 500; src: url("/public/assets/fonts/Geomanist-Medium.woff2") format('woff2'), url("/public/assets/fonts/Geomanist-Medium.woff") format('woff'), url("/public/assets/fonts/Geomanist-Medium.ttf") format('truetype');}@font-face {font-family: "Geomanist"; font-style: "700"!important; font-display: block; font-weight: 700; src: url("/public/assets/fonts/Geomanist-Bold.woff2") format('woff2'), url("/public/assets/fonts/Geomanist-Bold.woff") format('woff'), url("/public/assets/fonts/Geomanist-Bold.ttf") format('truetype');}

.position-ref {
    display:none;
}
.flex-center {
    display:none;
}
.full-height {
    display: none!important;
}

body {font-family: 'Geomanist', Arial, sans-serif !important;font-weight: normal!important;}
h1, h3, h4, h5, h6 {font-family: 'Geomanist', Arial, sans-serif !important;font-weight: normal!important;}

  body { text-align: center;}
  h1 { font-size: 30px;color: #002f34;}
  
  .footer-business-partner__slogan strong {
    font-size: 20px;
    font-weight: 500;
    display: block;
    margin-top: 5px;
    color: #fff;
}

.footer-business-partner__btn:hover {
    background: none;
    color: #002f34!important;
    -webkit-box-shadow: inset 0 0 0 5px #002f34;
    -moz-box-shadow: inset 0 0 0 5px #002f34;
    -ms-box-shadow: inset 0 0 0 5px #002f34;
    -o-box-shadow: inset 0 0 0 5px #002f34;
    box-shadow: inset 0 0 0 5px #002f34;
}

.footer-business-partner {
    background: #002f34;
}

 .footer-business-partner__wrapper:before {
    width: 130px;
    height: 130px;
    color: #fff;
    background: no-repeat 50% 50% url(../../../images/graph2.svg);
    background-size: 100% 100%;
    position: absolute;
    left: 0;
    top: 50%;
    content: '';
    margin-top: -65px;
}

 .footer-business-partner__slogan {
    flex: 1;
    font-size: 18px;
    font-weight: 400;
    line-height: 1.25;
    color: #fff;
}

 .footer-business-partner__action {
    margin-left: 30px;
}

 .footer-business-partner__btn {
    background: #002f34;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    line-height: 1.29;
    padding: 11px 22px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 133px;
    -webkit-box-shadow: inset 0 0 0 8px #002f34;
    -moz-box-shadow: inset 0 0 0 8px #002f34;
    -ms-box-shadow: inset 0 0 0 8px #002f34;
    -o-box-shadow: inset 0 0 0 8px #002f34;
    box-shadow: inset 0 0 0 8px #002f34;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    -ms-border-radius: 4px;
    -o-border-radius: 4px;
    border-radius: 4px;
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    -ms-transition: all 0.3s ease;
    -o-transition: all 0.3s ease;
    transition: all 0.3s ease;
    text-decoration: none;
}

 .footer-business-partner__wrapper {
    display: flex;
    text-align: left;
    font-size: 12px;
    margin-right: auto;
    margin-left: auto;
    width: 820px;
    height: 130px;
    align-items: center;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    -ms-box-sizing: border-box;
    -o-box-sizing: border-box;
    box-sizing: border-box;
    padding-left: 160px;
    position: relative;
}
</style>