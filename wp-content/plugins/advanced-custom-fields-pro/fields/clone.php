<?php

/*
*  ACF Clone Field Class
*
*  All the logic for this field type
*
*  @class 		acf_field_clone
*  @extends		acf_field
*  @package		ACF
*  @subpackage	Fields
*/

if( ! class_exists('acf_field_clone') ) :

class acf_field_clone extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/03/2014
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct() {
		
		// vars
		$this->name = 'clone';
		$this->label = _x('Clone', 'Field label','acf');
		$this->defaults = array(
			'clone' => '',
		);
		$this->cloning = array();
		
		
		// ajax
		add_action('wp_ajax_acf/fields/clone/query', array($this, 'ajax_query'));
		
		
		// filters
		add_filter('acf/get_fields', array($this, 'acf_get_fields'), 5, 2);
		
		
		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  acf_get_fields
	*
	*  This function will replace clone fields
	*
	*  @type	function
	*  @date	17/06/2016
	*  @since	5.3.8
	*
	*  @param	$fields (array)
	*  @param	$parent (array)
	*  @return	$fields
	*/
	
	function acf_get_fields( $fields, $parent ) {
		
		// bail early if is export
		if( acf_is_doing('export') || 
			acf_is_doing('save', 'field_group') ||
			acf_is_doing('edit', 'field_group') ) return $fields;
		
		
		// vars
		$i = 0;
		
		
		// loop
		while( $i < count($fields) ) {
			
			// vars
			$field = $fields[ $i ];
			
			
			// check if is clone
			if( $field['type'] === 'clone' ) {
				
				// get cloned fields
				$clones = $this->acf_get_cloned_fields( $field, $parent );
				
				
				// merge in $field (1 or more fields)
				array_splice($fields, $i, 1, $clones);
				
				
				// this clone field has been replaced, allow loop to see replacement field
				$i--;
				
			}
			
			
			// $i
			$i++;
			
		}
		
		
		// return
		return $fields;
		
	}
	
	
	
	/*
	*  acf_get_cloned_fields
	*
	*  This function will return an array of fields for a given clone field
	*
	*  @type	function
	*  @date	28/06/2016
	*  @since	5.3.8
	*
	*  @param	$field (array)
	*  @param	$parent (array)
	*  @return	(array)
	*/
	
	function acf_get_cloned_fields( $field, $parent ) {
		
		// vars
		$cloned = array();
		
		
		// bail early if no clone setting
		if( empty($field['clone']) ) return $cloned;
		
		
		// prevent append if is already cloning this field
		// this avoids infinite looping
		if( isset($this->cloning[ $field['key'] ]) ) return $cloned;
		
		
		// update local ref
		$this->cloning[ $field['key'] ] = 1;
		
		
		// loop
		foreach( $field['clone'] as $selector ) {
			
			// field group
			if( acf_is_field_group_key($selector) ) {
				
				// vars
				$field_group = acf_get_field_group($selector);
				$field_group_fields = acf_get_fields($field_group);
				
				
				// append
				$cloned = $cloned + $field_group_fields;
				
			// field
			} elseif( acf_is_field_key($selector) ) {
				
				// append
				$cloned[] = acf_get_field($selector);
				
			}
			
		}
		
		
		// clone fields may have been added via acf_get_field(). Ensure they are converted
		$cloned = $this->acf_get_fields( $cloned, $parent );
		
		
		// filter
		foreach( array_keys($cloned) as $i ) {
				
			$cloned[ $i ] = apply_filters('acf/clone_field', $cloned[ $i ], $field);
			 
		}
			
		
		// field has ve been loaded for this $parent, time to remove cloning ref
		unset( $this->cloning[ $field['key'] ] );
		
		
		// return
		return $cloned;
		
	}
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field - an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field( $field ) {
		
		// do nothing
		
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra options for your field. This is rendered when editing a field.
	*  The value of $field['name'] can be used (like bellow) to save extra data to the $field
	*
	*  @param	$field	- an array holding all the field's data
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*/
	
	function render_field_settings( $field ) {
		
		// default_value
		acf_render_field_setting( $field, array(
			'label'			=> _x('Clone', 'Field instruction', 'acf'),
			'instructions'	=> __('Select one or more fields you wish to clone','acf'),
			'type'			=> 'select',
			'name'			=> 'clone',
			'multiple' 		=> 1,
			'allow_null' 	=> 1,
			'choices'		=> $this->get_clone_setting_choices( $field['clone'] ),
			'ui'			=> 1,
			'ajax'			=> 1,
			'ajax_action'	=> 'acf/fields/clone/query',
			'placeholder'	=> '',
		));
		
		
	}
	
	
	/*
	*  get_clone_setting_choices
	*
	*  This function will return an array of choices data for Select2
	*
	*  @type	function
	*  @date	17/06/2016
	*  @since	5.3.8
	*
	*  @param	$value (mixed)
	*  @return	(array)
	*/
	
	function get_clone_setting_choices( $value ) {
		
		// vars
		$choices = array();
		
		
		// bail early if no $value
		if( empty($value) ) return $choices;
		
		
		// force value to array
		$value = acf_get_array( $value );
			
			
		// loop
		foreach( $value as $v ) {
			
			$choices[ $v ] = $this->get_clone_setting_choice( $v );
			
		}
		
		
		// return
		return $choices;
		
	}
	
	
	/*
	*  get_clone_setting_choice
	*
	*  This function will return the label for a given clone choice
	*
	*  @type	function
	*  @date	17/06/2016
	*  @since	5.3.8
	*
	*  @param	$selector (mixed)
	*  @return	(string)
	*/
	
	function get_clone_setting_choice( $selector = '' ) {
		
		// vars
		$title = '';
		
		
		// bail early no selector
		if( !$selector ) return $title;
		
		
		// field group
		if( acf_is_field_group_key($selector) ) {
			
			// vars
			$field_group = acf_get_field_group($selector);
			
			
			// title
			$title = sprintf( __('All fields from %s field group', 'acf'), $field_group['title'] );
		
		// field
		} elseif( acf_is_field_key($selector) ) {
			
			// vars
			$field = acf_get_field($selector);
			
			
			// title
			$title = $field['label'] ? $field['label'] : __('(no title)', 'acf');
						
			
			// append type
			$title .= ' (' . $field['type'] . ')';
			
			
			// ancestors
			$ancestors = acf_get_field_ancestors( $field );
			$title = str_repeat('- ', count($ancestors)) . $title;
			
		}
			
		
		// return
		return $title;
		
	}
	
	
	
	
	
	/*
	*  ajax_query
	*
	*  description
	*
	*  @type	function
	*  @date	17/06/2016
	*  @since	5.3.8
	*
	*  @param	$post_id (int)
	*  @return	$post_id (int)
	*/
	
	function ajax_query() {
		
		// show clone fields
		$this->enabled = false;
		
		
   		// options
   		$options = acf_parse_args($_POST, array(
			'post_id'		=> 0,
			's'				=> '',
			'nonce'			=> '',
		));
				
		
		// vars
		$json = array();
		$s = false;
		
		
		// search
		if( $options['s'] !== '' ) {
			
			// search may be integer
			$s = strval($options['s']);
			
			
			// strip slashes
			$s = wp_unslash($s);
			
		}		
		
		
		// load groups
		$field_groups = acf_get_field_groups();
		
		
		// bail early if no field groups
		if( empty($field_groups) ) die();
		
		
		// loop
		foreach( $field_groups as $field_group ) {
			
			// data
			$data = array(
				'text'		=> $field_group['title'],
				'children'	=> array()
			);
			
			
			// append all
			$data['children'][] = array(
				'id'	=> $field_group['key'],
				'text'	=> $this->get_clone_setting_choice( $field_group['key'] )
			);
			
			
			// load fields
			$fields = acf_get_fields( $field_group );
			
			
			// prepare fields
			$fields = acf_prepare_fields_for_import( $fields );

			
			// bail early if no fields
			if( !$fields ) continue;
			
			
			// loop
			foreach( $fields as $field ) {
				
				// append
				$data['children'][] = array(
					'id'	=> $field['key'],
					'text'	=> $this->get_clone_setting_choice( $field['key'] )
				);
				
			}
			
			
			// search
			if( $s !== false ) {
				
				// remove children
				foreach( $data['children'] as $i => $child ) {
					
					if( stripos($child['text'], $s) === false ) {
						
						unset( $data['children'][ $i ] );
						
					}
					
				}
				
				
				// reset array keys (fixes Select2 error)
				$data['children'] = array_values($data['children']);
				
			}
			
			
			// bail ealry if no children in this group
			if( empty($data['children']) ) continue;
			
			
			// append
			$json[] = $data;
			
		}
		
		
		// return JSON
		echo json_encode( $json );
		die();
			
	}


	
	
}

new acf_field_clone();

endif;

?>