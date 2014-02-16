<?php

use Mockery as m;
use Tlr\Menu\MenuRepository;
use Tlr\Menu\MenuItem;

class MenuRepositoryTest extends PHPUnit_Framework_TestCase {

	public function setUp() {
		parent::setUp();

		$this->repo = new MenuRepository($this->properties);
	}

	/**
	 * Assert that the repo can create menus
	 *
	 * @return void
	 */
	public function testMenuCreate()
	{
		$menu = $this->repo->menu('woop');

		$this->assertInstanceOf( 'Tlr\Menu\MenuItem', $menu );
		$this->assertContains( $menu, $this->repo->getMenus() );
	}

	/**
	 * Assert that the
	 *
	 * @return void
	 */
	public function testMenuRetrieval()
	{
		$woopMenu = $this->repo->menu('woop');
		$ericMenu = $this->repo->menu('eric');

		$this->assertSame( $woopMenu, $this->repo->menu('woop') );
		$this->assertSame( $ericMenu, $this->repo->menu('eric') );
	}

}
