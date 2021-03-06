<?php
/*
 * This class implements some function for image optimize
 *
 */

class ImageHelper {

    public static $src = '';

    public function __construct(array $params = array()) {
        $c = new ReflectionClass(__CLASS__);
        $statics = $c->getStaticProperties();

        foreach ($params as $key => $value) {
            if (!in_array($key, array_keys($statics))) {
                $this->{$key} = $value;
            } else {
                self::$$key = $value;
            }
        }
    }
    
    /*
     * get image info
     */
    public static function IGetPart($src = '') {
        if ($src == '') {
            $src = self::$src;
        }
        $ipart = new ImageHelper(array(
            'src' => $src,
            'base_path' => '',
            'name' => '',
            'ext' => '',
            'dimension' => '',
            'name_prefix' => '',
            'name_suffix' => ''));

        if (($dot = strrpos($src, '.')) === false) {
            return $ipart;
        }

        if (($bslash = strrpos($src, '/')) === false) {
            $bslash = 0;
        } else {
            $bslash++;
        }

        $ipart->_src = $src;
        $ipart->base_path = substr($src, 0, $bslash);
        $ipart->name = substr($src, $bslash, $dot - $bslash);
        $ipart->ext = substr($src, $dot);
        $ipart->dimension = self::IGetDimension($ipart->name);
        if (!empty($ipart->dimension)) {
            $ipart->name_prefix = substr($ipart->name, 0, strpos($ipart->name, $ipart->dimension) - 1);
            $ipart->name_suffix = str_replace($ipart->name_prefix . '-' . $ipart->dimension, '', $ipart->name);
        } else {
            $ipart->name_prefix = $ipart->name_suffix = '';
        }

        return $ipart;
    }

    /*
     * get Image width and height
     */
    public static function IGetDimension($src) {
        if (preg_match_all('/(\d+)x(\d+)/i', $src, $match)) {
            return count($match) > 0 ? end($match[0]) : '';
        }

        return '';
    }

    public static function get($part, $src = '') {
        if ($src == '') {
            $src = self::$src;
        }
        $ipart = self::getIPart($src);
        return isset($ipart->{$part}) ? $ipart->{$part} : '';
    }
    
    /*
     * Replace image src
     */
    public static function IReplace($newName, $src = '') {
        if ($src == '') {
            $src = self::$src;
        }
        if ($newName === '') {
            return $src;
        }

        $ipart = self::IgetPart($src);
        $src = $ipart->base_path . $newName . '-' . $ipart->dimension . $ipart->name_suffix . $ipart->ext;
        return $src;
    }

    public static function IHasClone($img, $obj) {
        if (!is_array($img)) {
            $img = array($img);
        }
        $obj_part = self::IGetPart($obj);

        foreach ($img as $_img) {
            $img_part = self::IGetPart($_img);
            if ($img_part->ext !== $obj_part->ext) {
                continue;
            }

            if ($obj_part->dimension !== '') {
                $cmp = $obj_part->name_prefix;
            } else {
                $cmp = $obj_part->name;
            }

            if (strcmp($img_part->name, $cmp) === 0) {
                return $_img;
            }
        }

        return false;
    }
    
    /*
     * get image info when scan post
     */
    public static function IScan($imgs = array(), $content) {
        $ifound = array();
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        @$doc->loadHtml($content);
        $tags = $doc->getElementsByTagName('img');

        //For standard images names, convert spaces to -
        $_imgs = array();
        foreach ($imgs as $iname => $iid) {
            $iname = preg_replace('/(\s{1,})/', '-', $iname);
            $_imgs[$iname] = $iid;
        }
        if ($tags->length > 0) {
            foreach ($tags as $order => $tag) {
                // only find img tag have source
                if (($obj = $tag->getAttribute('src')) == '') {
                    continue;
                }
                if ($img_name = self::IHasClone(array_keys($_imgs), $obj)) {
                    if (!empty($_imgs[$img_name])) {
                        $ifound[$order]['id'] = $_imgs[$img_name];
                        $ifound[$order]['src'] = $obj;
                        $ifound[$order]['width'] = $tag->getAttribute('width');
                        $ifound[$order]['height'] = $tag->getAttribute('height');
                        $ifound[$order]['alt'] = trim($tag->getAttribute('alt'));
                        $ifound[$order]['title'] = trim($tag->getAttribute('title'));
                    } else {
                        continue;
                    }
                }
            }
        }

        return $ifound;
    }
    
