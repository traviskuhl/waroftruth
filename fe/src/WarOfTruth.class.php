<?php

class WarOfTruth extends Bolt {

	public static function start() {	
		
		// pick
		b::__('_pic', function($id, $size='square'){
			return "http://graph.facebook.com/{$id}/picture?type={$size}";
		}, true);
		
		// likes
		if ( Session::getLogged() ) {
			
			b::__('_fb', \Ext\Fb::singleton(), true);
			
			// get it 
			$q = array(
				"user" => b::_("_user")->id
			);
		
			// votes
			$votes = array();	
			
			// go for it 
			foreach ( new \dao\votes('get',array($q)) as $item ) {
				$votes[$item->war] = $item;
			}
			
			// set it 
			b::__('_votes', $votes, true);
		
		}
	
	}

}

?>