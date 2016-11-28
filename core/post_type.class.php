<?php

class PostType{

	protected $labels = array();
	protected $arguments = array();


	public function __construct($name, $slug){
		$this->name = $name;
		$this->slug = $slug;

		add_action( 'init', array( &$this, 'register_post_type' ) );
	}


	public function set_labels( $labels = array() ) {
		$this->labels = $labels;
	}

	protected function labels() {
		$default = array(
			'name'               => $this->name,
			'singular_name'      => $this->name,
			'all_items'          => 'Listar Todos'
		);

		return array_merge( $default, $this->labels );
	}

	public function set_arguments( $arguments = array() ) {
		$this->arguments = $arguments;
	}

	protected function arguments() {
		$default = array(
			'labels'              => $this->labels(),
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'public'              => true,
			'rewrite'             => array('slug' => $this->slug)
		);
		return array_merge( $default, $this->arguments );
	}

	public function register_post_type() {
		register_post_type( $this->slug, $this->arguments() );
	}
}
