<?php
/**
 * Plugin Name: MS Start Slideshow
 * Description: Microsoft Start Slideshow Add-On
 * Version: 1.0.0
 * Author: Philip Rudy
 * Author URI: https://www.philiparudy.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ms-start-slideshow
 * Domain Path: /languages
 */

if(!defined('ABSPATH')) {
    exit;
}

if(!defined('MSSS_PLUGIN_FILE')) {
    define('MSSS_PLUGIN_FILE', __FILE__);
}

if(!defined('MSSS_PLUGIN_PATH')) {
    define('MSSS_PLUGIN_PATH', plugin_dir_path(__FILE__));
}  

if(!defined('MSSS_PLUGIN_URL')) {
    define('MSSS_PLUGIN_URL', plugin_dir_url(__FILE__));
}

if(!defined('MSSS_ASSETS_VERSION')) {
    define('MSSS_ASSETS_VERSION', '1.3.12');
}

// We want to get the meta slider post
// if there is a category of slideshow on the wordpress post we want to get the slideshow and display it, as well as make
// the ress feed have a custom entry for the slideshow
class MsStartSlideshow {
    public function __construct() {
        // If ACF plugin is installed, handle the ACF slides
        if(class_exists('ACF')) {
            add_action('the_content', [$this, 'maybe_do_acf_slides']);
            add_action('rss2_item', [$this, 'maybe_add_slideshow_to_rss_feed']);
            add_action('rss2_ns', 'add_custom_rss_namespaces');
        }
    }

    public function add_custom_rss_namespaces() {
        echo 'xmlns:media="http://search.yahoo.com/mrss/"';
    }

    // Add slides to the RSS feed in the correct format
    public function maybe_add_slideshow_to_rss_feed() {
        if (have_rows('msss_slides')) {
            echo '<media:group>';
            while (have_rows('msss_slides')) {
                the_row();

                if(get_sub_field('msss_slide_image')['url']) {
                    echo '<media:content url="' . get_sub_field('msss_slide_image')['url'] . '" type="image/jpeg" medium="image">';
                

                    if(get_sub_field('msss_slide_title')) {
                        echo '<media:title><![CDATA[' . get_sub_field('msss_slide_title') . ']]></media:title>';
                    }

                    if(get_sub_field('msss_slide_description')) {
                        echo '<media:description><![CDATA[' . get_sub_field('msss_slide_description') . ']]></media:description>';
                    }

                    if(get_sub_field('msss_slide_image_credit')) {
                        echo '<media:credit><![CDATA[' . get_sub_field('msss_slide_image_credit') . ']]></media:credit>';
                    }

                    echo '</media:content>';
                }
            }
            echo '</media:group>';
        }
    }

    // Add slideshow to the content output
    public function maybe_do_acf_slides($content) {
        $post_id = get_the_ID();
        $category = get_the_category($post_id);
        $html = '';

        if ($category) {
            foreach ($category as $cat) {
                if ('slideshows' === $cat->name || 'slideshow' === $cat->name) {
                    if (have_rows('msss_slides')) {
                        $html = '<div class="slideshow" style="padding: 20px 0;">';

                        // Optional: Author and Title elements for slideshow inline
                        $html .= '<cite>' . get_the_author() . '</cite>';
                        $html .= '<title>' . get_the_title() . '</title>';

                        while (have_rows('msss_slides')) {
                            the_row();

                            $html .= '<figure>';
                            $html .= '<img src="' . get_sub_field('msss_slide_image')['url'] . '" alt="' . get_sub_field('msss_slide_title') . '">';
                            $html .= '<figcaption>' . get_sub_field('msss_slide_description');

                            if(get_sub_field('msss_slide_image_credit')) {
                                $html .= '<span class="copyright">' . get_sub_field('msss_slide_image_credit') . '</span>'; // Assuming alt text for copyright
                            }
                            
                            $html .= '</figcaption>';
                            $html .= '</figure>';
                        }
                        $html .= '</div>';
                    }
                }
            }
        }

        return $content . $html;
    }
}

add_action('wp', function() {
    $msStartSlideshow = new MsStartSlideshow();
});


