<?php
/**
 * Template Name: Employment Template
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
                        <span><?php echo $text ?>&nbsp;</span>
                    <?php endif; ?>

                    <?php if( $red == false ): ?>
                        <?php echo $text ?>&nbsp;
                    <?php endif; ?>

                <?php endwhile; ?>

            </h1>

        <?php endif; ?>


        <div class="pageContent">

            <!-- PERKS SUB TITLE -->
            <h2 class="employTitle"><?php the_field('secondary_headline'); ?></h2>

            <!-- PLAIN PAGE CONTENT -->
            <?php the_field('content'); ?>

            <!-- PERK REPEATER -->
            <?php if( have_rows('perks_list') ): ?>

                <ul class="perksList">

                    <?php while( have_rows('perks_list') ): the_row();

                        // vars
                        $perkTitle = get_sub_field('title');
                        $perkDescrip = get_sub_field('description');

                        ?>
                        <li>
                            <h3><?php echo $perkTitle; ?></h3>
                            <p><?php echo $perkDescrip; ?></p>
                        </li>

                    <?php endwhile; ?>

                </ul>

            <?php endif; ?>

            <!-- FINAL TEXT -->
            <h3><?php the_field('final_text'); ?> &nbsp; <a href="<?php the_field('application_link'); ?>"><?php the_field('application_link_text'); ?></a></h3>

        </div><!-- end pageContent -->

    </div>

<?php get_footer(); ?>