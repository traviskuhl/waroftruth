<?php

namespace Dao;

class votes extends Mongo  {

	// we want to track added & modified
	protected $_useAddedTimestamp = true;
	protected $_useModifiedTimestamp = true;

	// struct
	protected function getStruct() {
		return array(
			'user'		=> array( 'type' => 'user' ),
			'war'		=> array( ),
			'side'		=> array( )
		);
	}


	public function get($q=array(), $args=array()) {
	 	 
		// query
		$sth = $this->query('votes', $q, $args);
			
		// give it back
		foreach ( $sth as $e ) {
			$this->_items[] = new voteItem('set', $e);
		}
		
		$this->setPager(count($this->_items),1,9999);
	
	}

	public function save() {

		// data
		$data = $this->normalize();
		
		// id
		$id = md5($data['user'].$data['war'].$data['side']);
		
		// do it 
		$q = array(
			'_id' => $id,
			'user' => $data['user'],
			'war' => $data['war'],
			'side' => $data['side']
		);
		
		// save it 
		try {
			$r = $this->insert('votes', $q, array('safe'=>true));			
		}
		catch (\MongoCursorException $e) {
			return false;
		}
		
		// save id 
		$this->id = $id;
	
		// return id
		return $id;	
	
	}
	
}

class voteItem extends \Dao {

	// struct
	protected function getStruct() {
		return array(
			'user'		=> array( 'type' => 'user' ),
			'war'		=> array( ),
			'side'		=> array( )
		);
	}

}

?>