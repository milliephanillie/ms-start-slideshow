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

/**
 * Functionality to add slideshow xml to any post that has non-empty msss_slides fields from ACF. This code should remain at the bottom
 * of the functions.php file. For additional customizations, a small plugin can be built.
 * When originally built, the ACF fields were set to only display on posts with a category of 'slideshows'
 * Contact me@philiparudy.com for troubleshooting with subject "Microsoft Start Plugin Help."
 * 
 * 
 * */
class MsStartSlideshow {
    public function __construct() {
        // If ACF plugin is installed, handle the ACF slides
        if(class_exists('ACF')) {
            add_action('the_content', [$this, 'maybe_do_acf_slides'], 1);
            add_action('rss2_item', [$this, 'maybe_add_slideshow_to_rss_feed']);
        	add_action('rss2_ns', [$this, 'add_custom_rss_namespaces']);
        }
    }

    public function add_custom_rss_namespaces() {
        echo 'xmlns:media="http://search.yahoo.com/mrss/"';
    }

    // Add slides to the RSS feed in the correct format
    public function maybe_add_slideshow_to_rss_feed() {
        if (have_rows('msss_slides')) {
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
        }
    }

    // Add slideshow to the content output
    public function maybe_do_acf_slides($content) {
		$html = '';
		
		if (have_rows('msss_slides')) {
			$html = '<div class="slideshow" style="padding: 15px 0;">';

			// Optional: Author and Title elements for slideshow inline
			

			while (have_rows('msss_slides')) {
				the_row();
				
				$html .= '<div class="slideshow_slide" style="padding: 10px 0;">';
				$html .= '<div class="slideshow_slide_title"><h2>' . get_sub_field('msss_slide_title') . '</h2></div>';

				$html .= '<figure>';
				$html .= '<img src="' . get_sub_field('msss_slide_image')['url'] . '" alt="' . get_sub_field('msss_slide_title') . '">';
				$html .= '<figcaption>' . get_sub_field('msss_slide_description');

				if(get_sub_field('msss_slide_image_credit')) {
					$html .= '<span class="copyright">' . get_sub_field('msss_slide_image_credit') . '</span>'; // Assuming alt text for copyright
				}

				$html .= '</figcaption>';
				$html .= '</figure>';
				$html .= '</div>';
			}
			$html .= '</div>';
		}

        return $content . $html;
    }
}

add_action('wp', function() {
    $msStartSlideshow = new MsStartSlideshow();
});