<?php

class index extends FrontEnd {

	public function render($args) {		
		
		// act
		$act = p('act');
	
		switch($act) {
		
			case 'invite':
				return $this->invite($args);
				
			case 'login':
			case 'logout':
				return $this->dolog($args, $act);	
				
			default:
				return $this->idx($args);
		};
		
	}
	
	public function dolog($args, $act) {

		// session
		$s = Session::singleton();
		
		// logout
		if ( $act == 'logout' ) {
			
			// do it
			$s->logout();
			
			// go
			$this->go( b::url('index') );
			
		}
		
		// login
		$user = $s->register(false, 'facebook');		
	
		// no user just die
		if ( $user->id == false ) { die('not a good user'); }	
	
		// go
		$this->go( b::url('index') );	
	
	}
	
	public function idx($args) {
	
		// index
		$args['bodyClass'] = 'index';	
	
		// logged in
		if ( p('do') == 'submit' ) {
			
			// form
			$f = p('f');				
			
			// arument
			$argument = trim(p('argument', false, $f));
			$text = trim(p('side', false, $f));
			
				// nope
				if ( !p('invite') AND p('type') != 'other' AND ( !$argument OR !$text ) ) { 
					$_REQUEST['do'] = false; return $this->idx(array('msg'=>"You must enter an Argument and Side.")); 
				}
			
			// seesion
			$s = Session::singleton();
			
			// user
			$user = b::_('_user');
		
			// check if they have a session
			if ( !$s->logged ) {
			
				// check to see if we can log them in	
				$user = $s->register(false, 'facebook');
			
				// no user just die
				if ( $user->id == false ) { die('not a good user'); }
			
			}
		
		
			// check for an invite
			if ( p('invite') ) { 

				// see if this slug exists already
				$war = new \dao\war('get',array('id', p('id')));		
		
				// update the war with a used invite
				$war->invite = false;
				
				// save it 
				$war->save();
		
			}
			else if ( p('type') == 'other' ) {
			
				// see if this slug exists already
				$war = new \dao\war('get',array('id', p('id')));		
							
			}
			else {
			
				// lets create a slug
				$slug = b::makeSlug( b::short( trim(strtolower($argument)), 50) );		
			
				// see if this slug exists already
				$war = new \dao\war('get',array('slug', $slug));
				
						// if yes
						if ( $war->id ) { $slug .= '-'.$user->username; }							
	
					// alright lets save it 
					$war->slug = $slug;
					$war->user = $user->id;
					$war->text = $argument;
					$war->votes = 1;
					
					// get it short
					$war->short = $war->generateShortId();
				
					// save it 
					$war->save();
					
			}
			
			// now create their side
			$side = new \dao\side();
			
				// set it 
				$side->user = $user->id;
				$side->text = $text;
				$side->war = $war->id;
				$side->votes = 1;
				$side->type = (p('type')!=false ? 'other' : 'offical');
		
				// save
				$side->save();
				
			// like it
			$l = new \dao\votes();		
		
				// set some stuff
				$l->war = $war->id;
				$l->side = $side->id;
				$l->user = $user->id;		
				
				// save
				$l->save();		
				
			// go awaty	
			$url = b::url('war',array('slug'=>$war->slug), array('posted'=>'true')) . "#s" . $side->id;	
				
			// go there now
			$this->go( $url );
		
		}
		
		// get some wars
		$cfg = array(
			'sort' => array('added'=>-1),
			'per' => 10
		);
		
		// do it 
		$args['wars'] = new \dao\wars('get',array(array(), $cfg));
			
		// stream
		$args['stream'] = array();
		
			// wars
			foreach ( $args['wars'] as $item ) {
				$args['stream'][] = array(
					'ts' => $item->added,
					'text' => "<strong>{$item->user->name}</strong> started the argument <strong>\"".$item->short('text', 40).'"</strong>',
					'link' => b::url('war', array('slug'=>$item->slug)),
					'pic' => $item->user->profile->fbid
				);
			}

			// votes
			foreach ( new \dao\votes('get',array(array(), $cfg)) as $item ) {
				$side = new \dao\side('get',array('id', $item->side));
								
				$args['stream'][] = array(
					'ts' => $item->added,
					'text' => "<strong>{$item->user->name}</strong> voted for <strong>".$side->user->possessive('name')."</strong> side in <strong>\"".$side->war->short('text', 40).'"</strong>',
					'link' => b::url('war', array('slug'=>$side->war->slug)),
					'pic' => $item->user->profile->fbid
				);
			}
			
			// votes
			foreach ( new \dao\sides('get',array(array(), $cfg)) as $item ) {
				$args['stream'][] = array(
					'ts' => $item->added,
					'text' => "<strong>{$item->user->name}</strong> added their side the argument <strong>\"".$item->war->short('text', 40).'"</strong>',
					'link' => b::url('war', array('slug'=>$item->war->slug)),
					'pic' => $item->user->profile->fbid
				);
			}			
		
		// sort it 
		usort($args['stream'], function($aa,$bb){
			$a = $aa['ts']; $b = $bb['ts'];
		    if ($a == $b) {
		        return 0;
		    }
		    return ($a > $b) ? -1 : 1;		
		});
		
		// return redner
		return Controller::renderPage(
			"index/index",
			$args
		);
	
	}
	
