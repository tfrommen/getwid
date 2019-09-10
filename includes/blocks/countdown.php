<?php

function render_getwid_countdown( $attributes, $content ) {
	if ( isset( $attributes['fontWeight'] ) && $attributes['fontWeight'] == 'regular' ) {
		$attributes['fontWeight'] = '400';
	}

	if ( isset( $attributes['fontFamily'] ) ) {
		wp_enqueue_style(
			"google-font-" . esc_attr( strtolower( preg_replace( '/\s+/', '_', $attributes['fontFamily'] ) ) ) . ( isset( $attributes['fontWeight'] ) && $attributes['fontWeight'] != '400' ? "_" . esc_attr( $attributes['fontWeight'] ) : "" ),
			"https://fonts.googleapis.com/css?family=" . esc_attr( $attributes['fontFamily'] ) . ( isset( $attributes['fontWeight'] ) && $attributes['fontWeight'] != '400' ? ":" . esc_attr( $attributes['fontWeight'] ) : "" ),
			null,
			'all'
		);
	}

	$block_name = 'wp-block-getwid-countdown';
	$class      = $block_name;

	//Classes
	if ( isset( $attributes['className'] ) ) {
		$class .= ' ' . esc_attr( $attributes['className'] );
	}
	if ( isset( $attributes['align'] ) ) {
		$class .= ' align' . esc_attr( $attributes['align'] );
	}
	if ( isset( $attributes['textAlignment'] ) ) {
		$class .= ' has-horizontal-alignment-' . esc_attr( $attributes['textAlignment'] );
	}

	if ( isset( $attributes['innerPadding'] ) && $attributes['innerPadding'] != 'default' ) {
		$class .= ' has-inner-paddings-'. esc_attr( $attributes['innerPadding'] );
	}
	if ( isset( $attributes['innerSpacings'] ) && $attributes['innerSpacings'] != 'none' ) {
		$class .= ' has-spacing-'.esc_attr( $attributes['innerSpacings'] );
	}

	$wrapper_class = esc_attr( $block_name ) . '__content';
	$content_class = esc_attr( $block_name ) . '__wrapper';

	if ( isset( $attributes['fontSizeTablet'] ) && $attributes['fontSizeTablet'] != 'fs-tablet-100' ) {
		$content_class .= ' ' . esc_attr( $attributes['fontSizeTablet'] );
	}
	if ( isset( $attributes['fontSizeMobile'] ) && $attributes['fontSizeMobile'] != 'fs-mobile-100' ) {
		$content_class .= ' ' . esc_attr( $attributes['fontSizeMobile'] );
	}
	if ( isset( $attributes['fontSize'] ) && $attributes['fontSize'] != '' ) {
		$content_class .= ' has-custom-font-size';
	}

	$style         = '';
	$content_style = '';
	//Style
	if ( isset( $attributes['fontSize'] ) ) {
		$content_style .= 'font-size: ' . esc_attr( $attributes['fontSize'] ) . ';';
	}

	if ( isset( $attributes['fontFamily'] ) && $attributes['fontFamily'] != '' ) {
		$content_style .= 'font-family: ' . esc_attr( $attributes['fontFamily'] ) . ';';
	}
	if ( isset( $attributes['fontWeight'] ) ) {
		$content_style .= 'font-weight: ' . esc_attr( $attributes['fontWeight'] ) . ';';
	}
	if ( isset( $attributes['fontStyle'] ) ) {
		$content_style .= 'font-style: ' . esc_attr( $attributes['fontStyle'] ) . ';';
	}
	if ( isset( $attributes['textTransform'] ) && $attributes['textTransform'] != 'default' ) {
		$content_style .= 'text-transform: ' . esc_attr( $attributes['textTransform'] ) . ';';
	}
	if ( isset( $attributes['lineHeight'] ) ) {
		$content_style .= 'line-height: ' . esc_attr( $attributes['lineHeight'] ) . ';';
	}
	if ( isset( $attributes['letterSpacing'] ) ) {
		$content_style .= 'letter-spacing: ' . esc_attr( $attributes['letterSpacing'] ) . ';';
	}

	$is_back_end = \defined( 'REST_REQUEST' ) && REST_REQUEST && ! empty( $_REQUEST['context'] ) && 'edit' === $_REQUEST['context'];

	//Color style & class
	getwid_custom_color_style_and_class( $content_style, $content_class, $attributes, 'color', $is_back_end );

	if ( isset( $attributes['dateTime'] ) ) {

		try {
			$target_date = new DateTime( $attributes['dateTime'] );
		} catch ( Exception $e ) {
			return esc_html__( 'Invalid date.', 'getwid' );
		}

		$current_date = new DateTime();

		if ( $current_date < $target_date ) {
			$dateTime_until = $current_date->diff( $target_date )->format( "+%yy +%mo +%dd +%hh +%im +%ss" );
		} else {
			$dateTime_until = 'negative';
		}

	} else {
		$dateTime_until = '';
	}

	$countdown_options = array(
		( ! empty( $attributes['backgroundColor'] ) ? 'data-bg-color="' . esc_attr( $attributes['backgroundColor'] ) . '"' : '' ),
		( ! empty( $attributes['years'] ) ? 'data-years="' . esc_attr( $attributes['years'] ) . '"' : '' ),
		( ! empty( $attributes['months'] ) ? 'data-months="' . esc_attr( $attributes['months'] ) . '"' : '' ),
		( ! empty( $attributes['weeks'] ) ? 'data-weeks="' . esc_attr( $attributes['weeks'] ) . '"' : '' ),
		( ! empty( $attributes['days'] ) ? 'data-days="' . esc_attr( $attributes['days'] ) . '"' : '' ),
		( ! empty( $attributes['hours'] ) ? 'data-hours="' . esc_attr( $attributes['hours'] ) . '"' : '' ),
		( ! empty( $attributes['minutes'] ) ? 'data-minutes="' . esc_attr( $attributes['minutes'] ) . '"' : '' ),
		( ! empty( $attributes['seconds'] ) ? 'data-seconds="' . esc_attr( $attributes['seconds'] ) . '"' : '' ),
	);

	$countdown_options_str = implode( ' ', $countdown_options );

	ob_start();
	?>

	<div class="<?php echo esc_attr( $class ); ?>" <?php echo( ! empty( $style ) ? 'style="' . esc_attr( $style ) . '"' : '' ); ?>>
		<div class="<?php echo esc_attr( $content_class ); ?>" <?php echo( ! empty( $content_style ) ? 'style="' . esc_attr( $content_style ) . '"' : '' ); ?>>
			<div class="<?php echo esc_attr( $wrapper_class ); ?>"
			     data-datetime="<?php echo esc_attr( isset( $attributes['dateTime'] ) ? $dateTime_until : '' ); ?>" <?php echo $countdown_options_str; ?>>
			</div>
		</div>
	</div>

	<?php
	$result = ob_get_clean();

	return $result;
}

