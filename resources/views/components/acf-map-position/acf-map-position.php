<?php

if (!defined('ABSPATH')) {
    exit;
}

add_action('acf/include_field_types', function () {

    class acf_field_map_position extends acf_field {

        public function __construct() {

            $this->name = 'map_position';
            $this->label = 'Map Position';
            $this->category = 'layout';

            parent::__construct();

        }


        public function render_field($field) {

            $value = $field['value'] ?: [
                'x' => 50,
                'y' => 50
            ];

            $map = get_field('map_image', 'option');

            if (!$map) {
                echo '<p>No map image found.</p>';
                return;
            }

            ?>

            <div class="acf-map-picker">

                <div class="acf-map-image-wrapper">

                    <img 
                        src="<?php echo esc_url($map['url']); ?>"
                        class="acf-map-image"
                    >

                    <div 
                        class="acf-map-marker"
                        style="
                        left: <?php echo esc_attr($value['x']); ?>%;
                        top: <?php echo esc_attr($value['y']); ?>%;
                        ">
                    </div>

                </div>


                <input 
                    type="hidden"
                    name="<?php echo esc_attr($field['name']); ?>[x]"
                    class="map-x"
                    value="<?php echo esc_attr($value['x']); ?>"
                >

                <input 
                    type="hidden"
                    name="<?php echo esc_attr($field['name']); ?>[y]"
                    class="map-y"
                    value="<?php echo esc_attr($value['y']); ?>"
                >

            </div>

            <?php
        }


        public function update_value($value, $post_id, $field) {

            if (!$value) {
                return [
                    'x' => 50,
                    'y' => 50
                ];
            }

            return [
                'x' => floatval($value['x']),
                'y' => floatval($value['y'])
            ];

        }

    }


    new acf_field_map_position();

});