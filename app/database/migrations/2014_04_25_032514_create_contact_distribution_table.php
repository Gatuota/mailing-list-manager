<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactDistributionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contact_distribution', function(Blueprint $table)
		{
			$table->integer('contact_id')->references('id')->on('contacts');
			$table->integer('distribution_id')->references('id')->on('distributions');
			$table->string('method');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contact_distribution');
	}

}
