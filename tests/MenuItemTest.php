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

	public function testActiveIsInitiallyFalse()
	{
		$this->assertFalse( $this->menu->isActive() );
	}

	public function testSetActive()
	{
		$this->menu->setActive();
		$this->assertTrue( $this->menu->isActive() );

		$this->menu->setActive( 'foo' );
		$this->assertTrue( $this->menu->isActive() );

		$this->menu->setActive( null );
		$this->assertFalse( $this->menu->isActive() );
	}

	public function testActivateMatchesTrue()
	{
		$this->menu->setOption( 'link', 'woop' );

		$this->menu->activate( 'woop' );

		$this->assertTrue( $this->menu->isActive() );
	}

	public function testActivateDoesNotMatch()
	{
		$this->menu->setOption( 'link', 'woop' );

		// This initial passing activation is in there due to an earlier bug
		$this->menu->activate( 'woop' );
		$this->menu->activate( 'foo' );

		$this->assertFalse( $this->menu->isActive() );
	}

	public function testRecursiveActivation()
	{
		$item = $this->menu->item('sub');

		$item->setOption( 'link', 'foo' );

		$this->menu->activate( 'foo' );

		$this->assertTrue( $this->menu->isActive() );
	}

	public function testMergeActiveWhenFalse()
	{
		$result = $this->menu->mergeActive( array() );

		$this->assertEquals( array(), $result );
	}

	public function testMergeActiveWhenTrue()
	{
		$this->menu->setOption( 'link', 'woop' );

		$this->menu->activate( 'woop' );

		$result = $this->menu->mergeActive( array() );

		$this->assertEquals( array( 'class' => array('active') ), $result );
	}

	public function testCompileAttributes()
	{
		$this->menu->setOptions( array('link' => 'fooLink', 'key' => 'fooKey') );
		$this->menu->setAttributes( array( 'class' => 'test' ), true );

		$this->menu->activate('fooLink');

		$expected = array(
			'class' => array('test', 'active', 'fookey')
		);

		$result = $this->menu->compileAttributes();

		$this->assertEquals( $expected, $result );
	}

	/**
	 * Test explicit assignment of new item index
	 */
	public function testNewItemStringIndex()
	{
		$result = $this->menu->getNewItemIndex( 'foo' );

		$this->assertEquals( 'foo', $result );
	}

	/**
	 * Test explicit assignment of new item index
	 */
	public function testNewItemRoundingIndices()
	{
		$result = $this->menu->getNewItemIndex();
		$this->assertEquals( 100, $result );

		$this->menu->addItem( 'foo', '', array(), array(), 5 );

		$result = $this->menu->getNewItemIndex();
		$this->assertEquals( 100, $result );

		$this->menu->addItem( 'foo', '', array(), array(), 100 );
		$result = $this->menu->getNewItemIndex();
		$this->assertEquals( 200, $result );

		$this->menu->addItem( 'foo', '', array(), array(), 299 );
		$result = $this->menu->getNewItemIndex();
		$this->assertEquals( 300, $result );
	}

	/**
	 * Make sure the makeOptions method turns its third argument into a link
	 * option if it is a strink
	 */
	public function testAutoLinkOptions()
	{
		$result = $this->menu->makeOptions('foo', 'bar', 'baz');

		$this->assertEquals( array('key' => 'foo', 'title' => 'bar', 'link' => 'baz'), $result );
	}

	/**
	 * Make sure the makeAttributes method returns the an attributes array,
	 * mutating it into a class array if the input is a string
	 */
	public function testMakeAttributes()
	{
		$result = $this->menu->makeAttributes( array('foo', 'bar') );

		$this->assertEquals( array('foo', 'bar'), $result );

		$result = $this->menu->makeAttributes( 'bar baz' );

		$this->assertEquals( array('class' => array('bar', 'baz')), $result );
	}

	/**
	 * Test the compilation of the options array into an array of HTML elements
	 */
	public function testCompileOptions()
	{
		$this->menu->setOption('link', 'foo');
		$this->menu->setOption('key', 'Foo Bar');

		$result = $this->menu->compileOptions();
		$this->assertEquals( array('class' => array('foo-bar')), $result );


		$result2 = $this->menu->compileOptions(true);
		$this->assertEquals( array('href' => 'foo', 'class' => array('foo-bar')), $result2 );
	}

	/**
	 * Test that the menu can see if it has any items
	 */
	public function testHasItems()
	{
		$this->assertFalse( $this->menu->hasItems() );

		$this->menu->item('foo');

		$this->assertTrue( $this->menu->hasItems() );
	}

	/**
	 * Check that the add filters function works
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @return [type] [description]
	 */
	public function testAddFilters()
	{
		$this->assertEquals(array(), $this->menu->getFilters());

		$callable = function() {};

		$this->menu->addFilter($callable);

		$this->assertEquals(array($callable), $this->menu->getFilters());
	}

}
