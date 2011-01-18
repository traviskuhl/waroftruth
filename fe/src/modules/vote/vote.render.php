<?php

namespace modules;

class vote extends \FrontEnd {

	public function render($args) {
	
		// get it 
		$war = new \dao\war('get',array('id', $args['war']));
	
		// whats my string
		$str = false;
		
		// what up with ic
		$ic_c = "&#10003;"; $ic_x = "&otimes;";
		
		$w_ys = "Your Side";
		$w_nys = "Not Your Side";
		$w_p = "Pick this Side";
		
			// num
			if ( isset($args['number']) ) {
			
				// get the side
				$side = new \dao\side('get', array('id', $args['side']));
			
				// ic
				$ic_c = $ic_x = $side->number('votes');
			
				// w
				$w_ys = $w_nys = $w_p = \b::plural("vote", $ic_c);
				
			}
	
		// are we logged in
		if ( \Session::getLogged() ) {
			
			// votes
			$votes = \b::_('_votes');
			
			// did they vote in this war
			if ( isset($votes[$war->id]) AND $votes[$war->id]->side == $args['side'] ) {
				$str = "<a class='vote active' href='#'>{$ic_c}<em>{$w_ys}</em></a>";
			}
			else if ( isset($votes[$war->id]) ) {
				$str = "<a class='vote' href='#'>{$ic_x}<em>{$w_nys}</em></a>";			
			}
			
		}
		
		// nothign
		if ( $str == false ) {
			$str = "<a class='vote do-vote i{$args['side']}' href='#'>{$ic_c}<em>{$w_p}</em></a>";
		}				
	
		return \Controller::renderString($str, $args);
	
	}

}


?>