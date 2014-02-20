
{{ HTML::element( 'li', $item->compileAttributes() ) }}

	{{ HTML::element( $item->option('element', 'a'), ['href' => $item->option('link')], $item->option('title') ) }}

	@if( $item->hasItems() )

		<ul>
			@foreach( $item->getItems() as $subItem )
				{{ View::make('menu::item')->with('item', $subItem) }}
			@endforeach
		</ul>

	@endif

</li>
