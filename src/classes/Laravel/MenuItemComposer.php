<?php namespace Tlr\Menu\Laravel;

class MenuItemComposer {

	public function compose( $view ) {

		if ( ! isset( $view->item ) )
			throw new \Exception('The view must be called with an "item" property');

		$item = $view->item;

	}

}
