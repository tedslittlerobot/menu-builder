<?php namespace Tlr\Menu;

use ArrayAccess;

/**
 * $key = 'Home';
 * $properties = [
 * 	'title' => 'Menu Title', // defaults to $key
 * 	'link' => 'http://boobs.com',
 * 	'class' => 'woop',
 * ];
 * $menu->addItem( $key, $properties )
 */
class MenuItem implements ArrayAccess {

	protected $active = false;

	protected $items = array();

	protected $properties = array();

	protected $attributes = array();

	public function __construct( $properties = array() ) {
		$this->properties = $properties;
	}

	public function getItems() {
		return $this->items;
	}

	public function item( $key, $properties = array() ) {
		if ( isset( $this->items[ $key ] ) )
			return $this->items[ $key ];

		return $this->addItem( $key, $properties );
	}

	public function getAttributes()
	{
		return $this->attributes;
	}

	public function setAttributes( $attributes, $merge = false )
	{
		$this->attributes = ( $merge ? array_merge($this->attributes, $attributes) : $attributes );
		return $this;
	}

	public function addAttribute( $key, $value )
	{
		$this->attributes[ $key ] = $value;

		return $this;
	}

	public function getProperties( ) {
		return $this->properties;
	}

	public function addItem( $key, $properties = array() ) {
		$properties = array_merge( [ 'title' => $key ], $properties );

		return $this->items[ $key ] = new MenuItem( $properties );
	}

	public function getProperty( $property, $default = false ) {
		return isset( $this->properties[ $property ] ) ? $this->properties[ $property ] : $default;
	}

	public function setProperty( $key, $value ) {
		$this->properties[ $key ] = $value;
	}

	public function render() {
		return 'MENU';
	}

	public function __toString() {
		return (string) $this->render();
	}

	/// ARRAY ACCESS ///

	public function offsetExists ( $key ) {
		return isset( $this->properties[ $key ] );
	}

	public function offsetGet ( $key ) {
		return $this->getProperty( $key );
	}

	public function offsetSet ( $key , $value ) {
		$this->properties[ $key ] = $value;
	}

	public function offsetUnset ( $key ) {
		unset( $this->properties[ $key ] );
	}

	public function isActive()
	{
		if ( $this->active === true )
			return true;

		foreach ( $this->items as $item )
		{
			if ( $item->isActive() )
				return true;
		}

		return false;
	}

	public function setActive( $value = true )
	{
		$this->active = $value;

		return $this;
	}

	public function activate( $value, $key = 'link' )
	{
		if ( $this->getProperty( $key ) == $value )
		{
			$this->setActive();
		}

		return $this;
	}

}
