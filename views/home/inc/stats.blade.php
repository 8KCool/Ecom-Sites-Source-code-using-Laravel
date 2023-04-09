<?php
$hideOnMobile = '';
if (isset($statsOptions, $statsOptions['hide_on_mobile']) and $statsOptions['hide_on_mobile'] == '1') {
	$hideOnMobile = ' hidden-sm';
}
?>
@if (isset($countPosts) and isset($countUsers) and isset($countCities))
@includeFirst([config('larapen.core.customizedViewPath') . 'home.inc.spacer', 'home.inc.spacer'], ['hideOnMobile' => $hideOnMobile])

<div style="margin-bottom:70px;" class="hidden-sm container {{ $hideOnMobile }}">
    <div class="advantages">
    <div class="coluna-inicial imagem1"> 
     <h4 style="margin-top:5px;color: #fff;">Dicas para uma vida melhor</h4>
    <p class="mb-0">{{ t('desc1') }}<br>{{ t('desc11') }}</p> 
   <a rel="nofollow" style="margin-top:15px;margin-bottom:5px;" target="_blank" href="https://blog.paiaki.com/" class="text-center btn btn-escuro">Ir ao Blog</a>
    </div>
    <div class="coluna-inicial imagem2"> 
   <h4 style="margin-top:5px;color: #fff;">Carregue a sua conta do Paiaki</h4>
    <p class="mb-0">{{ t('desc2') }}<br>{{ t('desc22') }}</p> 
   <a rel="nofollow" style="margin-top:15px;margin-bottom:5px;" target="_blank" href="{{ url('account/wallet/recharge') }}" class="text-center btn btn-branco">Carregar agora</a>
    </div>
    </div>  <div class="espaco"> </div>
    
    	    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-4663353052124843"
     crossorigin="anonymous"></script>
<!-- PAIAKI HORIZONTAL -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-4663353052124843"
     data-ad-slot="4947098633"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
		
    
</div>
@endif

<style>
.imagem1 {background-image: url(/images/banhome.png)!important;background-size: cover;color: #fff;min-height: 186px;justify-content: center;flex-direction: column;background-repeat: no-repeat;background-position: 100% 0;}
.imagem2 {background-image: url(/images/banhome2.png)!important;background-size: cover;color: #fff;min-height: 186px;justify-content: center;flex-direction: column;background-repeat: no-repeat;background-position: 100% 0;}
.mt-4, .my-4 {margin-top: 16px!important;}
</style>