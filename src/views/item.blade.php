
{{ HTML::element( 'li', $item->compileAttributes() ) }}

	@if( $item->option('link') )
		{{ HTML::element( $item->option('element', 'a'), array('href' => $item->option('link')), $item->option('title') ) }}
	@else
		{{ HTML::element( $item->option('element', 'a'), array(), $item->option('title') ) }}
	@endif

	@if( $item->hasItems() )

		<ul>
			@foreach( $item->getItems() as $subItem )
				{{ View::make('menu::item')->with('item', $subItem) }}
			@endforeach
		</ul>

	@endif

</li>
