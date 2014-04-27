<?php namespace MLM\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Session\Store;
use MLM\Repositories\Contact\EloquentContact;
use MLM\Contact;

class RepositoryServiceProvider extends ServiceProvider {

	/**
	 * Register the binding
	 */
	public function register()
	{
		$app = $this->app;

		 // Bind the Session Repository
        $app->bind('MLM\Repositories\Contact\ContactInterface', function($app)
        {
            return new EloquentContact(
            	new Contact,
            	$app['session.store']
            );
        });

        
	}

}