<?php namespace Tlr\Menu\Laravel;

use View;
use Tlr\Menu\MenuItem as Item;
use HTML;

class MenuItem extends Item {

	/**
	 * The view to use for rendering
	 * @var string
	 */
	protected $view = 'menu::main';

	/**
	 * Set the render view
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string   $view
	 */
	public function setView( $view )
	{
		$this->view = $view;

		return $this;
	}

	/**
	 * Render the menu
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return Illuminate\View\View
	 */
	public function render()
	{
		return View::make( $this->view )
			->with( 'menu', $this );
	}

	public function __toString()
	{
		return $this->render()->render();
	}

	protected function getNewItem( $properties = array(), $attributes = array() )
	{
		return new MenuItem( $properties, $attributes );
	}


	/**
	 * Generate an HTML element
	 * @author Stef Horner     (shorner@wearearchitect.com)
	 * @param  string   $tag
	 * @param  array    $attributes
	 * @return string
	 */
	public function element( $tag = 'li', $attributes = array(), $content = null )
	{
		$element = array( $tag );

		if ( $attributes )
		{
			foreach ($attributes as $attribute => $values)
			{
				$attributes[$attribute] = implode(' ', (array)$values);
			}

			$element[] = HTML::attributes($attributes);
		}

		$output = "<". implode(' ', $element) .">";

		if (!is_null($content))
		{
			$output .= "$content</$tag>";
		}

		return $output;
	}

}
