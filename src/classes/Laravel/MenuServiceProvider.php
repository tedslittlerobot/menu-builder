<?php namespace Tlr\Menu\Laravel;

use Illuminate\Support\ServiceProvider;
use Tlr\Menu\Laravel\MenuRepository;
use Tlr\Menu\Laravel\MenuItem;

class MenuServiceProvider extends ServiceProvider {

	public function boot()
	{
		$this->setUpViewPaths();

		$this->app['html']->macro('element', function ( $element = 'div', $attributes = array(), $content = null )
		{
			foreach ($attributes as $attribute => $values)
			{
				$attributes[$attribute] = implode(' ', (array)$values);
			}

			$html = "<{$element}" . $this->app['html']->attributes( $attributes ) . ">";

			if ( !is_null($content) )
				$html .= "{$content}</{$element}>";

			return $html;
		});
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

	/**
	 * Set up the view paths for the package
	 */
	public function setUpViewPaths()
	{
		$name = 'menu';
		$viewPath = realpath( __DIR__.'/../../views' );

		$this->loadViewsFrom( $viewPath, $name );
		$publish[$viewPath] = base_path("resources/views/vendor/{$name}");
	}

}
