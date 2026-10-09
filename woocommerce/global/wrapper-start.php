<?php
/**
 * Content wrappers (override of WooCommerce's global/wrapper-start.php).
 *
 * QA P3-06: header.php already opens the page's single <main id="main-content">, so the default `<main id="main">` here
 * would be a second main landmark. Same ids/classes, plain <div>.
 *
 * @package ovinx
 */

defined( 'ABSPATH' ) || exit;

echo '<div id="primary" class="content-area"><div id="main" class="site-main">';
