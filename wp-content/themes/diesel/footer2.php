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
                    <li class="footLevel_2 block4">
                        <ul class="footNav">
                            <li><?php wp_nav_menu( array('menu' => 'Footer Menu Right' )); ?></li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </footer>

    <div class="subFooter">
        <span>&copy;2011 - 2014 Diesel Barbershop LLC., San Antonio, TX</span>
        <ul>
            <li>For More Information &nbsp;&nbsp;</li>
            <li><?php wp_nav_menu( array('menu' => 'Sub Footer Menu' )); ?></li>
        </ul>
    </div>
</div>

</body>
</html>