<?php
/**
 * Template Name: Schedules Template
 *
 * Description: Twenty Twelve loves the no-sidebar look as much as
 * you do. Use this page template to remove the sidebar from any page.
 *
 * Tip: to remove the sidebar from all posts and pages simply remove
 * any active widgets from the Main Sidebar area, and the sidebar will
 * disappear everywhere.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

    <div class="contentWrap">
        <!-- HEADLINE -->
        <h1><span><?php echo get_the_title( $ID ); ?></span></h1>
    </div>

<?php get_footer(); ?>