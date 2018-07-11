<?php
$caps = get_user_meta($user->ID, 'wp_capabilities', true);
$roles = array_keys((array)$caps);
if( $roles[0] == 'franchisee' ) : ?>

<h3>Franchise Location Information</h3>
<table class="form-table">
    <tr>
        <th><label for="location">Location Name</label></th>
        <td>
            <input type="text" name="location" id="location" value="<?php echo esc_attr( get_the_author_meta( 'location', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">The OFFICIAL name of the Location, as determined by Corporate</span>
        </td>
    </tr>
    <tr>
        <th><label for="address1">Address 1</label></th>
        <td>
            <input type="text" name="address1" id="address1" value="<?php echo esc_attr( get_the_author_meta( 'address1', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">Please enter your Address</span>
        </td>
    </tr>
    <tr>
        <th><label for="address2">Address 2</label></th>
        <td>
            <input type="text" name="address2" id="address2" value="<?php echo esc_attr( get_the_author_meta( 'address2', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., Suite 200)</span>
        </td>
    </tr>
    <tr>
        <th><label for="city">City</label></th>
        <td>
            <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"> </span>
        </td>
    </tr>
    <tr>
        <th><label for="state">State</label></th>
        <td>
            <input type="text" name="state" id="state" value="<?php echo esc_attr( get_the_author_meta( 'state', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., NY)</span>
        </td>
    </tr>
    <tr>
        <th><label for="zip">Postal Code</label></th>
        <td>
            <input type="text" name="zip" id="zip" value="<?php echo esc_attr( get_the_author_meta( 'zip', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., 10101)</span>
        </td>
    </tr>
    <tr>
        <th><label for="phone">Primary Phone</label></th>
        <td>
            <input type="text" name="phone" id="phone" value="<?php echo esc_attr( get_the_author_meta( 'phone', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., 555-123-4567)</span>
        </td>
    </tr>
    <tr>
        <th><label for="zone">Territory</label></th>
        <td>
            <textarea rows="6" cols="40" name="zone" id="zone" class="regular-text"><?php echo esc_attr( get_the_author_meta( 'zone', $user->ID ) ); ?></textarea><br />
            <span class="description">(List all ZIP Codes in Territory as comma separated list with no spaces - e.g., 10101,10102,10103,10104,10105)</span>
        </td>
    </tr>
    <tr>
        <th><label for="sm_fb">Facebook</label></th>
        <td>
            <input type="text" name="sm_fb" id="sm_fb" value="<?php echo esc_attr( get_the_author_meta( 'sm_fb', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., http://your/facebook/link)</span>
        </td>
    </tr>
    <tr>
        <th><label for="sm_tw">Twitter</label></th>
        <td>
            <input type="text" name=sm_tw" id="sm_tw" value="<?php echo esc_attr( get_the_author_meta( 'sm_tw', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., http://your/twitter/link)</span>
        </td>
    </tr>
    <tr>
        <th><label for="sm_gp">Google +</label></th>
        <td>
            <input type="text" name="sm_gp" id="sm_gp" value="<?php echo esc_attr( get_the_author_meta( 'sm_gp', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., http://your/google/link)</span>
        </td>
    </tr>
    <tr>
        <th><label for="sm_li">LinkedIn</label></th>
        <td>
            <input type="text" name="sm_li" id="sm_li" value="<?php echo esc_attr( get_the_author_meta( 'sm_li', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description">(e.g., http://your/linkedin/link)</span>
        </td>
    </tr>
    <tr>
        <th><label for="st_an">Standard Analytics</label></th>
        <td>
            <textarea rows="6" cols="40" name="st_an" id="st_an" class="regular-text"><?php echo esc_attr( get_the_author_meta( 'st_an', $user->ID ) ); ?></textarea><br />
            <span class="description">(May be entire code string from Analytics provider)</span>
        </td>
    </tr>
    <tr>
        <th><label for="sp_an">Special Analytics</label></th>
        <td>
            <textarea rows="6" cols="40" name="sp_an" id="sp_an" class="regular-text"><?php echo esc_attr( get_the_author_meta( 'sp_an', $user->ID ) ); ?></textarea><br />
            <span class="description">(May be entire code string from Analytics provider)</span>
        </td>
    </tr>
</table>
<?php endif; ?>