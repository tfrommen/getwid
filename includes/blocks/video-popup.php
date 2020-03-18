<?php

namespace Getwid\Blocks;

class VideoPopup extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/video-popup';

    public function __construct() {

		parent::__construct( self::$blockName );

        add_filter( 'getwid/blocks_style_css/dependencies', [ $this, 'block_frontend_styles' ] );

        register_block_type(
            self::$blockName,
            array(
                'render_callback' => [ $this, 'render_block' ]
            )
        );

        //Register JS/CSS assets
        wp_register_script(
            'magnific-popup',
            getwid_get_plugin_url( 'vendors/magnific-popup/jquery.magnific-popup.min.js' ),
            [ 'jquery' ],
            '1.1.0',
            true
        );

        wp_register_style(
            'magnific-popup',
            getwid_get_plugin_url( 'vendors/magnific-popup/magnific-popup.min.css' ),
            [],
            '1.1.0'
        );
    }

    public function block_frontend_styles($styles) {

		gLog( self::$blockName, $this->hasBlock() );

		if ( !$this->hasBlock() && !getwid_has_nested_blocks() ) {
			return $styles;
		}

        if ( is_admin() ) {
			return $styles;
		}

        //magnific-popup.min.css
		if ( ! in_array( 'magnific-popup', $styles ) ) {
            array_push( $styles, 'magnific-popup' );
        }

        return $styles;
    }

    private function block_frontend_assets() {

        if ( is_admin() ) {
            return;
        }

        //jquery.magnific-popup.min.js
		if ( ! wp_script_is( 'magnific-popup', 'enqueued' ) ) {
            wp_enqueue_script('magnific-popup');
        }
    }

    public function render_block( $attributes, $content ) {

		$this->block_frontend_assets();

        return $content;
    }
}

new \Getwid\Blocks\VideoPopup();
