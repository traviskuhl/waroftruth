<?php

namespace Dao;

class war extends Mongo {
	
	// we want to track added & modified
	protected $_useAddedTimestamp = true;
	protected $_useModifiedTimestamp = true;

	// struct
	protected function getStruct() {
		return array(
			'id'		=> array( 'type' => 'uuid' ),
			'user'		=> array( 'type' => 'user' ),
			'slug'		=> array( ),
			'text'		=> array( ),
			'votes'		=> array( ),
			'tags' 		=> array( 'type' => 'tags' ),
			'invite'	=> array( ),
			'short' 	=> array( )
		);
	}


	public function get($by, $val) {
	
		// id
		if ( $by == 'id' ) { $by = '_id'; }		
	
		// lets get it 
		$q = array( $by => $val );
	
		// do ti 
		$row = $this->row('wars', $q);
	
			// no row
			if ( !$row ) { return false; }
	
		// set it bitch
		$this->set($row);
	
	}
	
	public function set($row) {

		// set as a parent
		parent::set($row);
		
	}
	
	public function save() {
	
		// data
		$data = $this->normalize();
		
		// no
		$id = $data['_id']; unset($data['_id']);		
		
		// save it 
		try {
			$this->update('wars', array("_id" => $id), array('$set' => $data), array('upsert'=>true));			
		}
		catch (MongoCursorException $e) {
			return false;
		}
		
		// save id 
		$this->id = $id;
	
		// return id
		return $id;
	
	}

	public function generateShortId() {
	
		$db = \Database::singleton();
	
		// lock a table
		$db->query(" LOCK TABLES `short_id` ");
	
		// run it 
		$db->query(" UPDATE `short_id` SET id = id + 1 ");
	
		// get it 
		$row = $db->row(" SELECT id from short_id");
	
		// unlock
		$db->query("UNLOCK TABLES");
	
		// return 
		return (string)base_convert((int)$row['id'], 10, 36);
	
	}
	
}

?>