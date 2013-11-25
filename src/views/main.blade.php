
{{ HTML::element( 'ul', $menu->getAttributes() ) }}
	@foreach( $menu->getItems() as $item )
		{{ View::make('menu::item')->with( 'item', $item )->render() }}
	@endforeach
</ul>
