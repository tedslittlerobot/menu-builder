<?php namespace Tlr\Menu\Laravel;

use View;
use Menu\MenuItem as Item;

class MenuItem extends Item {

	protected $view = 'menu.main';

	public function setView( $view )
	{
		$this->view = $view;

		return $this;
	}

	public function render()
	{
		return View::make('menu.main')
			->with( 'menu', $this );
	}

	public function __toString()
	{
		return $this->render()->render();
	}

}
