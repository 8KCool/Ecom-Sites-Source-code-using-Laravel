<?php

namespace Database\Seeders;

use App\Models\PostType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTypeSeeder extends Seeder
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
				'name'   => [
					'en' => 'Private individual',
					'fr' => 'Particulier',
					'es' => 'Privado',
					'ar' => 'خاص',
					'pt' => 'Privado',
					'ru' => 'Частный',
					'tr' => 'Özel',
					'th' => 'เอกชน',
					'ka' => 'პირადი',
					'zh' => '私人的',
					'ja' => '非公開',
					'it' => 'Privato',
					'ro' => 'Particular',
					'de' => 'Privatperson',
				],
				'lft'    => null,
				'rgt'    => null,
				'depth'  => null,
				'active' => '1',
			],
			[
				'name'   => [
					'en' => 'Professional',
					'fr' => 'Professionnel',
					'es' => 'Negocio',
					'ar' => 'المحترفين',
					'pt' => 'O negócio',
					'ru' => 'Бизнес',
					'tr' => 'Ticaret',
					'th' => 'ธุรกิจ',
					'ka' => 'ბიზნესი',
					'zh' => '专业的',
					'ja' => 'プロ',
					'it' => 'Professionale',
					'ro' => 'Profesional',
					'de' => 'Fachmann/Fachfrau',
				],
				'lft'    => null,
				'rgt'    => null,
				'depth'  => null,
				'active' => '1',
			],
		];
		
		$tableName = (new PostType())->getTable();
		foreach ($entries as $entry) {
			$entry = arrayTranslationsToJson($entry);
			$entryId = DB::table($tableName)->insertGetId($entry);
		}
	}
}
