
<?php /**
 * @TODO
 * - use element property, defaulting to a
 * - if element is not a, do not use link
 * - get attributes for li, implode with space
 * - if ( $item->isActive() ), add active to class
 */ ?>
{{ HTML::element( 'li', $item->getAttributes() ) }}

	{{ HTML::element( $item->getProperty('element', 'a'), $item->getAttributes(), $item['title'] ) }}

	@if( $item->getItems() )

		<ul>
			@foreach( $item->getItems() as $item )
				{{ View::make('menu::item')->with('item', $item) }}
			@endforeach
		</ul>

	@endif

</li>
