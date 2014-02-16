<?php namespace Tlr\Menu;

use Tlr\Menu\MenuItem;

class MenuRepository {

	/**
	 * A list o' menus
	 * @var array
	 */
	protected $menus = array();

	/**
	 * Retrieve a menu, creating one if it doesn't exist
	 * @param  string   $key
	 * @return Tlr\Menu\MenuItem
	 */
	public function menu( $key )
	{
		if ( ! isset( $this->menus[ $key ] ) )
		{
			$this->add( $key );
		}

		return $this->menus[ $key ];
	}

	/**
	 * Add a menuItem
	 * @param  string   $key
	 * @return Tlr\Menu\MenuItem
	 */
	public function add( $key )
	{
		return $this->menus[ $key ] = new MenuItem;
	}

	/**
	 * Get the menus
	 * @return array
	 */
	public function getMenus()
	{
		return $this->menus;
	}

}
