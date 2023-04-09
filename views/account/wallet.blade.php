@extends('layouts.master')

@section('content')
	@includeFirst([config('larapen.core.customizedViewPath') . 'common.spacer', 'common.spacer'])
	<div class="main-container">
		<div class="container">
			<div class="row">

				<!--/.page-sidebar-->
				<div class="col-md-12 page-content">
				
				<div style="background: #f2f4f5!important;" class="inner-box">
					    
					    <h2 class="title-2">{{ t('wallet_text') }}</h2>
					    
					    <div class="row pb-5 justify-content-between"><div class="col-12 col-md-7 mb-3">
					    
					    <div class="media pb-4"><div class="media-body"><span style="font-weight: 500;" class="m-0">Como funciona:</span> <p class="m-0">O saldo da conta é usado apenas para publicar e destacar anúncios de forma automática para obter maior visibilidade e aumentar a chance de vender mais rápido.</p></div></div>
					    
					    <div class="media pb-4"><div class="media-body"><span style="font-weight: 500;" class="m-0">Método de pagamento:</span> <p class="m-0">A conta é carregada de forma automática e segura por via Multicaixa Express e PayPal.</p></div></div>
					    
					    <div class="media pb-4"><div class="media-body"><span style="font-weight: 500;" class="m-0">Política de reembolso:</span> <p class="m-0">Não aceitamos reembolsos ou devoluções de valores referentes à carregamento de contas. Deste modo, apelamos para que tenha todos os requisitos disponíveis antes de efectuar quaisquer pagamentos para evitar constrangimentos.</p></div></div>
              
              
              </div> <div class="col-12 col-md-5 col-lg-4"><div class="wallet-balance row d-flex justify-content-center">
                  
                  <div style="background:#fff;border-radius:4px;margin-right: 20px;" class="col-12 align-self-center text-center pt-lg-4"><p class="mb-0" style="margin-top:18px;">Saldo disponível:</p> <?php
							$userid= auth()->user()->id;
							$getWalletAmount= DB::table('user_wallets')->where('user_id',$userid)->sum('amount');
							$walletMoney= $getWalletAmount;
						?> <h4 style="font-weight: 500!important;" class="text-grey m-0">{{ $getWalletAmount }} KZ</h4> 
						
						<center> <a style="margin-top:8px;margin-bottom:25px;" href="{{ url('account/wallet/recharge') }}" class="text-center btn btn-primary">Carregar conta</a></center>
						
						</div> 
						
						</div></div></div>
					    
						
						<div style="clear:both"></div>

                      <h2 style="margin-top: 50px;" class="title-2">Extratos</h2>
						<div class="table-responsive">
						    
                            <table style="border-top: solid 0px #fff!important;" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Montante</th>
                                        <th>Data</th>
                                        <th>{{ t('Status') }}</th>
                                    </tr>
								</thead>
                                <thead>
                                    @if ($uploadswallets)
                                    @php
                                        $counter = 1;
                                    @endphp
                                    @foreach ($uploadswallets as $uploadswallet)
                                        
                                        <tr>
                                            <td>{{ $uploadswallet->amount  }} KZ</td>
                                            <td>{{ $uploadswallet->created_at  }}</td>
                                            @if($uploadswallet->status ==1)
                                            <td><span>Pago</span></td>
                                            @elseif($uploadswallet->status ==2)
                                            <td><span>Rejeitado</span></td>
                                            @else
                                            <td><span>Pendente</span></td>              
                                            @endif
                                        </tr>
                                    @php
                                        $counter++;
                                    @endphp
                                    @endforeach
                                    @endif
                                </thead>
                            </table>
                        </div>
						
						<nav style="display:none!important;" aria-label="">{{ $uploadswallets->links() }}</nav>
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
@endsection

@section('after_scripts')
@endsection