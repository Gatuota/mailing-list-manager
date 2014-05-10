<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReplyNameToDistributions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('distributions', function(Blueprint $table)
		{
			$table->string('replyName');
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
			$table->dropColumn('replyName');
		});
	}

}
