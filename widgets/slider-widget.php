<?php

class Elementor_Slider_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'slider';
	}


	public function get_title() {
		return __( 'Slider', 'elementor-custom-widgets' );
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

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slider_title', [
				'label' => __( 'Title', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Slider Title' , 'elementor-custom-widgets' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'slider_content', [
				'label' => __( 'Content', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Slider Content' , 'elementor-custom-widgets' ),
				'show_label' => false,
			]
		);
		$repeater->add_control(
			'slider_image',
			[
				'label' => __( 'Slider Image', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => __( 'Repeater List', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
	
			]
		);

		// Switcher control example
		$this->add_control(
			'show_slide_arrow',
			[
				'label' => __( 'Show Slide Arrow', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-custom-widgets' ),
				'label_off' => __( 'Hide', 'elementor-custom-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		$this->add_control(
			'custom_title',
			[
				'label' => __( 'Title', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);




		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings_for_display();


		if($settings['slides']){


			$dynamic_id = rand(24568,96325);
			if(count($settings['slides']) > 1){
				echo '<script>
					jQuery(document).ready(function($){
						$("#slider-elements-'.$dynamic_id.'").slick({
							dots: true,
							prevArrow: "<i class=\'fas fa-chevron-circle-left\'></i>",
							nextArrow: "<i class=\'fas fa-chevron-circle-right\'></i>",
							autoplay: true,
							autoplaySpeed: 3000,
							draggable: true,
						
						});
					});
				</script>';
			}

			echo '<div id="slider-elements-'.$dynamic_id.'" class="slider-area">';

				foreach($settings['slides'] as $slide){
					//echo var_dump($slide['slider_image']);
					echo '<div class="single-slide-item" style="background-image: url('.wp_get_attachment_image_url($slide['slider_image']['id'], 'large').')">
							<div class="row">
								<div class="col my-auto">
									'.wpautop($slide['slider_content']).'
								</div>
							</div>
							<div class="slide-info">
								<h2>'.$slide['slider_title'].'</h2>
							</div>
							


					</div>';
				}

			echo '</div>';
		}

		if ( 'yes' === $settings['show_slide_arrow'] ) {
			echo '<h2>' . $settings['custom_title'] . '</h2>';
		}


	}

}