<div style="margin-top: 15px;" class="hidden-sm col-xl-12 content-box layout-section">
		<div class="row row-featured">

    <div class="user-panel-sidebar">
				<div class="panel-collapse" id="MyAds">
					<ul class="list-inline">
					    <li class="list-inline-item mt-2">
							<a {!! ($pagePath=='') ? 'class="active"' : '' !!} href="{{ url('account') }}">Perfil&nbsp;
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a{!! ($pagePath=='my-posts') ? ' class="active"' : '' !!} href="{{ url('account/my-posts') }}">
							 {{ t('my_ads') }}&nbsp;
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a{!! ($pagePath=='favourite') ? ' class="active"' : '' !!} href="{{ url('account/favourite') }}">
							{{ t('favourite_ads') }}&nbsp;
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a{!! ($pagePath=='saved-search') ? ' class="active"' : '' !!} href="{{ url('account/saved-search') }}">
							{{ t('Saved searches') }}&nbsp;
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a {!! ($pagePath=='messenger') ? 'class="active" ' : '' !!}href="{{ url('account/messages') }}">
							{{ t('messenger') }}&nbsp;
							<span class="badge badge-pill count-threads-with-new-messages hide">0</span>
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a{!! ($pagePath=='transactions') ? ' class="active"' : '' !!} href="{{ url('account/transactions') }}">
							{{ t('Transactions') }}&nbsp;
							</a>
						</li>
						<li class="list-inline-item mt-2">
							<a href="https://paiaki.com/account/wallet">
							Carteira&nbsp;
							</a>
						</li>
					</ul>
				</div>

		</div>
	</div>
</div>