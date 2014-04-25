<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDistributionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('distributions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('replyTo');
			$table->string('subject');
			$table->text('body');
			$table->boolean('active');
			$table->integer('user_id')->references('id')->on('users');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('distributions');
	}

}
