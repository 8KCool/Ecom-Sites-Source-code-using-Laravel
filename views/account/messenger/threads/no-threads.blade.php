<div style="font-size: 16px; padding-top: 20px;" class="text-center mb30" role="alert">
	@if (request()->get('filter') == 'unread')
		{{ t('No new thread or with new messages') }}
	@elseif (request()->get('filter') == 'started')
		{{ t('No thread started by you') }}
	@elseif (request()->get('filter') == 'important')
		{{ t('No message marked as important') }}
	@else
<span style="font-size: 18px; font-weight: 500;">Olá ao Chat do Paiaki</span></br></br>
<span style="font-size: 15px; font-weight: 400;">Este é o lugar mais seguro para comunicares em tempo real com outros membros do Paiaki. Use-o para partilhar fotos e fechar negócios.</span></br>
<span style="font-size: 15px; font-weight: 400;">Para comerçares a conversar com outros membros, <a style="text-decoration: underline; font-weight: 800;" href="https://paiaki.com/search" target="_blank">pesquise por alguma coisa</a> ou <a style="text-decoration: underline; font-weight: 800;" href="https://paiaki.com/posts/create" target="_blank">publique um anúncio</a> no Paiaki.</span>
	@endif
</div>
</div>