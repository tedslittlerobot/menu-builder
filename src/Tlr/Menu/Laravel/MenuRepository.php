<?php namespace Tlr\Menu\Laravel;

use Menu\Laravel\MenuItem;
use Menu\MenuRepository as Repository;
use Illuminate\Foundation\Application;

class MenuRepository extends Repository {

	protected $app;

	public function __construct( Application $app )
	{
		$this->app = $app;
	}

	public function add( $key )
	{
		return $this->menus[ $key ] = $this->app['menu-item'];
	}

}
