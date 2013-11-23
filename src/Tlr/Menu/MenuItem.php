<?php namespace Tlr\Menu;

use ArrayAccess;

/**
 * $key = 'Home';
 * $properties = [
 * 	'title' => 'Menu Title', // defaults to $key
 * 	'link' => 'http://eric.com'
 * ];
 * $menu->addItem( $key, $properties )
 */
class MenuItem implements ArrayAccess {

	/**
	 * Is the current item active
	 * @var boolean
	 */
	protected $active;

	/**
	 * Submenu Items
	 * @var array
	 */
	protected $items = array();

	/**
	 * Render Properties (for the link element)
	 * @var array
	 */
	protected $properties = array();

	/**
	 * Element Attributes for the list item
	 * @var array
	 */
	protected $attributes = array();

	public function __construct( $properties = array(), $attributes = array() )
	{
		$this->setProperties( $properties );
		$this->setAttributes( $attributes );
	}

	/**
	 * Get the sub menu items
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * Get the given item, creating a new one if it doesn't exist
	 * @author Stef Horner     (shorner@wearearchitect.com)
	 * @param  string   $key
	 * @param  array    $properties
	 * @return Tlr\Menu\MenuItem
	 */
	public function item( $key, $properties = array() )
	{
		if ( isset( $this->items[ $key ] ) )
			return $this->items[ $key ];

		return $this->addItem( $key, $properties );
	/**
	 * A function to allow for easy subclassing
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @return Tlr\MenuItem
	 */
	protected function getNewItem( $properties = array(), $attributes = array() )
	{
		return new MenuItem( $properties, $attributes );
	}

	/**
	 * Get the items attributes for HTML rendering
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return array
	 */
	public function getAttributes( $overwrite = array() )
	{
		return array_merge($this->attributes, $overwrite);
	}

	/**
	 * Batch set the item's attributes
	 * @author Stef Horner     (shorner@wearearchitect.com)
	 * @param  array   $attributes
	 * @param  boolean  $merge whether or not to merge the arrays
	 * @return $this
	 */
	public function setAttributes( $attributes, $merge = false )
	{
		$this->attributes = ( $merge ? array_merge($this->attributes, (array) $attributes) : (array) $attributes );
		return $this;
	}

	/**
	 * Set an individual attribute
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string   $key
	 * @param  mixed   $value
	 */
	public function addAttribute( $key, $value )
	{
		$this->attributes[ $key ] = $value;

		return $this;
	}

	/**
	 * Get the element's rendering properties
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return array
	 */
	public function getProperties( )
	{
		return $this->properties;
	}

	/**
	 * Create a new item and add it as a sub item, overwriting any
	 * that already exist
	 * @author Stef Horner     (shorner@wearearchitect.com)
	 * @param  string   $key
	 * @param  array    $properties
	 */
	public function addItem( $key, $properties = array() )
	{
		$item = $this->items[ $key ] = new MenuItem;

		// if $properties is a string, use that as the href attribute
		if ( is_string( $properties ) )
		{
			$item->addAttribute( 'href', $properties );
			$properties = array();
		}

		$item->setProperties( array_merge( array( 'title' => $key ), $properties ) );

		return $item;
	}

	/**
	 * Get an individual property
	 * @author Stef Horner   (shorner@wearearchitect.com)
	 * @param  string   $property
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function getProperty( $property, $default = false )
	{
		return isset( $this->properties[ $property ] ) ? $this->properties[ $property ] : $default;
	}

	/**
	 * Set an individual property
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string   $key
	 * @param  mixed   $value
	 * @return $this
	 */
	public function setProperty( $key, $value )
	{
		$this->properties[ $key ] = $value;
		return $this;
	}

	public function setProperties( $properties )
	{
		$this->properties = $properties;
	}

	/// ARRAY ACCESS ///

	public function offsetExists ( $key )
	{
		return isset( $this->properties[ $key ] );
	}

	public function offsetGet ( $key )
	{
		return $this->getProperty( $key );
	}

	public function offsetSet ( $key , $value )
	{
		$this->properties[ $key ] = $value;
	}

	public function offsetUnset ( $key )
	{
		unset( $this->properties[ $key ] );
	}

	/**
	 * Manually set the active state of the item
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  boolean  $value
	 * @return $this
	 */
	public function setActive( $value = true )
	{
		$this->active = $value;

		return $this;
	}

	/**
	 * Match if given value matches the property
	 * @author Stef Horner (shorner@wearearchitect.com)
	 * @param  string   $value
	 * @param  string   $key
	 * @return $this
	 */
	public function activate( $value, $key = 'link' )
	{
		if ( $this->getProperty( $key ) === $value )
		{
			$this->setActive();
		}
		else
		{
			$this->setActive( null );
		}

		foreach ($this->items as $item) {
			$item->activate( $value, $key );
		}

		return $this;
	}

	/**
	 * Determine if the menuitem is active
	 *
	 * If the active property is null (ie. hasn't been set by anything),
	 * it will test its children to bubble their state up the chain
	 *
	 * @author Stef Horner       (shorner@wearearchitect.com)
	 * @return boolean
	 */
	public function isActive()
	{
		if ( !is_null( $this->active ) )
			return $this->active;

		foreach ( $this->items as $item )
		{
			if ( $item->isActive() )
				return true;
		}

		return false;
	}

}
