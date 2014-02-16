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
		$this->assertEquals( $this->options, $this->menu->getOptions() );
		$this->assertEquals( $this->attributes, $this->menu->getAttributes() );
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

	// /**
	//  * Test that array access works
	//  *
	//  * @return void
	//  */
	// public function testArrayAccess()
	// {
	// 	$this->menu->setOption( 'option', 'value' );

	// 	$this->assertEquals( 'value', $this->menu['option'] );

	// 	$this->menu['test'] = 'peter';

	// 	$this->assertEquals( 'peter', $this->menu['test'] );

	// 	$this->assertEquals( false, $this->menu['sony'] );
	// }

	// /**
	//  * Test that adding sub items works
	//  *
	//  * @return void
	//  */
	// public function testAddItem()
	// {
	// 	$options = array(
	// 		'kick' => 'this',
	// 	);

	// 	$subItem = $this->menu->addItem( 'One', $options );

	// 	$this->assertEquals( $this->menu->getItems()['One'], $subItem );
	// }


	// /**
	//  * Test that getting items works, and that they are created if
	//  * they do not already exist
	//  *
	//  * @return void
	//  */
	// public function testGetItem()
	// {
	// 	$options = array(
	// 		'kick' => 'this',
	// 	);

	// 	$subItem = $this->menu->addItem( 'One', $options );

	// 	$this->assertEquals( $this->menu->item('One'), $subItem );
	// }


	// /**
	//  * Test that getting items works, and that they are created if
	//  * they do not already exist
	//  *
	//  * @return void
	//  */
	// public function testAutoAddItem()
	// {
	// 	$options = array(
	// 		'kick' => 'this',
	// 	);

	// 	$subItem = $this->menu->item( 'One', $options );

	// 	$this->assertEquals( $this->menu->getItems()['One'], $subItem );
	// }

	// /**
	//  * Test that getting items works, and that they are created if
	//  * they do not already exist
	//  *
	//  * @return void
	//  */
	// public function testAddAttribute()
	// {
	// 	$this->menu->addAttribute( 'key', 'value' );

	// 	// $this->assertEquals( array( 'key' => 'value' ), $this->menu->getAttributes() );
	// }

	// /**
	//  * Test that getting items works, and that they are created if
	//  * they do not already exist
	//  *
	//  * @return void
	//  */
	// public function testMassAssignAndMergeAttributes()
	// {
	// 	$attributes = array(
	// 		'kick' => 'this',
	// 	);

	// 	$this->menu->setAttributes( $attributes );

	// 	$this->assertEquals( $attributes, $this->menu->getAttributes() );

	// 	$attributes[ 'what' ] = 'up';

	// 	$this->menu->setAttributes( $attributes, true );

	// 	$this->assertEquals( $attributes, $this->menu->getAttributes() );
	// }

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
