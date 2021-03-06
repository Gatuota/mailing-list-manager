<?php namespace MLM\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\Store;
use MLM\Repositories\Contact\EloquentContact;
use MLM\Repositories\Distribution\EloquentDistribution;
use MLM\Repositories\Record\EloquentRecord;
use MLM\Contact;
use MLM\Distribution;
use MLM\Record;

class RepositoryServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		// Bind the Contact Repository
        $app->bind('MLM\Repositories\Contact\ContactInterface', function($app)
        {
            return new EloquentContact(
            	new Contact,
            	$app['session.store']
            );
        });

        // Bind the Distribution Repository
        $app->bind('MLM\Repositories\Distribution\DistributionInterface', function($app)
        {
            return new EloquentDistribution(
            	new Distribution,
                $app->make('MLM\Repositories\Contact\ContactInterface'),
            	$app['session.store']
            );
        });

        // Bind the Record Repository
        $app->bind('MLM\Repositories\Record\RecordInterface', function($app)
        {
            return new EloquentRecord(
                new Record,
                $app['session.store']
            );
        });

        
	}

}