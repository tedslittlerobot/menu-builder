<?php namespace Tlr\Menu\Laravel;

use Illuminate\Support\ServiceProvider;
use Menu\Laravel\MenuRepository;

class MenuServiceProvider extends ServiceProvider {

	public function boot() {
		$this->app['view']->composer( 'menu.item', 'Menu\MenuItemComposer' );
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton( 'menu', function( $app ) {
			return new MenuRepository( $app );
		} );
	}

}
