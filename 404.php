<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * Ground truth: `themes/ovinx-html/` 404 page (`section-page-title type-404`).
 *
 * @package ovinx
 */

get_header(); ?>

<section class="section-page-title type-404 position-relative flat-spacing">
    <div class="container">
        <div class="main-page-title">
            <h1 class="h3"><?php esc_html_e( 'Page Not Found', 'ovinx' ); ?></h1>
            <p class="text-body-02">
                <?php esc_html_e( 'It looks like the page you’re looking for doesn’t exist.', 'ovinx' ); ?> <br class="d-none d-sm-block">
                <?php esc_html_e( 'Check out our best sellers or get back to homepage.', 'ovinx' ); ?>
            </p>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="tf-btn">
                <?php esc_html_e( 'BACK TO HOME PAGE', 'ovinx' ); ?>
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