register_block_type(
	'getwid/countdown',
	array(
		'attributes'      => array(
			'dateTime'        => array(
				'type' => 'string',
			),
			'years'           => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'months'          => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'weeks'           => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'days'            => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'hours'           => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'minutes'         => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'seconds'         => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'backgroundColor' => array(
				'type' => 'string',
			),
			'textColor'       => array(
				'type' => 'string',
			),
			'customTextColor' => array(
				'type' => 'string',
			),

			'fontFamily'     => array(
				'type'    => 'string',
				'default' => '',
			),
			'fontSize'       => array(
				'type' => 'string',
			),
			'fontSizeTablet' => array(
				'type'    => 'string',
				'default' => 'fs-tablet-100',
			),
			'fontSizeMobile' => array(
				'type'    => 'string',
				'default' => 'fs-mobile-100',
			),
			'fontWeight'     => array(
				'type' => 'string',
			),
			'fontStyle'      => array(
				'type' => 'string',
			),
			'textTransform'  => array(
				'type' => 'string',
			),
			'lineHeight'     => array(
				'type' => 'string',
			),
			'letterSpacing'  => array(
				'type' => 'string',
			),

			'align'         => array(
				'type' => 'string',
			),
			'textAlignment' => array(
				'type' => 'string',
			),
			'innerPadding'  => array(
				'type'    => 'string',
				'default' => 'default',
			),
			'innerSpacings' => array(
				'type'    => 'string',
				'default' => 'none',
			),

			'className' => array(
				'type' => 'string',
			),
		),
		'render_callback' => 'render_getwid_countdown',
	)
);
