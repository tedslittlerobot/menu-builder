<?php namespace Tlr\Menu;

use Menu\MenuItem;

class MenuRepository {

	protected $menus = array();

	public function menu( $key ) {

		if ( ! isset( $this->menus[ $key ] ) ) {
			$this->add( $key );
		}

		return $this->menus[ $key ];
	}

	public function add( $key )
	{
		return $this->menus[ $key ] = new MenuItem;
	}

	public function getRepository() {
		return $this;
	}

}
