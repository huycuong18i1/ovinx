<?php
$footer_contact_phone   = themesflat_get_opt( 'footer_contact_phone' );
$footer_contact_address = themesflat_get_opt( 'footer_contact_address' );
$footer_contact_map_url = themesflat_get_opt( 'footer_contact_map_url' );
$footer_contact_email   = themesflat_get_opt( 'footer_contact_email' );
?>
<p class="footer-heading footer-heading-mobile text-white"><?php esc_html_e( 'Contact Us', 'ovinx' ); ?></p>
<div class="tf-collapse-content">
    <ul class="footer-menu-list">
        <?php if ( ! empty( $footer_contact_phone ) ) : ?>
            <li class="contact-item">
                <div class="ic-wrap">
                    <i class="icon icon-PhoneCall"></i>
                </div>
                <div class="it_infor">
                    <p class="infor__name text-white fw-medium lh-24"><?php esc_html_e( 'Phone Number', 'ovinx' ); ?></p>
                    <a href="tel:<?php echo esc_attr( $footer_contact_phone ); ?>" class="infor__link cl-text-mute link-white link-underline">
                        <?php echo esc_html( $footer_contact_phone ); ?>
                    </a>
                </div>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $footer_contact_address ) ) : ?>
            <li class="contact-item">
                <div class="ic-wrap">
                    <i class="icon icon-MapPinLine"></i>
                </div>
                <div class="it_infor">
                    <p class="infor__name text-white fw-medium lh-24"><?php esc_html_e( 'Our Location', 'ovinx' ); ?></p>
                    <a href="<?php echo esc_url( ! empty( $footer_contact_map_url ) ? $footer_contact_map_url : '#' ); ?>" target="_blank" rel="noopener noreferrer" class="infor__link cl-text-mute link-white link-underline">
                        <?php echo esc_html( $footer_contact_address ); ?>
                    </a>
                </div>
            </li>
        <?php endif; ?>

        <?php if ( ! empty( $footer_contact_email ) ) : ?>
            <li class="contact-item">
                <div class="ic-wrap">
                    <i class="icon icon-EnvelopeSimple"></i>
                </div>
                <div class="it_infor">
                    <p class="infor__name text-white fw-medium lh-24"><?php esc_html_e( 'Email Address', 'ovinx' ); ?></p>
                    <a href="mailto:<?php echo esc_attr( $footer_contact_email ); ?>" class="infor__link cl-text-mute link-white link-underline">
                        <?php echo esc_html( $footer_contact_email ); ?>
                    </a>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>
