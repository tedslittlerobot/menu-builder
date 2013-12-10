<?php namespace Tlr\Menu\Laravel;

use Tlr\Menu\MenuRepository as Repository;
use Illuminate\Foundation\Application;

class MenuRepository extends Repository {

	/**
	 * Laravel's IOC
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	public function __construct( Application $app )
	{
		$this->app = $app;
	}

	/**
	 * Add an IOC resolved Menu Item
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string   $key
	 * @return Tlr\Menu\Laravel\MenuItem
	 */
	public function add( $key )
	{
		return $this->menus[ $key ] = new MenuItem;
	}

	/**
	 * Get this repository
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return $this
	 */
	public function getRepository() {
		return $this;
	}

}
