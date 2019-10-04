<?php

namespace Getwid\Blocks;

class ImageSlider {

    private $block_name = 'getwid/images-slider';

    public function __construct() {

        add_filter( 'getwid/editor_blocks_js/dependencies', [ $this, 'block_editor_scripts'] );
        add_filter( 'getwid/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

        add_action( 'enqueue_block_assets' , [ $this, 'block_enqueue_styles' ] );

        register_block_type(
            $this->block_name,
            array(
                'render_callback' => [ $this, 'render_block' ]
            )
        );

        //Register JS/CSS assets
        wp_register_script(
            'slick',
            getwid_get_plugin_url( 'vendors/slick/slick/slick.min.js' ),
            [ 'jquery' ],
            '1.9.0',
            true
        );
    }

    public function block_enqueue_styles() {
        wp_enqueue_style(
			'slick',
			getwid_get_plugin_url( 'vendors/slick/slick/slick.min.css' ),
			[],
			'1.9.0'
		);

		wp_enqueue_style(
			'slick-theme',
			getwid_get_plugin_url( 'vendors/slick/slick/slick-theme.min.css' ),
			[],
			'1.9.0'
        ); 
    }

    public function block_editor_scripts($scripts) {

        if ( ! in_array( 'imagesloaded', $scripts ) ) {
            array_push( $scripts, 'imagesloaded' );
		}

        if ( ! in_array( 'slick', $scripts ) ) {
            array_push( $scripts, 'slick' );
        }

        return $scripts;
    }

    public function block_frontend_styles($styles) {

        if ( ! in_array( 'slick', $styles ) ) {
            array_push( $styles, 'slick' );        
        }

        if ( ! in_array( 'slick-theme', $styles ) ) {
            array_push( $styles, 'slick-theme' );        
        }        

        return $styles;
    }  

    private function block_frontend_assets() {
        if ( is_admin() ) {
            return;
        }

        if ( ! wp_script_is( 'slick', 'enqueued' ) ) {
            wp_enqueue_script('slick');
        }
    }

    public function render_block( $attributes, $content ) {
        $this->block_frontend_assets();
        return $content;
    }
}

new \Getwid\Blocks\ImageSlider();