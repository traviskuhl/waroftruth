<?php

namespace Dao;

class wars extends Mongo  {

	public function get($q=array(), $args=array()) {
	 
	 	// fields
	 	$args['fields'] = array( '_id' => 1 ); 
	 
		// query
		$sth = $this->query('wars', $q, $args);
			
		// give it back
		foreach ( $sth as $e ) {
			$this->_items[] = new war('get',array('id', $e['_id']));
		}
		
		$this->setPager(count($this->_items),1,999);
	
	}

}

?>