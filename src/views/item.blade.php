
{{ HTML::element( 'li', $item->getOutputAttributes() ) }}

	{{ HTML::element( $item->getProperty('element', 'a'), $item->getElementAttributes(), $item['title'] ) }}

	@if( $item->getItems() )

		<ul>
			@foreach( $item->getItems() as $item )
				{{ View::make('menu::item')->with('item', $item) }}
			@endforeach
		</ul>

	@endif

</li>
