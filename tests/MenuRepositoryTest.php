<?php

use Mockery as m;
use Menu\MenuRepository;
use Menu\MenuItem;

class MenuRepositoryTest extends TestCase {

	public function setUp() {
		parent::setUp();

		$this->repo = new MenuRepository($this->properties);
	}

	/**
	 * Test for self
	 *
	 * @return void
	 */
	public function testSelfReceipt()
	{
		$this->assertEquals( $this->repo, $this->repo->getRepository() );
	}

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testMenuCreate()
	{
		$menu = $this->repo->menu('woop');

		$this->assertEquals( 'Menu\MenuItem', get_class($menu) );
	}

	/**
	 * A basic functional test example.
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
