<?php namespace Tlr\Menu\Laravel;

use Illuminate\Support\ServiceProvider;
use Tlr\Menu\Laravel\MenuRepository;
use Tlr\Menu\Laravel\MenuItem;

class MenuServiceProvider extends ServiceProvider {

	public function boot()
	{
		$this->package('tlr/menu');

		$this->app['view']->composer( 'menu.item', 'Tlr\Menu\Laravel\MenuItemComposer' );

		$this->app['html']->macro(function ( $element = 'div', $attributes = array(), $content = null )
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
	 * Guess the package path for the provider.
	 *
	 * @return string
	 */
	public function guessPackagePath()
	{
		return realpath( parent::guessPackagePath().'/../' );
	}

}
