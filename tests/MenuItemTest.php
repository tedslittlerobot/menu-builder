<?php

use Mockery as m;
use Tlr\Menu\MenuItem;

class MenuItemTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		parent::setUp();

		$this->options = array(
			'woop' => 'woop woop',
			'boom' => 'check the bass'
		);

		$this->attributes = array(
			'foo' => 'bar',
			'baz' => 'foobar'
		);

		$this->menu = new MenuItem($this->options, $this->attributes);
	}

	public function tearDown()
	{
		parent::tearDown();

		m::close();
	}

	/**
	 * Test the constructor works
	 *
	 * @return void
	 */
	public function testInitialisation()
	{
		$array = array();

		foreach( $this->attributes as $key => $value )
		{
			$array[$key] = (array)$value;
		}

		$this->assertEquals( $this->options, $this->menu->getOptions() );
		$this->assertEquals( $array, $this->menu->getAttributes() );
	}

	/**
	 * Test that adding options works
	 *
	 * @return void
	 */
	public function testSetOption()
	{
		$this->menu = new MenuItem;

		$this->assertEquals( [], $this->menu->getOptions() );

		foreach( $this->options as $key => $value )
		{
			$this->menu->setOption( $key, $value );
		}

		$this->assertEquals( $this->options, $this->menu->getOptions() );
	}

	/**
	 * Test that getting options works
	 *
	 * @return void
	 */
	public function testGetValidOption()
	{
		$this->assertEquals( $this->options['woop'], $this->menu->option('woop') );
	}

	/**
	 * Test that getting options works
	 *
	 * @return void
	 */
	public function testGetMissingOption()
	{
		$this->assertEquals( null, $this->menu->option('eric') );
		$this->assertEquals( 'wilson', $this->menu->option('eric', 'wilson') );
	}

	/**
	 * Test that array access works
	 *
	 * @return void
	 */
	public function testArrayAccess()
	{
		$this->menu->setOption( 'option', 'value' );

		$this->assertEquals( 'value', $this->menu['option'] );

		$this->assertFalse( isset( $this->menu['test'] ) );

		$this->menu['test'] = 'peter';

		$this->assertTrue( isset( $this->menu['test'] ) );

		$this->assertEquals( 'peter', $this->menu['test'] );

		$this->assertNull( $this->menu['sony'] );

		unset( $this->menu['test'] );;

		$this->assertFalse( isset( $this->menu['test'] ) );
	}

	/**
	 * Test that adding sub items works
	 *
	 * @return void
	 */
	public function testAddItem()
	{
		$subItem = $this->menu->addItem( 'foo', 'Foo' );

		$this->assertContains( $subItem, $this->menu->getItems() );
	}

	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testGetItem()
	{
		$item = $this->menu->addItem( 'foo', 'Foo' );

		$this->assertEquals( $this->menu->item('foo'), $item );
	}

	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testMakeOrGet()
	{
		$item = $this->menu->item( 'foo', 'Foo' );

		$this->assertSame( $this->menu->item('foo'), $item );
	}

	/**
	 * Test that adding a single attribute works
	 *
	 * @return void
	 */
	public function testAddAttribute()
	{
		$this->menu->addAttribute( 'key', 'value' );

		$this->assertEquals( array('value'), $this->menu->getAttributes()['key'] );
	}

	/**
	 * Test that attributes can get merged reset and overridden
	 *
	 * @return void
	 */
	public function testOverrideAttributes()
	{
		$attributes = array(
			'one' => 'two',
		);

		$this->menu->setAttributes( $attributes, true );

		$this->assertEquals( array( 'one' => array( 'two' ) ), $this->menu->getAttributes() );
	}

	/**
	 * Test that attributes get merged in when added
	 *
	 * @return void
	 */
	public function testMergeAttributes()
	{
		$attributes = array(
			'foo' => 'bar2',
			'last' => 'time'
		);

		$result = array(
			'foo' => array('bar', 'bar2'),
			'baz' => array('foobar'),
			'last' => array('time'),
		);

		$this->menu->setAttributes( $attributes );

		$this->assertEquals( $result, $this->menu->getAttributes() );
	}

	///// ACTIVE /////

	// public function testActiveIsInitiallyFalse()
	// {
	// 	$this->assertFalse( $this->menu->isActive() );
	// }

	// public function testSetActive()
	// {
	// 	$this->menu->setActive();

	// 	$this->assertTrue( $this->menu->isActive() );

	// 	$this->menu->setActive( 'eric' );

	// 	$this->assertEquals( 'eric', $this->menu->isActive() );
	// }

	// public function testActivateMatcher()
	// {
	// 	$this->menu->setOption( 'link', 'woop' );

	// 	$this->menu->activate( 'woop' );

	// 	$this->assertTrue( $this->menu->isActive() );

	// 	$this->menu->activate( 'eric' );

	// 	$this->assertFalse( $this->menu->isActive() );
	// }

	// public function testRecursiveActivation()
	// {
	// 	$item = $this->menu->item('sub');

	// 	$item->setOption( 'link', 'foo' );

	// 	$this->menu->activate( 'foo' );

	// 	$this->assertTrue( $this->menu->isActive() );

	// }

}
