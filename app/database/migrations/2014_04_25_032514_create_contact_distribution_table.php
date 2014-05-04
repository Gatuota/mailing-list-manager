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
			$table->integer('contact_id')->unsigned();
			$table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
			$table->integer('distribution_id')->unsigned();
			$table->foreign('distribution_id')->references('id')->on('distributions')->onDelete('cascade');
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
