
{{-- @todo use $menu properties for ul element --}}
<ul>
	@foreach( $menu->getItems() as $item )
		{{ View::make('menu.item')->with( 'item', $item ) }}
	@endforeach
</ul>
