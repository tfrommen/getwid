<?php

namespace Getwid\Blocks;

class PostSelectAcf extends \Getwid\Blocks\AbstractBlock {

	protected static $blockName = 'getwid/template-select-acf';

    public function __construct() {

		parent::__construct( self::$blockName );

        register_block_type(
            self::$blockName,
            array(
                'attributes' => array(
                    'customField' => array(
                        'type'    => 'string'
                    ),
                    'separator'   => array(
                        'type' 	  => 'string',
						'default' => ','
                    ),
                    'className'   => array(
                        'type'    => 'string'
                    ),
                ),
                'render_callback' => [ $this, 'render_callback' ]
            )
        );
    }

    public function render_callback( $attributes, $content ) {

        //Not BackEnd render if we view from template page
        if ( ( get_post_type() == getwid()->postTemplatePart()->postType ) || ( get_post_type() == 'revision' ) ){
            return $content;
        }

        $block_name    = 'wp-block-getwid-template-post-select-acf';
        $wrapper_class = $block_name;

        if ( isset( $attributes[ 'className' ] ) ) {
            $wrapper_class .= ' ' . esc_attr( $attributes[ 'className' ] );
        }

        if ( isset( $attributes[ 'customField' ] ) ) {
			$wrapper_class .= ' ' . 'custom-field-' . esc_attr( $attributes[ 'customField' ] );
		}

        $result = '';

        $extra_attr = array(
            'wrapper_class' => $wrapper_class
        );

        if ( acf_is_active() && isset( $attributes[ 'customField' ] ) ) {
            ob_start();

            getwid_get_template_part( 'template-parts/acf/post-select', $attributes, false, $extra_attr );

            $result = ob_get_clean();
        }

        return $result;
    }
}

new \Getwid\Blocks\PostSelectAcf();