    /*
     * get posts list
     */
    public static function _get_post_list($iID, $opt_type) {
        global $wpdb;
        //Get image info from wp_postmeta with key equals to _metaseo_img_meta_not_good
        $meta_key = '_metaseo_' . strtolower(trim($opt_type));
        $posts = get_post_meta($iID, $meta_key, true);

        if (is_array($posts) && !empty($posts)) {
            $posts = metaseo_utf8($posts, 'decode');
            return $posts;
        }

        return array();
    }

    /*
     * get image not good
     */
    public static function IPrepare($imgs, $posts, $meta_checkout = array(), $forceScan = false) {
        $iNotGood = array();
        $iNotGoodTotal = array();
        $metaNotGood = array();
        $metaNotGoodTotal = array();
        $upload_dir = wp_upload_dir();
        
        // scan img tag for each post content
        foreach ($posts as $post) {
            if (empty($post->post_content)) {
                continue;
            }
            $ifound = self::IScan($imgs, $post->post_content);
            if (count($ifound) < 1) {
                continue;
            }

            foreach ($ifound as $order => $img) {
                $iID = $img['id'];
                //Get image that its size is not good
                if (!list($width_origin, $height_origin) = @getimagesize($img['src'])) {
                    continue;
                }
                $ratio_origin = $width_origin / $height_origin;
                $width = $img['width'];
                $height = $img['height'];
                //Check if img tag is missing with/height attribute value or not
                if (!$width && !$height) {
                    $width = $width_origin;
                    $height = $height_origin;
                } elseif ($width && !$height) {
                    $height = $width * (1 / $ratio_origin);
                } elseif ($height && !$width) {
                    $width = $height * ($ratio_origin);
                }

                if ($width_origin > $width || $height_origin > $height) {
                    $img_before = str_replace(array($upload_dir['baseurl']), '', $img['src']);
                    $ibpart = ImageHelper::IGetPart($img_before);

                    $img_after = $ibpart->base_path
                            . (!empty($ibpart->name_prefix) ? $ibpart->name_prefix : $ibpart->name)
                            . '-' . $width . 'x' . $height
                            . $ibpart->name_suffix
                            . $ibpart->ext;

                    $destination = $upload_dir['basedir'] . '/' . $img_after;
                    
                    // create new image url and dir
                    $srcs = array(
                        'img_before_dir' => $upload_dir['basedir'] . $img_before,
                        'img_before_url' => $upload_dir['baseurl'] . $img_before,
                        'img_after_dir' => $upload_dir['basedir'] . $img_after,
                        'img_after_url' => $upload_dir['baseurl'] . $img_after
                    );
                    
                    // get size img
                    $size = (filesize($srcs['img_before_dir']) / 1024);
                    if ($size > 1024) {
                        $size = $size / 1024;
                        $sizes = 'MB';
                    } else {
                        $sizes = 'KB';
                    }
                    $size = @round($size, 1);

                    $iNotGood[$iID][$post->ID]['ID'] = $post->ID;
                    $iNotGood[$iID][$post->ID]['title'] = $post->post_title;
                    $iNotGood[$iID][$post->ID]['post_type'] = $post->post_type;
                    $iNotGood[$iID][$post->ID]['img_before_optm'][$order] = array(
                        'size' => $size,
                        'sizes' => $sizes,
                        'src' => $srcs['img_before_url'],
                        'width' => $width,
                        'height' => $height,
                        'dimension' => ImageHelper::IGetDimension($img_before)
                    );

                    $iNotGood[$iID][$post->ID]['img_after_optm'][$order] = array(
                        'size' => 0,
                        'path' => $img_after,
                        'src' => $srcs['img_after_url'],
                        'src_origin' => $srcs['img_before_url'],
                        'width' => $width,
                        'height' => $height,
                        'dimension' => ImageHelper::IGetDimension($img_after)
                    );

                    //Get the number of images which their size are not good
                    if (!isset($iNotGoodTotal[$iID])) {
                        $iNotGoodTotal[$iID] = 0;
                    }
                    $iNotGoodTotal[$iID] ++;
                } else {
                    if (!isset($iNotGood[$iID])) {
                        $iNotGood[$iID] = array();
                    }
                    if (!isset($iNotGoodTotal[$iID])) {
                        $iNotGoodTotal[$iID] = 0;
                    }
                }

                //Get image that its meta/metas is/are not good
                if (count($meta_checkout) > 0) {
                    foreach ($meta_checkout as $key => $meta) {
                        $meta_value = $img[$meta];
                        $imNotGood[$iID][$post->ID]['ID'] = $post->ID;
                        $imNotGood[$iID][$post->ID]['title'] = $post->post_title;
                        $imNotGood[$iID][$post->ID]['post_type'] = $post->post_type;
                        $imNotGood[$iID][$post->ID]['meta'][$order]['img_src'] = $img['src'];
                        $imNotGood[$iID][$post->ID]['meta'][$order]['type'][$meta] = $meta_value;
                        if ($meta_value == '') {
                            if (!isset($imNotGoodTotal[$iID][$meta])) {
                                $imNotGoodTotal[$iID][$meta] = 0;
                            }
                            $imNotGoodTotal[$iID][$meta] ++;
                        }
                    }
                }
            }
        }

        foreach ($imgs as $name => $iID) {
            if (!isset($iNotGoodTotal[$iID])) {
                $iNotGoodTotal[$iID] = -1;
            }
            if (!isset($iNotGood[$iID])) {
                $iNotGood[$iID] = array();
            }
            if (!isset($imNotGood[$iID])) {
                $imNotGood[$iID] = array();
            }
            if (!isset($imNotGoodTotal[$iID])) {
                foreach ($meta_checkout as $mkey) {
                    $imNotGoodTotal[$iID][$mkey] = 0;
                }
            }
        }

        foreach ($imNotGoodTotal as &$mStatis) {
            foreach ($meta_checkout as $mkey) {
                if (!isset($mStatis[$mkey])) {
                    $mStatis[$mkey] = 0;
                }
            }
        }

        unset($posts, $imgs);

        $ret = array('iNotGood' => $iNotGood, 'iNotGoodTotal' => $iNotGoodTotal, 'imNotGood' => $imNotGood, 'imNotGoodTotal' => $imNotGoodTotal);

        return $ret;
    }

