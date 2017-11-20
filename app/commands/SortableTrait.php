<?php
trait SortableTrait {
	public function scopeSortable($query) {
		if(Input::has('s') && Input::has('o'))
			return $query->orderBy(Input::get('s'), Input::get('o'));
		else
			return $query;
	}
		 
	public static function link_to_sorting_action($col, $title = null) {
		if (is_null($title)) {
			$title = str_replace('_', ' ', $col);
			$title = ucfirst($title);
		}
		$page = Input::get('page');
		$indicator = (Input::get('s') == $col ? (Input::get('o') === 'asc' ? '&uarr;' : '&darr;') : null);
		$parameters = array_merge(Route::getCurrentRoute()->parameters(), array('s' => $col, 'o' => (Input::get('o') === 'asc' ? 'desc' : 'asc')));
		
		return link_to_route(Route::currentRouteName(), "$title $indicator", $parameters);
	}
	
	
	public function scopeSortable2($query) {
		if(Input::has('p') && Input::has('q'))
			return $query->orderBy(Input::get('p'), Input::get('q'));
		else
			return $query;
	}
		 
	public static function link_to_sorting_action2($col, $title = null) {
		
		if (is_null($title)) {
			$title = str_replace('_', ' ', $col);
			$title = ucfirst($title);
		}
		$page = Input::get('page');
		$indicator = (Input::get('p') == $col ? (Input::get('q') === 'asc' ? '&uarr;' : '&darr;') : null);
		$parameters = array_merge(Route::getCurrentRoute()->parameters(), array('p' => $col, 'q' => (Input::get('p') === 'asc' ? 'desc' : 'asc')));
		
		return link_to_route(Route::currentRouteName(), "$title $indicator", $parameters);
	}
	
	
}