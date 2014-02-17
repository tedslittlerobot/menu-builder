<?php namespace Tlr\Menu;

use ArrayAccess;

/**
 * $key = 'Home';
 * $options = [
 * 	'title' => 'Menu Title', // defaults to $key
 * 	'link' => 'http://eric.com'
 * ];
 * $menu->addItem( $key, $options )
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
	 * Render Options (for the link element)
	 * @var array
	 */
	protected $options = array();

	/**
	 * Element Attributes for the list item
	 * @var array
	 */
	protected $attributes = array();

	public function __construct( $options = array(), $attributes = array() )
	{
		$this->setOptions( $options );
		$this->setAttributes( $attributes );
	}

	///// ATTRIBUTES /////

	/**
	 * Get the items attributes for HTML rendering
	 * @return array
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * Merge class => active into the atts array
	 * @return array
	 */
	public function compileAttributes()
	{
		$attributes = $this->mergeActive( $this->getAttributes() );
		$attributes = array_merge_recursive( $attributes, $this->compileOptions() );

		return $attributes;
	}

	/**
	 * Construct atts from options
	 * @return array
	 */
	public function compileOptions()
	{
		$atts = array();

		if ( $link = $this->option('link') )
		{
			$atts['href'] = $link;
		}

		if ( $key = $this->option('key') )
		{
			$atts['class'] = array( \Illuminate\Support\Str::slug($key) );
		}

		return $atts;
	}

	/**
	 * If the item is active, add a relavent class
	 * @param  array $array
	 * @return array
	 */
	public function mergeActive( array $array )
	{
		if ( ! $this->isActive() )
		{
			return $array;
		}

		return array_merge_recursive( $array, array('class' => 'active') );
	}

	/**
	 * Batch set the item's attributes
	 * @param  array   $attributes
	 * @param  boolean  $override whether to replace the array, or merge the items in to it
	 * @return $this
	 */
	public function setAttributes( array $attributes, $override = false )
	{
		if ( $override === true )
		{
			$this->attributes = array();
		}

		foreach ($attributes as $key => $value)
		{
			$this->addAttribute( $key, $value );
		}

		return $this;
	}

	/**
	 * Set an individual attribute
	 * @param  string   $key
	 * @param  mixed   $value
	 */
	public function addAttribute( $key, $value )
	{
		$this->attributes = array_merge_recursive( $this->attributes, array($key => (array) $value) );

		return $this;
	}

	///// OPTIONS /////

	/**
	 * Get the element's rendering options
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * Get an individual option
	 * @param  string   $option
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function option( $option, $default = null )
	{
		return isset( $this->options[ $option ] ) ? $this->options[ $option ] : $default;
	}

	/**
	 * Set an individual option
	 * @param  string   $key
	 * @param  mixed   $value
	 * @return $this
	 */
	public function setOption( $key, $value )
	{
		$this->options[ $key ] = $value;
		return $this;
	}

	public function setOptions( $options )
	{
		$this->options = $options;
	}

	/// ARRAY ACCESS ///

	public function offsetExists ( $key )
	{
		return isset( $this->options[ $key ] );
	}

	public function offsetGet ( $key )
	{
		return $this->option( $key );
	}

	public function offsetSet ( $key , $value )
	{
		$this->options[ $key ] = $value;
	}

	public function offsetUnset ( $key )
	{
		unset( $this->options[ $key ] );
	}

	///// ITEMS /////

	/**
	 * Get the sub menu items
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * Find an item by an arbitrary defined option (defaults to key)
	 * @param  mixed  $needle
	 * @param  string $option  the option on the property to search by
	 * @param  mixed  $default what to return if nothign is found (defaults to null)
	 * @return mixed
	 */
	public function findByKey( $needle, $option = 'key', $default = null )
	{
		foreach ($this->items as $item)
		{
			if ( $item->option( $option ) === $needle )
			{
				return $item;
			}
		}

		return $default;
	}

	/**
	 * Get the given item, creating a new one if it doesn't exist
	 * @param  string   $key
	 * @param  array    $options
	 * @return Tlr\Menu\MenuItem
	 */
	public function item( $key, $title = '', $options = array(), $attributes = array(), $index = null )
	{
		if ( $item = $this->findByKey( $key ) )
		{
			return $item;
		}

		return $this->addItem( $key, $title, $options, $attributes, $index );
	}

	/**
	 * Create a new item and add it as a sub item, overwriting any
	 * that already exist
	 * @param  string   $key
	 * @param  array    $options
	 */
	public function addItem( $key, $title = '', $options = array(), $attributes = array(), $index = null )
	{
		$item = $this->makeItem( $this->makeOptions($key, $title, $options), $this->makeAttributes( $attributes ) );

		return $this->items[ $this->getNewItemIndex( $index ) ] = $item;
	}

	/**
	 * Get the index for a new item
	 * @param  mixed $index
	 * @return mixed
	 */
	public function getNewItemIndex( $index = null )
	{
		if ( ! is_null($index) )
		{
			return $index;
		}

		$count = count($this->items);

		return $count + 1;
	}

	/**
	 * Make the options array
	 * @param  string $key
	 * @param  string $title
	 * @param  mixed  $options
	 * @return array
	 */
	public function makeOptions( $key, $title, $options )
	{
		if ( is_string( $options ) )
		{
			$options = array('link' => $options);
		}

		$options['key'] = $key;

		$options['title'] = $title;

		return $options;
	}

	/**
	 * Make the attributes array
	 * @param  string $key
	 * @param  string $title
	 * @param  mixed  $options
	 * @return array
	 */
	public function makeAttributes( $attributes )
	{
		if ( is_string( $attributes ) )
		{
			$attributes = array('class' => explode(' ', $attributes));
		}

		return (array) $attributes;
	}

	/**
	 * A function to allow for easy subclassing
	 * @return Tlr\MenuItem
	 */
	protected function makeItem( $options = array(), $attributes = array() )
	{
		return new MenuItem( $options, $attributes );
	}

	///// ACTIVE ITEMS /////

	/**
	 * Manually set the active state of the item
	 * @param  boolean  $value
	 * @return $this
	 */
	public function setActive( $value = true )
	{
		$this->active = $value;

		return $this;
	}

	/**
	 * Match if given value matches the option
	 * @param  string   $value
	 * @param  string   $key
	 * @return $this
	 */
	public function activate( $value, $key = 'link' )
	{
		if ( $this->option( $key ) === $value )
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
	 * If the active option is null (ie. hasn't been set by anything),
	 * it will test its children to bubble their state up the chain
	 *
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
