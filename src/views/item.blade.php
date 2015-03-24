
{!! app('html')->element( 'li', $item->compileAttributes() ) !!}

	@if( $item->option('link') )
		{!! app('html')->element( $item->option('element', 'a'), array('href' => $item->option('link')), $item->option('title') ) !!}
	@else
		{!! app('html')->element( $item->option('element', 'a'), array(), $item->option('title') ) !!}
	@endif

	@if( $item->hasItems() )

		<ul>
			@foreach( $item->getItems() as $subItem )
				{!! app('view')->make('menu::item')->with('item', $subItem) !!}
			@endforeach
		</ul>

	@endif

</li>
