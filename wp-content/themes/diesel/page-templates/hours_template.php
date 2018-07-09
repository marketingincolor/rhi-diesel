<?php
/**
 * Template Name: Hours and Locations Template
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



            <ul class="mapPageList">
                <li>
                    <div class="mapText"><?php the_field('content'); ?></div>
                    <?php if( have_rows('locations') ): ?>
                        <div class="acf-map">
                            <?php while ( have_rows('locations') ) : the_row();

                                $location = get_sub_field('location');

                                ?>
                                <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
                                    <h4><?php the_sub_field('title'); ?></h4>
                                    <p><?php the_sub_field('description'); ?></p>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </li>
                <li>
                    <?php if( have_rows('locations') ): ?>
                        <ul class="locationList">
                            <?php while ( have_rows('locations') ) : the_row(); ?>
                                <li>
                                    <h2><?php the_sub_field('title'); ?></h2>
                                    <p><?php the_sub_field('description'); ?></p>

                                    <?php if( get_sub_field('hours') ): ?>
                                        <p><span>Hours:</span><?php the_sub_field('hours'); ?></p>
                                    <?php endif; ?>

                                    <?php if( get_sub_field('phone') ): ?>
                                        <p><span>Phone:</span><a href="tel:<?php the_sub_field('phone'); ?>"><?php the_sub_field('phone'); ?></a></p>
                                    <?php endif; ?>

                                    <?php if( get_sub_field('facebook_link') ): ?>
                                        <p class="txt_increase"><a href="<?php the_sub_field('facebook_link'); ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></p>
                                    <?php endif; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            </ul>
        </div>

        <div class="clear"></div>
    </div>

<?php get_footer(); ?>