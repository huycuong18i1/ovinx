<?php
if (class_exists('WP_Customize_Control')) {
    class Testimonial_Thankyou_Repeater_Control extends WP_Customize_Control {
        public $type = 'repeater';

        public function render_content() {
            $json = json_decode($this->value(), true);
            $control_id = 'testimonial-repeater-' . esc_attr($this->id);
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <div id="<?php echo esc_attr($control_id); ?>" class="testimonial-repeater-container">
                    <ul class="testimonial-repeater-list">
                        <?php if (!empty($json)) :
                            foreach ($json as $index => $item) : ?>
                                <li class="testimonial-repeater-item">
                                    <div class="title"><?php echo esc_html__('Testimonial ', 'ovinx') . ($index + 1); ?></div>
                                    <fieldset><label><?php echo esc_html__('Icon ', 'ovinx') ; ?></label>
                                        <input type="text" class="quote-field" placeholder="Quote Icon " value="<?php echo esc_attr(isset($item['quote']) ? $item['quote'] : ''); ?>" /></fieldset>
                                    <fieldset><label><?php echo esc_html__('Title ', 'ovinx') ; ?></label>
                                        <input type="text" class="title-field" placeholder="Title" value="<?php echo esc_attr(isset($item['title']) ? $item['title'] : ''); ?>" />
                                    </fieldset>
                                    <fieldset><label><?php echo esc_html__('Review ', 'ovinx') ; ?></label>
                                        <textarea rows="4" class="review-field" placeholder="Review"><?php echo esc_textarea(isset($item['review']) ? $item['review'] : ''); ?></textarea>
                                    </fieldset>
                                    <fieldset><label><?php echo esc_html__('Name ', 'ovinx') ; ?></label>
                                        <input type="text" class="name-field" placeholder="Name" value="<?php echo esc_attr(isset($item['name']) ? $item['name'] : ''); ?>" />
                                    </fieldset>
                                    <button class="remove-item button button-secondary"><?php _e('Remove', 'ovinx'); ?></button>
                                </li>
                            <?php endforeach;
                        endif; ?>
                    </ul>
                    <button class="add-item button button-primary"><?php _e('Add Testimonial', 'ovinx'); ?></button>
                    <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" class="testimonial-repeater-value" />
                </div>
            </label>

            <script>
                (function($) {
                    $(document).ready(function() {
                        var container = $('#<?php echo esc_attr($control_id); ?>');

                        function updateTitles() {
                            container.find('.testimonial-repeater-item').each(function(index) {
                                $(this).find('.title').text('Testimonial ' + (index + 1));
                            });
                        }

                        container.on('click', '.add-item', function(e) {
                            e.preventDefault();
                            var newItem = $('<li class="testimonial-repeater-item">' +
                                '<div class="title"></div>' +
                                '<fieldset><label>Icon</label><input type="text" class="quote-field" placeholder="Quote Icon" /></fieldset>' +
                                '<fieldset><label>Title</label><input type="text" class="title-field" placeholder="Title" /></fieldset>' +
                                '<fieldset><label>Review</label><textarea rows="4" class="review-field" placeholder="Review"></textarea></fieldset>' +
                                '<fieldset><label>Name</label><input type="text" class="name-field" placeholder="Name" /></fieldset>' +
                                '<button class="remove-item button button-secondary"><?php _e("Remove", "ovinx"); ?></button>' +
                                '</li>');
                            container.find('.testimonial-repeater-list').append(newItem);
                            updateTitles();
                            updateRepeaterValue();
                        });

                        container.on('click', '.remove-item', function(e) {
                            e.preventDefault();
                            $(this).parent().remove();
                            updateTitles();
                            updateRepeaterValue();
                        });

                        container.on('input', 'textarea, input', function() {
                            updateRepeaterValue();
                        });

                        function updateRepeaterValue() {
                            var items = [];
                            container.find('.testimonial-repeater-item').each(function() {
                                var quote = $(this).find('.quote-field').val();
                                var title = $(this).find('.title-field').val();
                                var review = $(this).find('.review-field').val();
                                var name = $(this).find('.name-field').val();

                                items.push({ quote: quote, title: title, review: review, name: name });
                                
                            });
                            container.find('.testimonial-repeater-value').val(JSON.stringify(items)).trigger('change');
                        }

                        updateTitles();
                    });
                })(jQuery);
            </script>

            <?php
        }
    }
}

