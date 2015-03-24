
{{ app('html')->element( 'ul', $menu->getAttributes() ) }}
	@foreach( $menu->getItems() as $item )
		{{ app('view')->make('menu::item')->with( 'item', $item )->render() }}
	@endforeach
</ul>
