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


		$this->end_controls_section();


		/************* Slider settings  ********* */

		$this->start_controls_section(
			'slider_settings',
			[
				'label' => __( 'Slider Settings', 'elementor-custom-widgets' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'arrows',
			[
				'label' => __( 'Show Slide Arrows', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-custom-widgets' ),
				'label_off' => __( 'Hide', 'elementor-custom-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'dots',
			[
				'label' => __( 'Show Slide Dots', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-custom-widgets' ),
				'label_off' => __( 'Hide', 'elementor-custom-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->add_control(
			'drugable',
			[
				'label' => __( 'Dgrugable?', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor-custom-widgets' ),
				'label_off' => __( 'Hide', 'elementor-custom-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

	}


	protected function render() {

		$settings = $this->get_settings_for_display();


		if($settings['slides']){

			$dynamic_id = rand(24568,96325);

			if(count($settings['slides']) > 1){

				if('yes' == $settings['arrows']){
					$arrows = 'true';
				} else{
					$arrows = 'false';
				}

				if('yes' == $settings['dots']){
					$dots = 'true';
				} else{
					$dots = 'false';
				}
				if('yes' == $settings['drugable']){
					$drugable = 'true';
				} else{
					$drugable = 'false';
				}

				echo '<script>
					jQuery(document).ready(function($){
						$("#slider-elements-'.$dynamic_id.'").slick({
							dots: '.$dots.',
							arrows: '.$arrows.',
							prevArrow: "<i class=\'fas fa-chevron-circle-left\'></i>",
							nextArrow: "<i class=\'fas fa-chevron-circle-right\'></i>",
							autoplay: true,
							autoplaySpeed: 3000,
							draggable: '.$drugable.',
							fade: false,
						
						
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


	}

}