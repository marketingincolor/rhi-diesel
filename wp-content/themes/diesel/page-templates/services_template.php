<?php
/**
 * Template Name: Services Template
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
        <h1>Services &amp; Pricing</h1>
<!--        <h1>Services &amp; Pricing <span>--><?php //echo get_the_title( $ID ); ?><!--</span></h1>-->

        <!-- IN PAGE NAV -->
<!--        <div class="inPageNav">-->
<!--            <a href="javascript:;" class="selectLink">Select a New Location</a>-->
<!--            --><?php //wp_nav_menu( array('menu' => 'Services In Page Menu' )); ?>
<!--        </div>-->

<!--        PAGE CONTENT-->
        <div class="pageContent">
            <?php the_field('content'); ?>
            <div class="clear"></div>
        </div>

        <!-- SERVICES BLOCKS -->
        <?php if( have_rows('service_item') ): ?>
            <ul class="services">
                <?php while( have_rows('service_item') ): the_row();
                    // vars
                    $name = get_sub_field('service_name');
                    $price = get_sub_field('service_price');
                    $description = get_sub_field('service_description');

                    ?>

                    <li>
                        <h2><?php echo $name; ?><span>&#36;<?php echo $price; ?></span></h2>
                        <p><?php echo $description; ?></p>
                    </li>

                <?php endwhile; ?>

            </ul>

        <?php endif; ?>
    </div>

<div class="prodFoot">
    <ul>
        <li><?php the_field('foot2_headline', 'option'); ?></li>
        <li><img src="<?php the_field('image1', 'option'); ?>" /></li>
        <li><img src="<?php the_field('image2', 'option'); ?>" /></li>
    </ul>
</div>

<?php get_footer(); ?>