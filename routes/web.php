<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Upgrading
|--------------------------------------------------------------------------
|
| The upgrading process routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Web\Install',
	'middleware' => ['web', 'no.http.cache'],
], function () {
	Route::get('upgrade', 'UpdateController@index');
	Route::post('upgrade/run', 'UpdateController@run');
});


/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Web\Install',
	'middleware' => ['web', 'install.checker', 'no.http.cache'],
	'prefix'     => 'install',
], function () {
	Route::get('/', 'InstallController@starting');
	Route::get('site_info', 'InstallController@siteInfo');
	Route::post('site_info', 'InstallController@siteInfo');
	Route::get('system_compatibility', 'InstallController@systemCompatibility');
	Route::get('database', 'InstallController@database');
	Route::post('database', 'InstallController@database');
	Route::get('database_import', 'InstallController@databaseImport');
	Route::get('cron_jobs', 'InstallController@cronJobs');
	Route::get('finish', 'InstallController@finish');
});


/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------
|
| The admin panel routes
|
*/
Route::group([
	'namespace'  => 'App\Http\Controllers\Admin',
	'middleware' => ['web', 'install.checker'],
	'prefix'     => config('larapen.admin.route', 'admin'),
], function ($router) {
	// Auth
	// Authentication Routes...
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::get('logout', 'Auth\LoginController@logout')->name('logout');
	
	// Password Reset Routes...
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset')->where('token', '.+');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
	
	// Admin Panel Area
	Route::group([
		'middleware' => ['admin', 'clearance', 'banned.user', 'no.http.cache'],
	], function ($router) {
		// Dashboard
		Route::get('dashboard', 'DashboardController@dashboard');
		Route::get('/', 'DashboardController@redirect');
		
		// Extra (must be called before CRUD)
		Route::get('homepage/{action}', 'HomeSectionController@reset')->where('action', 'reset_(.*)');
		Route::get('languages/sync_files', 'LanguageController@syncFilesLines');
		Route::get('languages/texts/{lang?}/{file?}', 'LanguageController@showTexts')->where('lang', '[^/]*')->where('file', '[^/]*');
		Route::post('languages/texts/{lang}/{file}', 'LanguageController@updateTexts')->where('lang', '[^/]+')->where('file', '[^/]+');
		Route::get('permissions/create_default_entries', 'PermissionController@createDefaultEntries');
		Route::get('blacklists/add', 'BlacklistController@banUserByEmail');
		Route::get('categories/rebuild-nested-set-nodes', 'CategoryController@rebuildNestedSetNodes');
		
		// CRUD
		CRUD::resource('advertisings', 'AdvertisingController');
		CRUD::resource('blacklists', 'BlacklistController');
		CRUD::resource('categories', 'CategoryController');
		CRUD::resource('categories/{catId}/subcategories', 'CategoryController');
		CRUD::resource('categories/{catId}/custom_fields', 'CategoryFieldController');
		CRUD::resource('cities', 'CityController');
		CRUD::resource('countries', 'CountryController');
		CRUD::resource('countries/{countryCode}/cities', 'CityController');
		CRUD::resource('countries/{countryCode}/admins1', 'SubAdmin1Controller');
		CRUD::resource('currencies', 'CurrencyController');
		CRUD::resource('custom_fields', 'FieldController');
		CRUD::resource('custom_fields/{cfId}/options', 'FieldOptionController');
		CRUD::resource('custom_fields/{cfId}/categories', 'CategoryFieldController');
		CRUD::resource('genders', 'GenderController');
		CRUD::resource('homepage', 'HomeSectionController');
		CRUD::resource('admins1/{admin1Code}/cities', 'CityController');
		CRUD::resource('admins1/{admin1Code}/admins2', 'SubAdmin2Controller');
		CRUD::resource('admins2/{admin2Code}/cities', 'CityController');
		CRUD::resource('languages', 'LanguageController');
		CRUD::resource('meta_tags', 'MetaTagController');
		CRUD::resource('packages', 'PackageController');
		CRUD::resource('pages', 'PageController');
		CRUD::resource('payments', 'PaymentController');
		CRUD::resource('payment_methods', 'PaymentMethodController');
		CRUD::resource('permissions', 'PermissionController');
		CRUD::resource('pictures', 'PictureController');
		CRUD::resource('posts', 'PostController');
		CRUD::resource('p_types', 'PostTypeController');
		CRUD::resource('report_types', 'ReportTypeController');
		CRUD::resource('roles', 'RoleController');
		CRUD::resource('settings', 'SettingController');
		CRUD::resource('time_zones', 'TimeZoneController');
		CRUD::resource('users', 'UserController');
		
		// Others
		Route::get('account', 'UserController@account');
		Route::post('ajax/{table}/{field}', 'InlineRequestController@make')->where('table', '[^/]+')->where('field', '[^/]+');
		
		// Backup
		Route::get('backups', 'BackupController@index');
		Route::put('backups/create', 'BackupController@create');
		Route::get('backups/download/{file_name?}', 'BackupController@download')->where('file_name', '[^/]*');
		Route::delete('backups/delete/{file_name?}', 'BackupController@delete')->where('file_name', '[^/]*');
		
		// Actions
		Route::get('actions/clear_cache', 'ActionController@clearCache');
		Route::get('actions/clear_images_thumbnails', 'ActionController@clearImagesThumbnails');
		Route::get('actions/maintenance/{mode}', 'ActionController@maintenance')->where('mode', 'down|up');
		
		// Re-send Email or Phone verification message
		$router->pattern('id', '[0-9]+');
		Route::get('users/{id}/verify/resend/email', 'UserController@reSendEmailVerification');
		Route::get('users/{id}/verify/resend/sms', 'UserController@reSendPhoneVerification');
		Route::get('posts/{id}/verify/resend/email', 'PostController@reSendEmailVerification');
		Route::get('posts/{id}/verify/resend/sms', 'PostController@reSendPhoneVerification');
		
		// Plugins
		$router->pattern('plugin', '.+');
		Route::get('plugins', 'PluginController@index');
		Route::post('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/install', 'PluginController@install');
		Route::get('plugins/{plugin}/uninstall', 'PluginController@uninstall');
		Route::get('plugins/{plugin}/delete', 'PluginController@delete');
		
		// System Info
		Route::get('system', 'SystemController@systemInfo');

		// Wallet
		Route::get('wallets', 'WalletController@index');
		Route::post('ajax_walletlist', 'WalletController@ajax_walletlist')->name('admin.ajax_walletlist');
		Route::post('ajax_wallet_statusupdate', 'WalletController@ajax_wallet_statusupdate')->name('admin.ajax_wallet_statusupdate');

		
		
		//Route::post('ajax_checkwallet_balance', 'WalletController@ajax_checkwallet_balance')->name('admin.ajax_checkwallet_balance');
		
		// MetaTagUrlController
		Route::get('meta_tag_url', 'MetaTagUrlController@index');
		Route::post('ajax_meta_tag_url_list', 'MetaTagUrlController@ajax_meta_tag_url_list')->name('admin.ajax_meta_tag_url_list');
		Route::get('meta_tag_url/create', 'MetaTagUrlController@create')->name('admin.meta_tag_url_create');
		Route::post('meta_tag_url/insert', 'MetaTagUrlController@insert')->name('admin.meta_tag_url_insert');
		
		Route::get('meta_tag_url/edit/{editid}', 'MetaTagUrlController@edit_meta_tag_url')->where('editid', '[0-9]+')->name('admin.meta_tag_url_edit');
		Route::post('meta_tag_url/update', 'MetaTagUrlController@update')->name('admin.meta_tag_url_update');
		Route::post('meta_tag_url/deletemetatag', 'MetaTagUrlController@deletemetatag')->name('admin.meta_tag_url_delete');
		
	});
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The not translated front-end routes
|
*/
Route::match(['GET','POST'],'wallet/vpos_webhook', 'App\Http\Controllers\Web\Account\Wallet@vpos_webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::match(['GET','POST'],'wallet/emis_webhook', 'App\Http\Controllers\Web\Account\Wallet@emis_webhook')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::group([
	'namespace'  => 'App\Http\Controllers\Web',
	'middleware' => ['web', 'install.checker'],
], function ($router) {
	// Select Language
	Route::get('lang/{code}', 'Locale\SetLocaleController@redirect');
	
	// FILES
	Route::get('file', 'FileController@show');
	Route::get('js/fileinput/locales/{code}.js', 'FileController@fileInputLocales');
	
	// SEO
	Route::get('sitemaps.xml', 'SitemapsController@index');
	
	// Impersonate (As admin user, login as an another user)
	Route::group(['middleware' => 'auth'], function ($router) {
		Route::impersonate();
	});

	
});


/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The translated front-end routes
|
*/
Route::group([
	'namespace' => 'App\Http\Controllers\Web',
], function ($router) {
	Route::group(['middleware' => ['web', 'install.checker']], function ($router) {
		// Country Code Pattern
		$countryCodePattern = implode('|', array_map('strtolower', array_keys(getCountries())));
		$countryCodePattern = !empty($countryCodePattern) ? $countryCodePattern : 'us';
		/*
		 * NOTE:
		 * '(?i:foo)' : Make 'foo' case-insensitive
		 */
		$countryCodePattern = '(?i:' . $countryCodePattern . ')';
		$router->pattern('countryCode', $countryCodePattern);
		
		
		// HOMEPAGE
		Route::get('/', 'HomeController@index');
		Route::get(dynamicRoute('routes.countries'), 'CountriesController@index');
		
				
		// AUTH
		Route::group(['middleware' => ['guest', 'no.http.cache']], function ($router) {
			// Registration Routes...
			Route::get(dynamicRoute('routes.register'), 'Auth\RegisterController@showRegistrationForm');
			Route::post(dynamicRoute('routes.register'), 'Auth\RegisterController@register');
			Route::get('register/finish', 'Auth\RegisterController@finish');
			
			// Authentication Routes...
			Route::get(dynamicRoute('routes.login'), 'Auth\LoginController@showLoginForm');
			Route::post(dynamicRoute('routes.login'), 'Auth\LoginController@login');
			
			// Forgot Password Routes...
			Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
			Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLink');
			
			// Reset Password using Token
			Route::get('password/token', 'Auth\ResetPasswordController@showTokenRequestForm');
			Route::post('password/token', 'Auth\ResetPasswordController@sendResetToken');
			
			// Reset Password using Link (Core Routes...)
			Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
			Route::post('password/reset', 'Auth\ResetPasswordController@reset');
			
			// Social Authentication
			$router->pattern('provider', 'facebook|linkedin|twitter|google');
			Route::get('auth/{provider}', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/{provider}/callback', 'Auth\SocialController@handleProviderCallback');
		});
		
		// Email Address or Phone Number verification
		$router->pattern('field', 'email|phone');
		Route::get('users/{id}/verify/resend/email', 'Auth\RegisterController@reSendEmailVerification');
		Route::get('users/{id}/verify/resend/sms', 'Auth\RegisterController@reSendPhoneVerification');
		Route::get('users/verify/{field}/{token?}', 'Auth\RegisterController@verification');
		Route::post('users/verify/{field}/{token?}', 'Auth\RegisterController@verification');
		
		// User Logout
		Route::get(dynamicRoute('routes.logout'), 'Auth\LoginController@logout');
		
		
		// POSTS
		Route::group(['namespace' => 'Post'], function ($router) {
			$router->pattern('id', '[0-9]+');
			// $router->pattern('slug', '.*');
			$bannedSlugs = collect(config('routes'))->filter(function ($value, $key) {
				return (!Str::contains($key, '.') && !empty($value));
			})->flatten()->toArray();
			if (!empty($bannedSlugs)) {
				/*
				 * NOTE:
				 * '^(?!companies|users)$' : Don't match 'companies' or 'users'
				 * '^(?=.*)$'              : Match any character
				 * '^((?!\/).)*$'          : Match any character, but don't match string with '/'
				 */
				$router->pattern('slug', '^(?!' . implode('|', $bannedSlugs) . ')(?=.*)((?!\/).)*$');
			} else {
				$router->pattern('slug', '^(?=.*)((?!\/).)*$');
			}
			
			// SingleStep Post creation
			Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
				Route::get('create', 'CreateController@getForm');
				Route::post('create', 'CreateController@postForm');
				Route::get('create/finish', 'CreateController@finish');
				
				// Payment Gateway Success & Cancel
				Route::get('create/payment/success', 'CreateController@paymentConfirmation');
				Route::get('create/payment/cancel', 'CreateController@paymentCancel');
				Route::post('create/payment/success', 'CreateController@paymentConfirmation');
				
				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('posts/{id}/verify/resend/email', 'CreateController@reSendEmailVerification');
				Route::get('posts/{id}/verify/resend/sms', 'CreateController@reSendPhoneVerification');
				Route::get('posts/verify/{field}/{token?}', 'CreateController@verification');
				Route::post('posts/verify/{field}/{token?}', 'CreateController@verification');
			});
			
			// MultiSteps Post creation
			Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
				Route::get('posts/create', 'CreateController@getPostStep');
				Route::post('posts/create', 'CreateController@postPostStep');
				Route::get('posts/create/photos', 'CreateController@getPicturesStep');
				Route::post('posts/create/photos', 'CreateController@postPicturesStep');
				Route::post('posts/create/photos/{photoId}/delete', 'CreateController@removePicture');
				Route::post('posts/create/photos/reorder', 'CreateController@reorderPictures');
				Route::get('posts/create/payment', 'CreateController@getPaymentStep');
				Route::post('posts/create/payment', 'CreateController@postPaymentStep');
				Route::post('posts/create/finish', 'CreateController@finish');
				Route::get('posts/create/finish', 'CreateController@finish');
				
				// Payment Gateway Success & Cancel
				Route::get('posts/create/payment/success', 'CreateController@paymentConfirmation');
				Route::post('posts/create/payment/success', 'CreateController@paymentConfirmation');
				Route::get('posts/create/payment/cancel', 'CreateController@paymentCancel');
				
				// Email Address or Phone Number verification
				$router->pattern('field', 'email|phone');
				Route::get('posts/{id}/verify/resend/email', 'CreateController@reSendEmailVerification');
				Route::get('posts/{id}/verify/resend/sms', 'CreateController@reSendPhoneVerification');
				Route::get('posts/verify/{field}/{token?}', 'CreateController@verification');
				Route::post('posts/verify/{field}/{token?}', 'CreateController@verification');
			});
			
			Route::group(['middleware' => ['auth']], function ($router) {
				$router->pattern('id', '[0-9]+');
				
				// SingleStep Post edition
				Route::group(['namespace' => 'CreateOrEdit\SingleStep'], function ($router) {
					Route::get('edit/{id}', 'EditController@getForm');
					Route::put('edit/{id}', 'EditController@postForm');
					
					// Payment Gateway Success & Cancel
					Route::get('edit/{id}/payment/success', 'EditController@paymentConfirmation');
					Route::get('edit/{id}/payment/cancel', 'EditController@paymentCancel');
					Route::post('edit/{id}/payment/success', 'EditController@paymentConfirmation');
				});
				
				// MultiSteps Post edition
				Route::group(['namespace' => 'CreateOrEdit\MultiSteps'], function ($router) {
					Route::get('posts/{id}/edit', 'EditController@getForm');
					Route::put('posts/{id}/edit', 'EditController@postForm');
					Route::get('posts/{id}/photos', 'PhotoController@getForm');
					Route::post('posts/{id}/photos', 'PhotoController@postForm');
					Route::post('posts/{id}/photos/{photoId}/delete', 'PhotoController@delete');
					Route::post('posts/{id}/photos/reorder', 'PhotoController@reorder');
					Route::get('posts/{id}/payment', 'PaymentController@getForm');
					Route::post('posts/{id}/payment', 'PaymentController@postForm');
					
					// Payment Gateway Success & Cancel
					Route::get('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
					Route::post('posts/{id}/payment/success', 'PaymentController@paymentConfirmation');
					Route::get('posts/{id}/payment/cancel', 'PaymentController@paymentCancel');
				});
			});
			
			// Post's Details
			Route::get(dynamicRoute('routes.post'), 'DetailsController@index');
			
			// Send report abuse
			Route::get('posts/{id}/report', 'ReportController@showReportForm');
			Route::post('posts/{id}/report', 'ReportController@sendReport');
		});
		
		
		// ACCOUNT
		Route::group(['prefix' => 'account'], function ($router) {
			// Messenger
			// Contact Post's Author
			Route::group([
				'namespace' => 'Account',
				'prefix'    => 'messages',
			], function ($router) {
				Route::post('posts/{id}', 'MessagesController@store');
			});
			
			Route::group([
				'middleware' => ['auth', 'banned.user', 'no.http.cache'],
				'namespace'  => 'Account',
			], function ($router) {
				$router->pattern('id', '[0-9]+');
				
				// Users
				Route::get('/', 'EditController@index');
				Route::group(['middleware' => 'impersonate.protect'], function () {
					Route::put('/', 'EditController@updateDetails');
					Route::put('settings', 'EditController@updateDetails');
					Route::put('photo', 'EditController@updatePhoto');
					Route::put('photo/delete', 'EditController@updatePhoto');
				});
				Route::get('close', 'CloseController@index');
				Route::group(['middleware' => 'impersonate.protect'], function () {
					Route::post('close', 'CloseController@submit');
				});
				
				// Posts
				Route::get('saved-search', 'PostsController@getSavedSearch');
				$router->pattern('pagePath', '(my-posts|archived|favourite|pending-approval|saved-search)+');
				Route::get('{pagePath}', 'PostsController@getPage');
				Route::get('my-posts/{id}/offline', 'PostsController@getMyPosts');
				Route::get('archived/{id}/repost', 'PostsController@getArchivedPosts');
				Route::get('{pagePath}/{id}/delete', 'PostsController@destroy');
				Route::post('{pagePath}/delete', 'PostsController@destroy');
				
				// Messenger
				Route::group(['prefix' => 'messages'], function ($router) {
					$router->pattern('id', '[0-9]+');
					Route::post('check-new', 'MessagesController@checkNew');
					Route::get('/', 'MessagesController@index');
					// Route::get('create', 'MessagesController@create');
					Route::post('/', 'MessagesController@store');
					Route::get('{id}', 'MessagesController@show');
					Route::put('{id}', 'MessagesController@update');
					Route::get('{id}/actions', 'MessagesController@actions');
					Route::post('actions', 'MessagesController@actions');
					Route::get('{id}/delete', 'MessagesController@destroy');
					Route::post('delete', 'MessagesController@destroy');
				});
				
				// Transactions
				Route::get('transactions', 'TransactionsController@index');

				// Wallet
				/* Route::group(['prefix' => 'wallet'], function ($router) {
					$router->pattern('id', '[0-9]+');
					Route::get('/', 'Wallet@index');
				}); */
				
				Route::get('wallet', 'Wallet@index')->name('wallet_main_list');
				Route::get('wallet/recharge', 'Wallet@recharge');
				Route::post('wallet/recharge', 'Wallet@uploadPaymentDocument');
				Route::post('wallet/ajax_checkwallet_balance', 'Wallet@ajax_checkwallet_balance')->name('wallet.ajax_checkwallet_balance');
				//Route::get('wallet/update_userwallet', 'Wallet@update_userwallet');
				#new payment api work
				Route::post('wallet/emis', 'Wallet@emis')->name('wallet.emis');
				#new payment api work ends
				
				Route::post('wallet/appypay', 'Wallet@appypay')->name('wallet.appypay');
				Route::post('wallet/appypay_init', 'Wallet@appypayInit')->name('wallet.appypay_init');
				Route::post('wallet/appypay_finish', 'Wallet@appypayFinish')->name('wallet.appypay_finish');
				
				
				
				// PayPal Api
				Route::get('wallet/paypal/payment', 'PayPalController@pay')->name('paypal_payment');
                Route::get('wallet/paypal/cancel', 'PayPalController@error')->name('paypal_payment.cancel');
                Route::get('wallet/paypal/payment/success', 'PayPalController@success')->name('paypal_payment.success');
			});
		});
		
		
		// AJAX
		Route::group(['prefix' => 'ajax'], function ($router) {
			Route::get('countries/{countryCode}/admins/{adminType}', 'Ajax\LocationController@getAdmins');
			Route::get('countries/{countryCode}/admins/{adminType}/{adminCode}/cities', 'Ajax\LocationController@getCities');
			Route::get('countries/{countryCode}/cities/{id}', 'Ajax\LocationController@getSelectedCity');
			Route::post('countries/{countryCode}/cities/autocomplete', 'Ajax\LocationController@searchedCities');
			Route::post('countries/{countryCode}/admin1/cities', 'Ajax\LocationController@getAdmin1WithCities');
			Route::post('category/select-category', 'Ajax\CategoryController@getCategoriesHtml');
			Route::post('category/custom-fields', 'Ajax\CategoryController@getCustomFields');
			Route::post('save/post', 'Ajax\PostController@savePost');
			Route::post('save/search', 'Ajax\PostController@saveSearch');
			Route::post('post/phone', 'Ajax\PostController@getPhone');
		});
		
		
		// FEEDS
		Route::feeds();
		
		
		// SITEMAPS (XML)
		Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
		Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
		Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
		Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
		Route::get('{countryCode}/sitemaps/posts.xml', 'SitemapsController@posts');
		
		
		// PAGES
		Route::get(dynamicRoute('routes.pricing'), 'PageController@pricing');
		Route::get(dynamicRoute('routes.pageBySlug'), 'PageController@cms');
		Route::get(dynamicRoute('routes.contact'), 'PageController@contact');
		Route::post(dynamicRoute('routes.contact'), 'PageController@contactPost');
		
		// SITEMAP (HTML)
		Route::get(dynamicRoute('routes.sitemap'), 'SitemapController@index');
		
		// SEARCH
		Route::group(['namespace' => 'Search'], function ($router) {
			$router->pattern('id', '[0-9]+');
			$router->pattern('username', '[a-zA-Z0-9]+');
			Route::get(dynamicRoute('routes.search'), 'SearchController@index');
			Route::get(dynamicRoute('routes.searchPostsByUserId'), 'UserController@index');
			Route::get(dynamicRoute('routes.searchPostsByUsername'), 'UserController@profile');
			Route::get(dynamicRoute('routes.searchPostsByTag'), 'TagController@index');
			Route::get(dynamicRoute('routes.searchPostsByCity'), 'CityController@index');
			Route::get(dynamicRoute('routes.searchPostsBySubCat'), 'CategoryController@index');
			Route::get(dynamicRoute('routes.searchPostsByCat'), 'CategoryController@index');
		});
	});
});
