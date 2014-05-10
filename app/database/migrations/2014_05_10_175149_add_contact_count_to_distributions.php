<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContactCountToDistributions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('distributions', function(Blueprint $table)
		{
			$table->integer('count');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('distributions', function(Blueprint $table)
		{
			$table->dropColumn('count');
		});
	}

}
