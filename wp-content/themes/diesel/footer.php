<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

    <footer class="footer">
    	<div style="text-align: center; padding-top: 1em; font-size: 16px;">Our services are available to all members of the public regardless of race, gender or sexual orientation.</div>
        <ul class="footNavList">
            <li class="footLevel_1">
                <ul>
                    <li class="footNav footLevel_2 block1">
                        <ul>
                            <li><?php wp_nav_menu( array('menu' => 'Footer Menu Left' )); ?></li>
                        </ul>
                    </li>
                    <li class="footNav footLevel_2 block2">
                        <ul>
                            <li><?php wp_nav_menu( array('menu' => 'Footer Menu Middle' )); ?></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="footLevel_1">
                <ul>
                    <li class="footLevel_2 block3">

                        <h2>Join Our Mailing List</h2>
                        <p>Your privacy is a big deal to us.<br />Diesel Barbershop does not sell or share your personal<br />information with anyone outside our organization</p>

                        <!-- Begin MailChimp Signup Form -->
                        <div id="mc_embed_signup">
                            <form action="//dieselbarbershop.us10.list-manage.com/subscribe/post?u=29b29e2a8797e2c3c529fe4bc&amp;id=735b1af93f" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                                <div id="mc_embed_signup_scroll">

                                    <div class="mc-field-group">
                                        <label for="mce-FLNAME">Enter First Name/Last Name </label>
                                        <input type="text" value="" name="FLNAME" class="required" id="mce-FLNAME">
                                    </div>
                                    <div class="mc-field-group">
                                        <label for="mce-EMAIL">Enter Email Address </label>
                                        <input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
                                    </div>
                                    <div id="mce-responses" class="clear">
                                        <div class="response" id="mce-error-response" style="display:none"></div>
                                        <div class="response" id="mce-success-response" style="display:none"></div>
                                    </div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_29b29e2a8797e2c3c529fe4bc_735b1af93f" tabindex="-1" value=""></div>
                                    <div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
                                </div>
                            </form>
                        </div>

                        <!--End mc_embed_signup-->

                    </li>
                    <li class="footLevel_2 block4">
                        <ul class="footNav">
                            <li><?php wp_nav_menu( array('menu' => 'Footer Menu Right' )); ?></li>
                        </ul>
                        <nav style="margin-top:1em;">
                            <ul class="socialNav" style="text-align:center;">
                                <li class="iconCont" style="display:inline-block;"><a href="<?php the_field('facebook_link', 'option'); ?>" class="navIcon" target="_blank"><span class="fa fa-facebook"></span></a></li>
                                <li class="iconCont" style="display:inline-block;"><a href="<?php the_field('instagram_link', 'option'); ?>" class="navIcon" target="_blank"><span class="fa fa-instagram"></span></a></li>
                            </ul>
                        </nav>
                    </li>
                </ul>
            </li>
        </ul>
    </footer>

    <div class="subFooter">
        <span><?php the_field('copyright_text', 'option'); ?></span>
        <ul>
            <li>For More Information &nbsp;&nbsp;</li>
            <li><?php wp_nav_menu( array('menu' => 'Sub Footer Menu' )); ?></li>
        </ul>
    </div>
</div>

</body>
</html>