	public function invite($args) {
		
		// index
		$args['bodyClass'] = 'index';		
		
		// not logged in
		if ( !Session::getLogged() ) {
			return Controller::renderString(
				"You must be logged in to invite someone",
				$args
			);
		}
		
		// war
		$war = $args['war'] = new \dao\war('get',array('id', p('war')));
		
			// not the right person
			if ( b::_('user')->id != $war->user->id ) {
				return Controller::renderString(
					"You didn't start this war.",
					$args
				);		
			}
	
	
		// submit
		if ( p('do') == 'submit' ) {
		
			// to and message
			$to = p('to', false, $_POST, FILTER_VALIDATE_EMAIL);
			$msg= p('msg');		
		
			// not the right person
			if ( $war->invite !== false AND strtolower($to) == strtolower($war->invite->to) ) {
				return Controller::renderString(
					"You can't send an invite to the same email twice",
					$args
				);		
			}		
		
			// invite
			$invite = md5( uniqid(time()) );
		
			// save their invite
			$war->invite = array('id' => $invite, 'to' => $to, 'ts' => time() ); 
			
			// save
			$war->save();
		
			// user
			$user = b::_("_user");	
			
			// url
			$url = b::url('war',array('slug'=>$war->slug),array('invite'=>$invite));
		
			// message
			$message = "Hello from War of Truth\n\n" .
					   "{$user->name} started an argument with you:\n{$war->text}\n\n".
					   "{$user->firstname} said:\n{$msg}\n\n".
					   "You must tell your side of the argument. Head to {$url}";
		
			// sned
			$r = $this->sendEmail(array(
				'username' => 'send@kuhl.co',
				'password' => "a5253bcce1da",
				'to' => $to,
				'subject' => "{$user->name} has challenged you on WarOfTruth.com",
				'from' => 'War of Truth <send@kuhl.co>',
				'message' => $message,
				'reply' => "send+waroftruth-".$war->id."@kuhl.co"
			));	
			
			// done
			$args['done'] = true;
		
		}
	
		return Controller::renderPage(
			"index/invite",
			$args
		);
	
	}
	
	// ajax
	public function ajax() {
	
		// act
		$act = pp(0);
	
		// vote
		if ( $act == 'vote' ) {
			
			// make sure they're logged in
			// seesion
			$user = Session::getUser();
		
			// check if they have a session
			if ( !Session::getLogged() ) {
			
				// check to see if we can log them in	
				$user = Session::singleton()->register(false, 'facebook');
			
				// no user just die
				if ( $user->id == false ) { return array('logged'=>false); }
			
			}
		
			// get the side
			$side = new \dao\side('get',array('id', p('id')));			
		
				// no user just die
				if ( $side->id == false ) { return array('no_side'=>true); }		
			
			// like it
			$l = new \dao\votes();		
		
			// set some stuff
			$l->war = $side->war->id;
			$l->side = $side->id;
			$l->user = $user->id;
		
			// nope
			$n = false;
		
			// result
			if ( ($r = $l->save()) !== false ) {			
			
				// incr
				$n = $side->increment();
				
			}
		
			// tell them
			return array('num'=>$n);
		
		}
	
	}

}


?>