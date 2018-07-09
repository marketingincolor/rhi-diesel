<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

<script src="<?php echo get_template_directory_uri(); ?>/js/carouselFX.js" type="text/javascript"></script>

<!--
<div class="carouselCont">
    <a href="javascript:;" class="imgArrow rightArrow"></a>
    <a href="javascript:;" class="imgArrow leftArrow"></a>

    <ul class="imgCarousel">
        <li style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/temp_1.jpg');">
            <div>
                <p>Where it&#0146;s<br />Good<br />To Be a Man</p>
                <a href="">Read Our Story</a>
            </div>
        </li>
        <li style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/temp_2.jpg');">
            <div>
                <p>Now with 4<br />San Antonio<br />Locations</p>
                <a href="">Find a Location</a>
            </div>
        </li>
        <li style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/temp_3.jpg');">
            <div>
                <p>Where it&#0146;s<br />Good<br />To Be a Man</p>
                <a href="">Read Our Story</a>
            </div>
        </li>
    </ul>
</div>
-->

<div class="carouselCont homeCarousel">
    <a href="javascript:;" class="imgArrow rightArrow"></a>
    <a href="javascript:;" class="imgArrow leftArrow"></a>
    <?php if( have_rows('carousel', 'option') ): ?>

        <ul class="imgCarousel">

            <?php while( have_rows('carousel', 'option') ): the_row();

                // vars
                $image = get_sub_field('image');
                $caption = get_sub_field('caption');
                $extlink = get_sub_field('external_link');
                $intlink = get_sub_field('internal_link');
                $linktext = get_sub_field('link_text');

                ?>
                <li style="background-image: url('<?php echo $image; ?>');">
                    <div>
                        <p><?php echo $caption; ?></p>

                        <?php if( $extlink ): ?>
                            <a href="<?php echo $extlink; ?>" target="_blank"><?php echo $linktext; ?></a>
                        <?php endif; ?>

                        <?php if( $intlink ): ?>
                            <a href="<?php echo $intlink; ?>"><?php echo $linktext; ?></a>
                        <?php endif; ?>
                    </div>
                </li>

            <?php endwhile; ?>

        </ul>

    <?php endif; ?>
</div>

<?php get_footer(); ?>