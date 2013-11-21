<?php namespace Tlr\Menu\Laravel;

use View;
use Tlr\Menu\MenuItem as Item;

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

}
