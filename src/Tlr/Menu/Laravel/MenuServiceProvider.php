<?php namespace Tlr\Menu\Laravel;

use Illuminate\Support\ServiceProvider;
use Tlr\Menu\Laravel\MenuRepository;
use Tlr\Menu\Laravel\MenuItem;

class MenuServiceProvider extends ServiceProvider {

	public function boot() {
		$this->app['view']->composer( 'menu.item', 'Tlr\Menu\Laravel\MenuItemComposer' );
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

		$this->app['menu-item'] = $this->app->share( function( $app ) {
			return new MenuItem( $app );
		} );
	}

}
