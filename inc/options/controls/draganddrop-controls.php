<?php 
// Sorter Control

if (class_exists('WP_Customize_Control')) {
	class themesflat_Control_Drag_And_Drop extends WP_Customize_Control {
		public $type = 'draganddrop-controls';

		public function enqueue() {
			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'draganddrop' );
		}

		public function render_content() { ?>
			<div class="themesflat-sortable">
				<label>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
					<?php if ( '' != $this->description ) {
						echo '<span class="description customize-control-description">'. $this->description .'</span>'; ?>
					<?php } ?>
				</label>
				<?php
				$choices = $this->choices;
				$values  = $this->value();
				// Turn values into array
				if ( ! is_array( $values ) ) {
					$values = explode( ',', $values );
				}
				echo '<ul 
	id="'. esc_attr( $this->id ) .'_sortable"
	data-input="'. esc_attr( $this->id ) .'_input"
>'; ?>
					<?php
					foreach ( $values as $val ) :
						$label = isset( $choices[$val] ) ? $choices[$val] : '';
						if ( $label ) : ?>
							<li data-value="<?php echo esc_attr( $val ); ?>" class="themesflat-sortable-li">
								<?php echo esc_html( $label ); ?>
								<span class="themesflat-hide-sortee icon icon-EyeOpen" title="<?php esc_attr_e( 'Click to hide', 'ovinx' ); ?>"></span>
							</li>
						<?php
						endif;
						unset( $choices[$val] );
					endforeach;
					foreach ( $choices as $val => $label ) { ?>
						<li data-value="<?php echo esc_attr( $val ); ?>" class="themesflat-sortable-li themesflat-hide">
							<?php echo esc_html( $label ); ?>
							<span class="themesflat-hide-sortee icon icon-EyeSlash" title="<?php esc_attr_e( 'Click to show', 'ovinx' ); ?>"></span>
						</li>
					<?php } ?>
				</ul>
			</div>
			<div class="clear:both"></div>
			<?php
		
			if ( is_array( $values ) ) {
				$values = array_keys( $values );
				$values = implode( ',', $values );
			}
			echo '<input id="'. $this->id .'_input" type="hidden" name="'. $this->id .'" value="'. esc_attr( $values ) .'" '. $this->get_link() .' />'; ?>

			<?php
		}
	}
}