
<?php
	$classstring = '';
?>

@if( $item['class'] )
	<?php $classstring = ' class="' . implode(' ', $item['class'] ). '"'; ?>
@endif
<?php /**
 * @TODO
 * - use element property, defaulting to a
 * - if element is not a, do not use link
 * - get attributes for li, implode with space
 * - if ( $item->isActive() ), add active to class
 */ ?>
<li{{ $classstring }}>

	@if( $item['link'] )
		<a href="{{ $item['link'] }}">
	@endif

		{{ $item['title'] }}

	@if( $item['link'] )
		</a>
	@endif

	@if( $item->getItems() )

		<ul>
			@foreach( $item->getItems() as $item )
				{{ View::make('menu.item')->with('item', $item) }}
			@endforeach
		</ul>

	@endif

</li>
