<?php

use Mockery as m;
use Tlr\Menu\MenuItem;

class MenuItemTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		parent::setUp();

		$this->properties = array(
			'woop' => 'woop woop',
			'boom' => 'check the bass'
		);

		$this->menu = new MenuItem($this->properties);
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
		$this->assertEquals( $this->properties, $this->menu->getProperties() );
	}

	/**
	 * Test that adding proprties works
	 *
	 * @return void
	 */
	public function testSetProperty()
	{
		$this->menu = new MenuItem;

		$this->assertEquals( [], $this->menu->getProperties() );

		foreach ($this->properties as $key => $value)
		{
			$this->menu->setProperty( $key, $value );
		}

		$this->assertEquals( $this->properties, $this->menu->getProperties() );
	}

	/**
	 * Test that getting proprties works
	 *
	 * @return void
	 */
	public function testGetValidProperty()
	{
		$this->assertEquals( $this->properties['woop'], $this->menu->getProperty('woop') );
	}

	/**
	 * Test that getting proprties works
	 *
	 * @return void
	 */
	public function testGetMissingProperty()
	{
		$this->assertEquals( false, $this->menu->getProperty('eric') );
		$this->assertEquals( 'wilson', $this->menu->getProperty('eric', 'wilson') );
	}

	// /**
	//  * Test that getting proprties works
	//  *
	//  * @return void
	//  */
	// public function testGetMagicProperty()
	// {
	// 	$this->assertEquals( $this->properties['woop'], $this->menu->getWoop() );
	// 	$this->assertEquals( false, $this->menu->getEric() );
	// }

	/**
	 * Test that array access works
	 *
	 * @return void
	 */
	public function testArrayAccess()
	{
		$this->menu->setProperty( 'property', 'value' );

		$this->assertEquals( 'value', $this->menu['property'] );

		$this->menu['test'] = 'peter';

		$this->assertEquals( 'peter', $this->menu['test'] );

		$this->assertEquals( false, $this->menu['sony'] );
	}

	/**
	 * Test that adding sub items works
	 *
	 * @return void
	 */
	public function testAddItem()
	{
		$properties = array(
			'kick' => 'this',
		);

		$subItem = $this->menu->addItem( 'One', $properties );

		$this->assertEquals( $this->menu->getItems()['One'], $subItem );
	}


	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testGetItem()
	{
		$properties = array(
			'kick' => 'this',
		);

		$subItem = $this->menu->addItem( 'One', $properties );

		$this->assertEquals( $this->menu->item('One'), $subItem );
	}


	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testAutoAddItem()
	{
		$properties = array(
			'kick' => 'this',
		);

		$subItem = $this->menu->item( 'One', $properties );

		$this->assertEquals( $this->menu->getItems()['One'], $subItem );
	}

	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testAddAttribute()
	{
		$this->menu->addAttribute( 'key', 'value' );

		$this->assertEquals( array( 'key' => 'value' ), $this->menu->getAttributes() );
	}

	/**
	 * Test that getting items works, and that they are created if
	 * they do not already exist
	 *
	 * @return void
	 */
	public function testMassAssignAndMergeAttributes()
	{
		$attributes = array(
			'kick' => 'this',
		);

		$this->menu->setAttributes( $attributes );

		$this->assertEquals( $attributes, $this->menu->getAttributes() );

		$attributes[ 'what' ] = 'up';

		$this->menu->setAttributes( $attributes, true );

		$this->assertEquals( $attributes, $this->menu->getAttributes() );
	}

	public function testActiveIsInitiallyFalse()
	{
		$this->assertFalse( $this->menu->isActive() );
	}

	public function testSetActive()
	{
		$this->menu->setActive();

		$this->assertTrue( $this->menu->isActive() );

		$this->menu->setActive( 'eric' );

		$this->assertEquals( 'eric', $this->menu->isActive() );
	}

	public function testActivateMatcher()
	{
		$this->menu->setProperty( 'link', 'woop' );

		$this->menu->activate( 'woop' );

		$this->assertTrue( $this->menu->isActive() );

		$this->menu->activate( 'eric' );

		$this->assertFalse( $this->menu->isActive() );
	}

	public function testRecursiveActivation()
	{
		$item = $this->menu->item('sub');

		$item->setProperty( 'link', 'foo' );

		$this->menu->activate( 'foo' );

		$this->assertTrue( $this->menu->isActive() );

	}

}
