<?php

function render_getwid_instagram( $attributes ) {
    $access_token = get_option('getwid_instagram_token', '');

    //Get Data from Instagram
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, 'https://api.instagram.com/v1/users/7705691465/media/recent?access_token='.$access_token);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $instagram_data = json_decode(curl_exec($curl));
    curl_close($curl);

    $block_name = 'wp-block-getwid-instagram';

    $extra_attr = array(
        'block_name' => $block_name
    );

    $class = $block_name;

    if ( isset( $attributes['align'] ) ) {
        $class .= ' align' . $attributes['align'];
    }
    if ( isset( $attributes['displayStyle'] ) ) {
        $class .= " layout-{$attributes['displayStyle']}";
    }
    if ( isset( $attributes['className'] ) ) {
        $class .= ' ' . $attributes['className'];
    }

    $wrapper_class = 'wp-block-getwid-instagram__wrapper';

    if ( isset( $attributes['displayStyle'] ) && $attributes['displayStyle'] == 'grid' ) {
        $wrapper_class .= " getwid-columns getwid-columns-" . $attributes['gridColumns'];
    }
    // var_dump($instagram_data);
    ob_start();
    ?>    

    <div class="<?php echo esc_attr( $class ); ?>">
        <div class="<?php echo esc_attr( $wrapper_class );?>">
            <?php
                foreach ($instagram_data->data as $key => $value) { 
                ?>
                    <div className="<?php echo esc_attr($attributes['className']); ?>__media-item">
                        <a href="<?php echo esc_url($value->link); ?>"><img src="<?php echo esc_url($value->images->standard_resolution->url); ?>"/></a>
                    </div>
                <?php
                }
            ?>
        </div>
    </div>
    <?php
    $result = ob_get_clean();
    return $result;
}

register_block_type(
    'getwid/instagram',
    array(
        'attributes' => array(
            'getDataFrom' => array(
                'type' => 'string',
                'default' => 'self',
            ),  
            'userName' => array(
                'type' => 'string',
            ),  
            'tagName' => array(
                'type' => 'string',
            ),  
            'photoCount' => array(
                'type' => 'number',
                'default' => 10,
            ),  
            'displayStyle' => array(
                'type' => 'string',
                'default' => 'grid',
            ),  
            'gridColumns' => array(
                'type' => 'number',
                'default' => 3,
            ), 
            'linkTo' => array(
                'type' => 'string',
                'default' => 'image',
            ), 
			'showLikes' => array(
				'type' => 'boolean',
				'default' => true,
			),
			'showComments' => array(
				'type' => 'boolean',
				'default' => true,
			),
            'blockAlignment' => array(
                'type' => 'string',
            ),
        ),
        'render_callback' => 'render_getwid_instagram',
    )
);