<?php

namespace Dao;

class sides extends Mongo  {

	public function get($q=array(), $args=array()) {
	 
	 	// fields
	 	$args['fields'] = array( '_id' => 1 ); 
	 
		// query
		$sth = $this->query('sides', $q, $args);
			
		// give it back
		foreach ( $sth as $e ) {
			$this->_items[] = new side('get', array('id', $e['_id']));
		}
		
		$this->setPager(count($this->_items),1,999);
	
	}

}

?>