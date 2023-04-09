<?php
if (
	config('settings.other.ios_app_url') ||
	config('settings.other.android_app_url') ||
	config('settings.social_link.facebook_page_url') ||
	config('settings.social_link.twitter_url') ||
	config('settings.social_link.google_plus_url') ||
	config('settings.social_link.linkedin_url') ||
	config('settings.social_link.pinterest_url') ||
	config('settings.social_link.instagram_url')
) {
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-12';
} else {
	$colClass2 = 'col-lg-4 col-md-4 col-sm-4 col-6';
	$colClass3 = 'col-lg-4 col-md-4 col-sm-4 col-12';
	$colClass4 = 'col-lg-4 col-md-4 col-sm-4 col-12';
}
?>
<footer class="main-footer">
	<div class="footer-content">
		<div class="container">
			<div class="row">
				<div class="col-xl-12">
				    <hr>
					<div class="copy-info text-center">
						© 2019 - {{ date('Y') }} Paiaki Angola - {{ t('all_rights_reserved') }}. </br>
						ANGOVITECH Platforms (SU) Lda. Luanda, Angola NIF: 5001277014
					</div>
					
					<div class="text-center" style="margin-top:10px;"><a target="_blank" href="https://www.angovitech.com/"><img alt="Powered by ANGOVITECH Platforms (SU) Lda." title="Powered by ANGOVITECH Platforms (SU) Lda." src="/images/angovitechlogo.svg" width="85"></a></div>
				</div>
				</div>
			
			</div>
		</div>
	</div>
</footer>

<style>.footer-content {
    padding: 22px 0;
}</style>
