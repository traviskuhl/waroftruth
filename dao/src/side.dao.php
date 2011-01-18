<?php

namespace Dao;

class side extends Mongo {
	
	// we want to track added & modified
	protected $_useAddedTimestamp = true;
	protected $_useModifiedTimestamp = true;

	// struct
	protected function getStruct() {
		return array(
			'id'		=> array( 'type' => 'uuid' ),
			'user'		=> array( 'type' => 'user' ),
			'war'		=> array( 'type' => 'dao', 'class' => 'war', 'args' => array('id', '$war')),
			'text'		=> array(),
			'votes'		=> array(),
			'tags' 		=> array( 'type' => 'tags' ),
			'type'		=> array()
		);
	}


	public function get($by, $val) {
	
		// lets get it 
		$q = array( $by => $val );
	
		// do ti 
		$row = $this->row('sides', $q);
	
			// no row
			if ( !$row ) { return false; }
	
		// set it bitch
		$this->set($row);
	
	}
	
	public function set($row) {

		// set as a parent
		parent::set($row);
		
		// set it 
		$this->_data['f_votes'] = number_format((int)$row['votes']);
		
	}
	
	public function save() {
	
		// data
		$data = $this->normalize();
		
		// no
		$id = $data['_id']; unset($data['_id']);		
		
		// save it 
		try {
			$this->update('sides', array("_id" => $id), array('$set' => $data), array('upsert'=>true));			
		}
		catch (MongoCursorException $e) {
			return false;
		}
		
		// save id 
		$this->id = $id;
	
		// return id
		return $id;
	
	}

	public function increment($by=1) {
	
		// up it 
		$this->update('sides', array("_id" => $this->id), array('$inc' => array('votes'=>$by)));			
		
		// votes
		$r = $this->row("sides", array("_id" => $this->id), array('fields'=>array('votes'=>1)));
		
		// give it 
		return $r['votes']; 
		
	}

}

?>