    /*
     * Scan image that has not good size or not good meta(s), then update info to postmeta table
     * @return: array of message that will be responsed to ajax call 
     */

    public static function IScanPosts($imgs, $meta_checking = false, $forceScan = false) {
        global $wpdb;
        $imgs_1 = array_slice($imgs, 0, 1);
        $idPost = array_shift($imgs_1); 
        
        // get list sizes image
        $metadats = get_post_meta($idPost, '_wp_attachment_metadata', true);
        $sizes = $metadats['sizes'];
        
        // get list url image and image thumbnail
        $list_thum_url = array();
        $imageUrl = wp_get_attachment_url($idPost);
        $list_thum_url[] = $imageUrl;
        foreach ($sizes as $key => $size){
            $thum_url = wp_get_attachment_image_src($idPost,$key);
            $list_thum_url[] = $thum_url[0];
        }

        $msg = array();
        $meta_keys = array('alt', 'title');
        $_imgs = array_flip($imgs);
        $post_types = MetaSeo_Content_List_Table::get_post_types();
        
        // sql where
        $w = '';
        $w .= '(';
        $i = 0;
        foreach ($list_thum_url as $url){
            $i++;
            if($i == count($list_thum_url)){
                $w .= ' post_content LIKE "%' . $url . '%"';
            }else{
                $w .= ' post_content LIKE "%' . $url . '%" OR';
            }
            
        }
        
        $w .= ')';
        $where = array();
        $where[] = "post_type IN ($post_types)";
        $where[] = "post_content LIKE '%<img%>%'";
        $where[] = $w;
        $query = "SELECT `ID`, `post_title`, `post_content`, `post_type`, `post_date`
					FROM $wpdb->posts
					WHERE ".implode(' AND ', $where)." ORDER BY ID";
        // query post
        $posts = $wpdb->get_results($query);
        $results = self::IPrepare($imgs, $posts, $meta_keys, $forceScan);
        //Update some value into fields in wp_postmeta
        if (count($results['iNotGood']) > 0) {
            foreach ($results['iNotGood'] as $iID => $post_group) {
                if ($results['iNotGoodTotal'][$iID] > 0) {
                    //This has a litle bit value
                    if ($results['iNotGoodTotal'][$iID] > 1) {
                        $im = ' images ';
                    } else {
                        $im = ' image ';
                    }

                    $msg[$iID]['iNotGood']['msg'] = __($results['iNotGoodTotal'][$iID] . $im . 'with wrong size', 'wp-meta-seo');
                    $msg[$iID]['iNotGood']['warning'] = true;

                    $msg[$iID]['iNotGood']['button'] = '<a href="javascript:void(0);" class=" img-resize button button-primary" data-img-name="' . $_imgs[$iID] . '" data-post-id="' . $iID . '" data-opt-key="resize_image" onclick="showPostsList(this)">' . __('Resize image', 'wp-meta-seo') . '<span class="spinner-light"></span></a>';

                    update_post_meta($iID, '_metaseo_resize_image_counter', $results['iNotGoodTotal'][$iID]);
                    update_post_meta($iID, '_metaseo_resize_image', $post_group);
                } else {
                    $msg[$iID]['iNotGood']['msg'] = __('Image sizes are good!', 'wp-meta-seo');
                    $msg[$iID]['iNotGood']['warning'] = false;

                    delete_post_meta($iID, '_metaseo_resize_image_counter');
                    delete_post_meta($iID, '_metaseo_resize_image');
                }
            }
        }
        
        // create list image wrong
        if (count($results['imNotGood']) > 0) {
            foreach ($results['imNotGood'] as $iID => $post_group) {
                //This has a litle bit value
                foreach ($meta_keys as $mkey) {
                    $text = '';
                    if ($mkey == 'alt') {
                        $text = ' text';
                    }

                    if ($results['imNotGoodTotal'][$iID][$mkey] > 1) {
                        $msg[$iID]['imNotGood']['msg'][$mkey] = __($results['imNotGoodTotal'][$iID][$mkey] . ' ' . $mkey . $text . 's are missing', 'wp-meta-seo');
                    } elseif ($results['imNotGoodTotal'][$iID][$mkey] == 1) {
                        $msg[$iID]['imNotGood']['msg'][$mkey] = __($results['imNotGoodTotal'][$iID][$mkey] . ' ' . $mkey . $text . ' is missing', 'wp-meta-seo');
                    }
                }

                $msg[$iID]['imNotGood']['warning'] = true;
                $msg[$iID]['imNotGood']['button'] = '<a href="javascript:void(0);" class=" fix-metas button button-primary" data-img-name="' . $_imgs[$iID] . '" data-post-id="' . $iID . '" data-opt-key="fix_metas" onclick="showPostsList(this)">' . __('Fix meta', 'wp-meta-seo') . '<span class="spinner-light"></span></a>';


                update_post_meta($iID, '_metaseo_fix_metas_counter', count($post_group));
                update_post_meta($iID, '_metaseo_fix_metas', $post_group);


                if ($results['imNotGoodTotal'][$iID]['alt'] == 0 && $results['imNotGoodTotal'][$iID]['title'] == 0) {
                    if ($results['iNotGoodTotal'][$iID] != -1) {
                        $msg[$iID]['imNotGood']['button'] = '<a href="javascript:void(0);" class=" fix-metas button" data-img-name="' . $_imgs[$iID] . '" data-post-id="' . $iID . '" data-opt-key="fix_metas" onclick="showPostsList(this)">' . __('Edit meta', 'wp-meta-seo') . '<span class="spinner-light"></span></a>';
                    } else {
                        $msg[$iID]['imNotGood']['button'] = '';
                    }
                    $msg[$iID]['imNotGood']['warning'] = false;
                    $msg[$iID]['imNotGood']['msg'] = '';
                }
            }
        }

        unset($results, $imgs);

        return $msg;
    }

