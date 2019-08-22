<?php


function elementor_product_cat_list( ) {
 
    $term_id = 'product_cat';
    $categories = get_terms( $term_id );
 
    $cat_array['all'] = "All Categories";

    if ( !empty($categories) ) {
        foreach ( $categories as $cat ) {
            $cat_info = get_term($cat, $term_id);
            $cat_array[ $cat_info->slug ] = $cat_info->name;
        }
    }
 	//print_r($cat_array);
    return $cat_array;
}


class Elementor_Products_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'elementorProducts';
	}


	public function get_title() {
		return __( 'ElementorProducts', 'elementor-custom-widgets' );
	}


	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	protected function _register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementor-custom-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'limit', [
				'label' => __( 'Products limit', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '4' , 'elementor-custom-widgets' ),
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'options' => [
					'1'  => __( '1 column', 'elementor-custom-widgets' ),
					'2' => __( '2 columns', 'elementor-custom-widgets' ),
					'3' => __( '3 columns', 'elementor-custom-widgets' ),
					'4' => __( '4 columns', 'elementor-custom-widgets' ),
				],
			]
		);


		/******* Manual system for displaying categories *****/
		// $this->add_control(
		// 	'category',
		// 	[
		// 		'label' => __( 'Select Categories', 'elementor-custom-widgets' ),
		// 		'type' => \Elementor\Controls_Manager::SELECT2,
		// 		'multiple' => true,
		// 		'options' =>  [
		// 			'hoodies'  => __( 'Hoodies', 'elementor-custom-widgets' ),
		// 			'tshirts' => __( 'Tshirts', 'elementor-custom-widgets' ),
		// 			'accessories' => __( 'Accessories', 'elementor-custom-widgets' ),
		// 		],
		// 		'default' => [ 'hoodies' ],
		// 	]
		// );


		$this->add_control(
			'category',
			[
				'label' => __( 'Select Categories', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'multiple' => true,
				'options' => elementor_product_cat_list(),
				'default' => [ 'all' ],
			]
		);

		$this->add_control(
				'orderby',
				[
					'label' => __( 'Order By', 'elementor-custom-widgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'id',
					'options' => [
						'id'  => __( 'ID', 'elementor-custom-widgets' ),
						'date' => __( 'Date', 'elementor-custom-widgets' ),
						'menu_order' => __( 'Menu Order', 'elementor-custom-widgets' ),
						'popularity' => __( 'Popularity', 'elementor-custom-widgets' ),
						'rating' => __( 'Rating', 'elementor-custom-widgets' ),
						'rand' => __( 'Rand', 'elementor-custom-widgets' ),
						'title' => __( 'Title', 'elementor-custom-widgets' ),
					],
				]
			);
		$this->add_control(
				'order',
				[
					'label' => __( 'Order', 'elementor-custom-widgets' ),
					'type' => \Elementor\Controls_Manager::SELECT,
					'default' => 'ASC',
					'options' => [
						'ASC'  => __( 'ASC', 'elementor-custom-widgets' ),
						'DESC' => __( 'DESC', 'elementor-custom-widgets' ),
					],
				]
			);


		 $this->add_control(
			'carousel',
			[
				'label' => __( 'Enable Carousel?', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'elementor-custom-widgets' ),
				'label_off' => __( 'No', 'elementor-custom-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->end_controls_section();




	}


	protected function render() {

		$settings = $this->get_settings_for_display();

			/*****Manual system for displying categories*****/
		      // if($settings['category']){	
		      // 	 $cats = implode(',', $settings['category']);
		     	//  //echo $cats;
       		 // }

	    if(empty($settings['category']) OR $settings['category'] == 'all') {
            $cats = '';
        } else {
            $cats = implode(',', $settings['category']);
        }


        if($settings['carousel'] == 'yes') {

 
            $dynamic_id = rand(89896,896698);
            echo '<script>
                jQuery(window).load(function(){
                    jQuery("#product-carousel-'.$dynamic_id.' .products").slick({
                        slidesToShow: '.$settings['columns'].',
                        dots: true,
                        arrows: false,
                        prevArrow: "<i class=\'fas fa-chevron-circle-left\'></i>",
						nextArrow: "<i class=\'fas fa-chevron-circle-right\'></i>",
						autoplay: true,
                  
                    });
                });
            </script><div id="product-carousel-'.$dynamic_id.'">';
        }

		echo do_shortcode( '[products category="'.$cats.'" limit="'.$settings['limit'].'" columns="'.$settings['columns'].'" orderby="'.$settings['orderby'].'" order="'.$settings['order'].'" class="elementor-products"]');
		
     	 if($settings['carousel'] == 'yes') { echo '</div>'; }

	}

}