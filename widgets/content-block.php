<?php

class Elementor_contentBlock_Widget extends \Elementor\Widget_Base {


	public function get_name() {
		return 'contentBlock';
	}


	public function get_title() {
		return __( 'ContentBlock', 'elementor-custom-widgets' );
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
			'select_theme',
			[
				'label' => __( 'Select Theme', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1'  => __( 'Theme 1', 'elementor-custom-widgets' ),
					'2' => __( 'Theme 2', 'elementor-custom-widgets' ),
				],
			]
		);

		$this->add_control(
			'content_title', [
				'label' => __( 'Content Title', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Content Title' , 'elementor-custom-widgets' ),
				'label_block' => true,
			]
		);


		$this->add_control(
			'content_desc', [
				'label' => __( 'Content Desc', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::WYSIWYG,
				'default' => __( 'Content Desc' , 'elementor-custom-widgets' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'content_image',
			[
				'label' => __( 'Content Image', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'icon', [
				'label' => __( 'Select Icon', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::ICON,
				'default' => 'fa fa-angle-double-right',
			]
		);
		
		$this->add_control(
			'link', [
				'label' => __( 'Link', 'elementor-custom-widgets' ),
				'type' => \Elementor\Controls_Manager::URL,
			]
		);

		$this->end_controls_section();




	}


	protected function render() {

		$settings = $this->get_settings_for_display();
		
			echo '<div class="content-box content-box-theme-'.$settings['select_theme'].'">

					<div class="content-box-bg" style="background-image: url('.wp_get_attachment_image_url( $settings['content_image']['id'], 'large' ).')"></div>
					<div class="content-box-content">
						'.wpautop($settings['content_desc']).'
						<h5>'.$settings['content_title'].'</h5>
						<a href="'.$settings['link']['url'].'"><i class="'.$settings['icon'].'"></i></a>
					</div>

			</div>';
		


	}

}