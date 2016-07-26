<?php 

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists('acf_cache') ) :

class acf_cache {
	
	
	/*
	*  __construct
	*
	*  This function will setup the class functionality
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.4.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->cache = array();
		$this->reference = array();
		$this->hits = array();
		$this->misses = array();
		
		
		// testing
		//add_action('shutdown', array($this, 'shutdown'));
		
	}
	
	
	/*
	*  get_key
	*
	*  This function will check for references and modify the key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @return	$key
	*/
	
	function get_key( $key = '' ) {
		
		// check for reference
		if( isset( $this->reference[ $key ] ) ) {
			
			$key = $this->reference[ $key ];
				
		}
		
		
		// return
		return $key;
		
	}
	
	
	
	/*
	*  isset_cache
	*
	*  This function will return true if a cached data exists for teh given key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @return	(boolean)
	*/
	
	function isset_cache( $key = '' ) {
		
		// vars
		$key = $this->get_key($key);
		
		
		// isset
		$isset = isset( $this->cache[ $key ] );
		
		
		if( $isset ) {
			
			$this->hits[] = $key;
			
		} else {
			
			$this->misses[] = $key;
			
		}
		
		
		// return
		return $isset;
		
	}
	
	
	/*
	*  get_cache
	*
	*  This function will return cached data for a given key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @return	(mixed)
	*/
	
	function get_cache( $key = '' ) {
		
		// vars
		$key = $this->get_key($key);
		$data = null;
		
			
		// check cache
		if( isset( $this->cache[ $key ] ) ) {
			
			$data = $this->cache[ $key ];
			
		}
		
		
		// return
		return $data;		
		
	}
	
	
	/*
	*  set_cache
	*
	*  This function will set cached data for a given key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @param	$data (mixed)
	*  @return	n/a
	*/
	
	function set_cache( $key = '', $data = '' ) {
		
		$this->cache[ $key ] = $data;	
		
		return $key;
	}
	
	
	/*
	*  set_cache_reference
	*
	*  This function will set a reference to cached data for a given key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @param	$reference (string)
	*  @return	n/a
	*/
	
	function set_cache_reference( $key = '', $reference = '' ) {
		
		$this->reference[ $key ] = $reference;	
		
		return $key;
		
	}
	
	
	/*
	*  delete_cache
	*
	*  This function will delete cached data for a given key
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @return	n/a
	*/
	
	function delete_cache( $key = '' ) {
		
		unset( $this->cache[ $key ] );
		
	}
	
	
	/*
	*  flush_cache
	*
	*  This function will delete all cached data
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	$key (string)
	*  @return	n/a
	*/
	
	function flush_cache() {
		
		$this->cache = array();
		$this->reference = array();
		
	}
	
	
	/*
	*  shutdown
	*
	*  Function used to log cache data
	*
	*  @type	function
	*  @date	30/06/2016
	*  @since	5.4.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function shutdown() {
		
		// bail early if is ajax
		if( acf_is_ajax() ) return;
		
		
		acf_log('--- ACF Cache ---');
		acf_log('Cache count: ', count($this->cache));
		acf_log('Reference count: ', count($this->reference));
		
		
		acf_log('Hits count: ', count($this->hits));
		
		foreach( $this->hits as $hit ) {
			
			acf_log('- ', $hit);
			
		}
		
		
		acf_log('Misses count: ', count($this->misses));
		
		foreach( $this->misses as $miss ) {
			
			acf_log('- ', $miss);
			
		}
		
		
		acf_log('-----------------');
		
	}
	
}


// globals
global $acf_cache;


// initialize
$acf_cache = new acf_cache();


endif; // class_exists check



/*
*  acf_isset_cache
*
*  alias of $acf_cache->isset_cache()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_isset_cache( $key = '' ) {
	
	global $acf_cache;
	
	return $acf_cache->isset_cache( $key );
	
}


/*
*  acf_get_cache
*
*  alias of $acf_cache->get_cache()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_get_cache( $key = '' ) {
	
	global $acf_cache;
	
	return $acf_cache->get_cache( $key );
	
}


/*
*  acf_set_cache
*
*  alias of $acf_cache->set_cache()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_set_cache( $key = '', $data ) {
	
	global $acf_cache;
	
	return $acf_cache->set_cache( $key, $data );
	
}


/*
*  acf_set_cache_reference
*
*  alias of $acf_cache->set_cache_reference()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_set_cache_reference( $key = '', $reference = '' ) {
	
	global $acf_cache;
	
	return $acf_cache->set_cache_reference( $key, $reference );
	
}


/*
*  acf_delete_cache
*
*  alias of $acf_cache->delete_cache()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_delete_cache( $key = '' ) {
	
	global $acf_cache;
	
	return $acf_cache->delete_cache( $key );
	
}


/*
*  acf_flush_cache
*
*  alias of $acf_cache->flush_cache()
*
*  @type	function
*  @date	30/06/2016
*  @since	5.4.0
*
*  @param	n/a
*  @return	n/a
*/

function acf_flush_cache() {
	
	global $acf_cache;
	
	return $acf_cache->flush_cache();
	
}

?>