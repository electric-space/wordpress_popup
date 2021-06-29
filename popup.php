<?php
    
    /**
     * load scripts
     */
    function popup_scripts() {

        //CSS
    	wp_enqueue_style( "popup_styles", get_template_directory_uri().'/wordpress_pop-up/pop-style.css', 0, '1.1', 'screen');
    
        // SCRIPT
    	wp_enqueue_script( "popup_script", get_template_directory_uri().'/wordpress_pop-up/popup.js', array('jquery'), '1.1', 1);

    }
    
    add_action( 'wp_enqueue_scripts', 'popup_scripts' );
    
    
    
    /**
     * setup post type
     */

    function add_popup_type() {
    
    	$txtdomain = 'holbrookacademy';
    
    
        $labels = array(
    		'menu_name' => __( 'Popups', $txtdomain ),
    	);
    
    	$args = array(
    		'label'        => __( 'Popups', $txtdomain ),
    		'public'       => true,
    		'has_archive'  => true,
    		'supports'     => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'page-attributes'),
    		'rewrite'      => array('slug' => 'popup'),
    		'has_archive'  => false,
    		'hierarchical' => true,
    	);
    
    	register_post_type( 'popups_cpt', $args );
    	
    }
    
    add_action( 'init', 'add_popup_type', 0 );
    
    
    
    /**
     * Add custom field to turn off pop up
     */
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
    	'key' => 'group_5ced418fb3635',
    	'title' => 'Popup',
    	'fields' => array(
    		array(
    			'key' => 'field_5ced419654011',
    			'label' => 'Activate Popup',
    			'name' => 'activate_popup',
    			'type' => 'checkbox',
    			'instructions' => '',
    			'required' => 0,
    			'conditional_logic' => 0,
    			'wrapper' => array(
    				'width' => '',
    				'class' => '',
    				'id' => '',
    			),
    			'choices' => array(
    				'true' => 'Active',
    			),
    			'allow_custom' => 0,
    			'default_value' => false,
    			'layout' => 'vertical',
    			'toggle' => 0,
    			'return_format' => 'value',
    			'save_custom' => 0,
    		),
    	),
    	'location' => array(
    		array(
    			array(
    				'param' => 'post_type',
    				'operator' => '==',
    				'value' => 'popups_cpt',
    			),
    		),
    	),
    	'menu_order' => 0,
    	'position' => 'side',
    	'style' => 'default',
    	'label_placement' => 'top',
    	'instruction_placement' => 'label',
    	'hide_on_screen' => '',
    	'active' => true,
    	'description' => '',
    ));
    
    endif;
    
    
    
    /**
     * write popup to page
     */
    function home_check() {
        
        if(is_front_page() && is_user_logged_in() ){ 
            
            echo "\r\n";
                
                if( !isset($_GET['nopop']) ):
        
                    $popup = get_posts( 
                        array(
                            'post_type'      => 'popups_cpt',
                            'posts_per_page' => 1,
                            'meta_query' => array(
                                array(
                                    'key'     => 'activate_popup',
                                    'value'   => 'true',
                                    'compare' => 'LIKE'
                                )
                            )
                        )
                    );
                    
                    if( $popup ):
                    
                    
                        foreach( $popup as $pop ):?>
                                        
                            <div class="popup--wrapper">
                                
                                <div class="inner">
                                    <a href="#" class="close--popup" uk-icon="icon: close"></a>
                                    <div class="popup--copy">
                                        <?php  echo do_shortcode( apply_filters('the_content', $pop->post_content) );?>
                                        
                                                          
                                    </div>
                                    
                                </div>
                            </div>
                        
                        
                        <?php endforeach;
                        
                    endif;
                
                endif;
            
            echo "\r\n";
            
        }
        
    }
    
    add_action( 'wp_footer', 'home_check' );
    
    
    
    /**
     * Add activation to admin columns
     */
    
    function pop_page_columns($columns){
        $columns = array(
            'cb'         => '<input type="checkbox" />',
            'title'     => 'Title',
            'first'     => 'Activated',
            'date'      =>    'Date',
        );
        return $columns;
    }
    
    function pop_custom_columns($column){
        global $post;
        
        if ($column == 'first') {
            if( $activated = get_field( "activate_popup", $post->ID ) ){
                echo '<span style="display:block; width:12px; height:12px; border-radius:50%; background:#7ad03a; margin-top:3px;"></span>';
            }else{
                echo '<span style="display:block; width:12px; height:12px; border-radius:50%; background:#888; margin-top:3px;"></span>';
            }
        }
       
    }
    
    add_action("manage_popups_cpt_posts_custom_column", "pop_custom_columns");
    add_filter("manage_popups_cpt_posts_columns", "pop_page_columns");
    
    
    
    
    
    
    
    
