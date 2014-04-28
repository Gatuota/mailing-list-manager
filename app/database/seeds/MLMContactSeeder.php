<?php

class MLMContactSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$faker = Faker\Factory::create();

		foreach(range(1, 40) as $index)
		{
			MLM\Contact::create([
				'firstName' => $faker->firstName,
				'lastName' => $faker->lastName,
				'email' => $faker->email,
				'phone' => $faker->phoneNumber,
				'user_id' => 1 
			]);
		}
	}

}
