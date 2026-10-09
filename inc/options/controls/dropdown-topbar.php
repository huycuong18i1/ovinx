<?php
/**
 * Select control
 */
if (class_exists('WP_Customize_Control')) {
    class Themesflat_Repeater_Select extends WP_Customize_Control {
        public $type = 'repeater_select';
        public $choices = array();

        public function render_content() {
            $container_id = 'themesflat-repeater-' . $this->id;

            $raw = $this->value();
            if ( is_string( $raw ) ) {
                $values = json_decode( $raw, true );
            } elseif ( is_array( $raw ) ) {
                $values = $raw;
            } else {
                $values = array();
            }
            if ( ! is_array( $values ) ) $values = array();
            ?>
<div
    id="<?php echo esc_attr( $container_id ); ?>"
    class="themesflat-repeater-select"
    data-control-id="<?php echo esc_attr( $this->id ); ?>"
    data-choices="<?php echo esc_attr( wp_json_encode( $this->choices ) ); ?>"
>
                <label class="customize-control-title"><?php echo esc_html( $this->label ); ?></label>

                <div class="repeater-items sortable-list">
                    <?php if ( ! empty( $values ) ) : ?>
                        <?php foreach ( $values as $val ) : ?>
                            <div class="repeater-item">
                                <span class="dashicons dashicons-move handle"></span>
                                <select class="repeater-select">
                                    <?php foreach ( $this->choices as $key => $label ) : ?>
                                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $val, $key ); ?>>
                                            <?php echo esc_html( $label ); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="button remove-item"><i class="dashicons dashicons-no-alt"></i></button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <button type="button" class="button add-item"><?php esc_html_e( 'Add New Item', 'ovinx' ); ?></button>

                <input
                    type="hidden"
                    class="repeater-hidden"
                    value="<?php echo esc_attr( wp_json_encode( $values ) ); ?>"
                    <?php $this->link(); ?>
                />
            </div>
            <?php
        }
    }
}

