<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypeSeeder extends Seeder
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
				'name'   => 'Professional',
				'active' => '1',
			],
			[
				'name'   => 'Individual',
				'active' => '1',
			],
		];
		
		$tableName = (new UserType())->getTable();
		foreach ($entries as $entry) {
			DB::table($tableName)->insert($entry);
		}
	}
}