    /*
     * Ajax optimize image and update content
     */
    public static function _optimizeImages($post_id, $img_post_id, $img_exclude) {
        global $wpdb;
        $ret = array('success' => false, 'msg' => '');
        $query = "SELECT `post_content` FROM $wpdb->posts WHERE `ID`=" . $post_id;

        if (!($post_content = @$wpdb->get_row($query)->post_content)) {
            $ret['msg'] = __('This post is not existed or deleted, please choose one another!', 'wp-meta-seo');

            return $ret;
        }

        $imgs_to_resize = get_post_meta($img_post_id, '_metaseo_resize_image', true);

        if (preg_match_all('/<img [^<>]+ \/>/i', $post_content, $matches)) {
            $img_tags = $matches[0];
            $replacement = array();
            foreach ($matches[0] as $order => $tag) {
                $replacement[$order] = $tag;
                //This block of code maybe changed later
                if (preg_match('/(width|height)="([^\"]+)"/i', $tag, $dimension)) {
                    if (!isset($imgs_to_resize[$post_id])) {
                        continue;
                    }
                    foreach ($imgs_to_resize[$post_id]['img_after_optm'] as $key => $img) {
                        if (!in_array($order, $img_exclude)) {
                            if (stripos($tag, $img['src_origin']) !== false &&
                                    (('width' == $dimension[1] && $dimension[2] == $img['width']) || ('height' == $dimension[1] && $dimension[2] == $img['height']))) {

                                $replacement[$order] = str_replace($img['src_origin'], $img['src'], $tag);
                            }
                        }
                    }
                }
                #}
            }

            //Replace all imgs sources that have new value
            $post_content = str_replace($matches[0], $replacement, $post_content);
        }

        //Update post content with all imgs has been just optimized
        $id = wp_update_post(array(
            'ID' => $post_id,
            'post_content' => $post_content
        ));

        if ($id) {
            $ret['success'] = true;
            $ret['msg'] = __('Well! This image is so good now.', 'wp-meta-seo');
        } else {
            $ret['msg'] = __('Opps! An error occured when updating the post, please try again', 'wp-meta-seo');
        }

        return $ret;
    }

    /**
     * create new size for image
     */
    public static function IResize($src, $width, $height, $destination) {
        if (!list($w_origin, $h_origin) = getimagesize($src))
            return "Unsupported picture type!";

        if (is_readable($destination)) {
            return true;
        }

        $type = strtolower(substr(strrchr($src, "."), 1));
        if ($type === 'jpeg')
            $type = 'jpg';
        switch ($type) {
            case 'bmp': $img = imagecreatefromwbmp($src);
                break;
            case 'gif': $img = imagecreatefromgif($src);
                break;
            case 'jpg': $img = imagecreatefromjpeg($src);
                break;
            case 'png': $img = imagecreatefrompng($src);
                break;
            default : return "Unsupported picture type!";
        }

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if ($type === "gif" or $type === "png") {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, 0, 0, $width, $height, $w_origin, $h_origin);

        //Output
        switch ($type) {
            case 'bmp': imagewbmp($new, $destination);
                break;
            case 'gif': imagegif($new, $destination);
                break;
            case 'jpg': imagejpeg($new, $destination);
                break;
            case 'png': imagepng($new, $destination);
                break;
        }

        return true;
    }

}
