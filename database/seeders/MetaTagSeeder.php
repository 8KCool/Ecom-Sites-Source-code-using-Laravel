<?php

namespace Database\Seeders;

use App\Models\MetaTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaTagSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$entries = [
			[
				'page'        => 'home',
				'title'       => [
					'en' => '{app_name} - Geo Classified Ads CMS',
					'fr' => '{app_name} - CMS d\'annonces classées et géolocalisées',
				],
				'description' => [
					'en' => 'Sell and Buy products and services on {app_name} in Minutes {country}. Free ads in {country}. Looking for a product or service - {country}',
					'fr' => 'Vendre et acheter des produits et services en quelques minutes sur {app_name} {country}. Petites annonces - {country}. Recherchez un produit ou un service - {country}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
					'fr' => '{app_name}, {country}, annonces, classées, gratuites, script, app, annonces premium',
				],
				'active'      => '1',
			],
			[
				'page'        => 'register',
				'title'       => [
					'en' => 'Sign Up - {app_name}',
					'fr' => 'S\'inscrire - {app_name}',
				],
				'description' => [
					'en' => 'Sign Up on {app_name}',
					'fr' => 'S\'inscrire sur {app_name}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'login',
				'title'       => [
					'en' => 'Login - {app_name}',
					'fr' => 'S\'identifier - {app_name}',
				],
				'description' => [
					'en' => 'Log in to {app_name}',
					'fr' => 'S\'identifier sur {app_name}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'create',
				'title'       => [
					'en' => 'Post Free Ads',
					'fr' => 'Publiez une annonce gratuite',
				],
				'description' => [
					'en' => 'Post Free Ads - {country}.',
					'fr' => 'Publier une annonce gratuite - {country}.',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'countries',
				'title'       => [
					'en' => 'Free Local Classified Ads in the World',
					'fr' => 'Petites annonces classées dans le monde',
				],
				'description' => [
					'en' => 'Welcome to {app_name} : 100% Free Ads Classified. Sell and buy near you. Simple, fast and efficient.',
					'fr' => 'Bienvenue sur {app_name} : Site de petites annonces 100% gratuit. Vendez et achetez près de chez vous. Simple, rapide et efficace.',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'contact',
				'title'       => [
					'en' => 'Contact Us - {app_name}',
					'fr' => 'Nous contacter - {app_name}',
				],
				'description' => [
					'en' => 'Contact Us - {app_name}',
					'fr' => 'Nous contacter - {app_name}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'sitemap',
				'title'       => [
					'en' => 'Sitemap {app_name} - {country}',
					'fr' => 'Plan du site {app_name} - {country}',
				],
				'description' => [
					'en' => 'Sitemap {app_name} - {country}. 100% Free Ads Classified',
					'fr' => 'Plan du site {app_name} - {country}. Site de petites annonces 100% gratuit dans le Monde. Vendez et achetez près de chez vous. Simple, rapide et efficace.',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'password',
				'title'       => [
					'en' => 'Lost your password? - {app_name}',
					'fr' => 'Mot de passe oublié? - {app_name}',
				],
				'description' => [
					'en' => 'Lost your password? - {app_name}',
					'fr' => 'Mot de passe oublié? - {app_name}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
			[
				'page'        => 'pricing',
				'title'       => [
					'en' => 'Pricing - {app_name}',
					'fr' => 'Tarifs - {app_name}',
				],
				'description' => [
					'en' => 'Pricing - {app_name}',
					'fr' => 'Tarifs - {app_name}',
				],
				'keywords'    => [
					'en' => '{app_name}, {country}, pricing, free ads, classified, ads, script, app, premium ads',
				],
				'active'      => '1',
			],
		];
		
		$tableName = (new MetaTag())->getTable();
		foreach ($entries as $entry) {
			$entry = arrayTranslationsToJson($entry);
			$entryId = DB::table($tableName)->insertGetId($entry);
		}
	}
}
