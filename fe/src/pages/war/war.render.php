<?php

class war extends FrontEnd {

	public function render($args) {
		
		// war
		$args['bodyClass'] = 'war';
		
		// id
		$slug = p('slug');	
		
		// get it 
		$args['war'] = new \dao\war('get',array('slug', $slug));
		
			// try the short code
			if ( $args['war']->id == false ) {
				
				// try again	
				$war = new \dao\war('get',array('short', $slug));
		
					// nope
					if ( $war->id == false ) { b::show_404(); }		
			
				// take them away
				$this->go( b::url('war',array('slug'=>$war->slug)) );
			
			}
		
	
		// q
		$q = array(
			'war' => $args['war']->id,
			'type' => 'offical'
		);
	
			// sides
			$args['sides'] = new \dao\sides('get',array($q));

		// q
		$q = array(
			'war' => $args['war']->id,
			'type' => 'other'
		);
	
			// sides
			$args['other'] = new \dao\sides('get',array($q,array('sort'=>array('votes'=>-1))));

		$q = array(
			'war' => $args['war']->id
		);

		// slip them up
		$args['armies'] = array();
		
		// loop and pick
		foreach ( new \dao\votes('get',array($q)) as $item ) {
			
			// asset_id
			if ( !array_key_exists($item->side, $args['armies']) ) { $args['armies'][$item->side] = array(); }
			
			// add it 
			$args['armies'][$item->side][] = $item;
			
		}
		
		// short
		$args['short'] = b::url('short',array('short'=>$args['war']->short));
	
		// return
		return Controller::renderPage(
			'war/war',
			$args
		);
	
	}


}

?>