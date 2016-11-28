<?php
class Helper {

	private $pluginMessage;

	public function checkDependencies($file, $message){

		if( !is_plugin_active( $file ) ) {
			$this->pluginMessage = $message;
		  	add_action( 'admin_notices', $this->dependenciesPluginError() );
		  	echo 'ferrou';
		}
	}

	public function dependenciesPluginError() {
        echo '<div class="error notice">';
        echo '<p>'. $this->pluginMessage . '</p>';
        echo '</div>';
    }


	public function createPostType($postTypes){
		foreach ($postTypes as $postType) {
			unset($postType['suport']['tags']);
			if(isset($postType['rewrite'])){
    			$rewrite = $postType['rewrite'];
    		}else{
    			$rewrite = $postType['slug'];
    		}
			$params = array(
			            'labels' => array(
			                'name' => __( $postType['name'] ), //nome que ira aparecer na tela
			                'singular_name' => __( $postType['singular'] ), //esse eu nao sei pra que serve ... :)
			                'all_items' => __('Listar Todos'), // listar todos menu
			            ),
			            'public' => true, //nao altera
			            'supports' => $postType['suport'],
			            'rewrite' => array('slug' => $rewrite)
			        );
			register_post_type($postType['slug'], $params);
			if(isset($postType['taxonomy'])){
		    	foreach ($postType['taxonomy'] as $taxonomy) {
		    		if(isset($taxonomy['rewrite'])){
		    			$rewrite = $taxonomy['rewrite'];
		    		}else{
		    			$rewrite = $taxonomy['slug'];
		    		}
		    		register_taxonomy( $taxonomy['slug'], //Nome da categoria
				        array( $postType['slug'] ), //post type de referencia
				        array(
				          'hierarchical' => true, //padrao
				          'label' => __( $taxonomy['name'] ), //Nome que aparecera no menu
				          'show_ui' => true, //padrao
				          'show_in_tag_cloud' => true, //padrao
				          'query_var' => true, //padrao
				          'rewrite' => array(
				             'slug' => $taxonomy['rewrite'] //slug (nome de referencia) da categoria
				            ),
				        )
				    );
		    	}
		    }
		}
	}

}
