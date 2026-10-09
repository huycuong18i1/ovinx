<?php
/**
 * styler_slider
 */
if (class_exists('WP_Customize_Control')) {

    class themesflat_Slide_Control extends WP_Customize_Control {
        public $type = 'slide-control';

        public function render_content() {
        ?>
            <div class="slider-custom-control">
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span><input type="number" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-slider-value" <?php $this->link(); ?> />
                <div class="slider-control" slider-min-value="<?php echo esc_attr( $this->input_attrs['min'] ); ?>" slider-max-value="<?php echo esc_attr( $this->input_attrs['max'] ); ?>" slider-step-value="<?php echo esc_attr( $this->input_attrs['step'] ); ?>"></div><span class="slider-reset dashicons dashicons-image-rotate" slider-reset-value="<?php echo esc_attr( $this->value() ); ?>"></span>
            </div>
        <?php
        }
    }

    class themesflat_Responsive_Slider_Control extends WP_Customize_Control {
        public $type = 'responsive-slider';

        public function render_content() {
            $value = wp_parse_args(json_decode($this->value(), true), [
                'desktop' => 40,
                'tablet'  => 30,
                'mobile'  => 20,
            ]);

            $min  = isset($this->input_attrs['min']) ? $this->input_attrs['min'] : 0;
            $max  = isset($this->input_attrs['max']) ? $this->input_attrs['max'] : 100;
            $step = isset($this->input_attrs['step']) ? $this->input_attrs['step'] : 1;

            $devices = [
                'desktop' => 'dashicons-desktop',
                'tablet'  => 'dashicons-tablet',
                'mobile'  => 'dashicons-smartphone',
            ];

            $current = 'desktop';
            ?>
            <div class="tf-responsive-slider-wrapper">
                <div class="tf-heading-col">
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                    <div class="tf-responsive-tabs">
                        <?php foreach ($devices as $device => $icon): ?>
                            <span class="tf-tab <?php if ($device === $current) echo 'active'; ?>" data-device="<?php echo esc_attr($device); ?>">
                                <i class="dashicons <?php echo esc_attr($icon); ?>"></i>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="tf-slider-control">
                    <?php foreach ($devices as $device => $icon): ?>
                        <input 
                            type="range" 
                            class="tf-slider tf-<?php echo esc_attr($device); ?> <?php if ($device !== $current) echo 'hidden'; ?>"
                            min="<?php echo esc_attr($min); ?>" 
                            max="<?php echo esc_attr($max); ?>" 
                            step="<?php echo esc_attr($step); ?>" 
                            data-device="<?php echo esc_attr($device); ?>"
                            value="<?php echo esc_attr($value[$device]); ?>"
                        />
                        <span class="tf-slider-value tf-<?php echo esc_attr($device); ?>-val <?php if ($device !== $current) echo 'hidden'; ?>">
                            <?php echo esc_html($value[$device]); ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <input 
                    type="hidden"
                    id="<?php echo esc_attr($this->id); ?>"
                    name="<?php echo esc_attr($this->id); ?>"
                    value='<?php echo esc_attr(json_encode($value)); ?>'
                    <?php $this->link(); ?>
                />
            </div>

            <?php
        }
    }

}

