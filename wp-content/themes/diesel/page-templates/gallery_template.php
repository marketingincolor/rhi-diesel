<?php
/**
 * Template Name: Gallery Template
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

    <script src="<?php echo get_template_directory_uri(); ?>/js/carouselFX.js" type="text/javascript"></script>

    <div class="contentWrap galWrap">

        <?php

        $images = get_field('photo_gallery');

        if( $images ): ?>
            <ul class="galleryList">
                <?php foreach( $images as $image ): ?>
                    <li>
                        <a href="javascript:;"><div style="background-image: url('<?php echo $image['url']; ?>');"></div></a>
                        <!--<p><?php echo $image['caption']; ?></p>-->
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="carouselCont photoCarousel">
                <a href="javascript:;" class="imgArrow rightArrow"></a>
                <a href="javascript:;" class="imgArrow leftArrow"></a>
                <a href="javascript:;" class="closeCarousel"><i class="fa fa-times"></i></a>

                <ul class="imgCarousel">
                    <?php foreach( $images as $image ): ?>
                        <li style="background-image: url('<?php echo $image['url']; ?>');">
                            <!--<span><b>Caption Title:</b> <?php echo $image['caption']; ?></span>-->
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

    </div>

<?php get_footer(); ?>