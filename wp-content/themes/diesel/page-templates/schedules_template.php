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
    <?php if( have_rows('headline') ): ?>
        <h1>
            <?php while( have_rows('headline') ): the_row();
                // vars
                $text = get_sub_field('text_snippet');
                $red = get_sub_field('red');

                ?>

                <?php if( $red == true ): ?>
                    <span><?php echo $text; ?>&nbsp;</span>
                <?php endif; ?>

                <?php if( $red == false ): ?>
                    <?php echo $text; ?>&nbsp;
                <?php endif; ?>

            <?php endwhile; ?>

        </h1>

    <?php endif; ?>

    <div class="pageContent">
        <?php the_field('content'); ?>
    </div>

</div>

<?php get_footer(); ?>