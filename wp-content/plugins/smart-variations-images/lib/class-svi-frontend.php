<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class woocommerce_svi_frontend {

    private static $_this;

    /**
     * init
     *
     * @since 1.0.0
     * @return bool
     */
    public function __construct() {
        global $woosvi;

        $this->woosvi_defaultprod = get_option('woosvi_defaultprod');
        $this->woosvi_activate = get_option('woosvi_activate'); //LENS
        $this->woosvi_columns = get_option('woosvi_columns'); // COLUMS FOR THUMBANILS
        $this->woosvi_lightbox = get_option('woosvi_lightbox'); // LIGTHBOX
        $this->updated = get_option('woosvi_updated');
        $woosvi_options = get_option('woosvi_options');

        $this->defaults = array(
            'default' => false,
            'lens' => false,
            'columns' => 4,
            'lightbox' => false,
            'hide_thumbs' => false,
        );

        $this->woosvi_options = wp_parse_args($woosvi_options, $this->defaults);

        if (!$this->updated) {
            $this->woosvi_options = array(
                'default' => $this->woosvi_defaultprod,
                'lens' => $this->woosvi_activate,
                'columns' => $this->woosvi_columns,
                'lightbox' => $this->woosvi_lightbox,
            );

            update_option('woosvi_options', $this->woosvi_options, true);
            update_option('woosvi_updated', true, false);
            delete_option('woosvi_defaultprod');
            delete_option('woosvi_activate');
            delete_option('woosvi_columns');
            delete_option('woosvi_lightbox');
        }


        $class = array('woosvi_images');
        $lens = array();
        if ($this->woosvi_options['lens']) {
            array_push($class, 'woosvi_lens');
        }
        if ($this->woosvi_options['lightbox']) {
            array_push($class, 'woosvi_lightbox');
        }

        if ($this->woosvi_options['hide_thumbs']) {
            array_push($class, 'svihide_thumbs');
        }

        $woosvi = array(
            'data' => $this->woosvi_options,
            'class' => implode(' ', $class),
            'lens' => implode(' ', $lens)
        );

        add_action('wp_enqueue_scripts', array($this, 'load_scripts'), 150, 1);
        add_action('template_redirect', array($this, 'remove_gallery_and_product_images'), 10);
        add_filter('wp_get_attachment_image_attributes', array($this, 'add_woosvi_attribute'), 10, 2);

        return $this;
    }

    /**
     * public function to get instance
     *
     * @since 1.1.1
     * @return instance object
     */
    public function get_instance() {
        return self::$_this;
    }

    /**
     * load front-end scripts
     *
     * @since 1.0.0
     * @return bool
     */
    function load_scripts() {
        global $wp_styles, $woocommerce;

        $suffix = WP_DEBUG ? '' : '.min';

        $loads = array(
            'jquery'
        );

        if ($this->woosvi_options['lens']) {
            wp_enqueue_script('ezlens', plugins_url('assets/js/jquery.ez-plus' . $suffix . '.js', dirname(__FILE__)), array('jquery'), null, true);
            array_push($loads, 'ezlens');
        }

        if ($this->woosvi_options['lightbox']) {
            # prettyPhoto
            $handle = 'prettyPhoto' . $suffix . '.js';
            $list = 'enqueued';

            if (!wp_script_is($handle, $list)) {
                wp_enqueue_script('prettyPhoto', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array('jquery'), $woocommerce->version, true);
                wp_enqueue_script('prettyPhoto-init', $woocommerce->plugin_url() . '/assets/js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array('jquery'), $woocommerce->version, true);
                wp_enqueue_style('prettyPhoto_css', $woocommerce->plugin_url() . '/assets/css/prettyPhoto.css');
                array_push($loads, 'prettyPhoto', 'prettyPhoto-init');
            }
        }


        # add-to-cart-variation
        $handle = 'add-to-cart-variation' . $suffix . '.js';
        $list = 'enqueued';
        if (!wp_script_is($handle, $list)) {
            array_push($loads, 'wc-add-to-cart-variation');
        }

        wp_enqueue_script('woo_svijs', plugins_url('assets/js/svi-frontend' . $suffix . '.js', dirname(__FILE__)), $loads, null, true);

        $styles = null;
        $srcs = array_map('basename', (array) wp_list_pluck($wp_styles->registered, 'src'));
        $key_woocommerce = array_search('woocommerce.css', $srcs);

        if ($key_woocommerce) {
            $styles = array(
                $key_woocommerce,
            );
        }

        wp_enqueue_style('woo_svicss', plugins_url('assets/css/woo_svi' . $suffix . '.css', dirname(__FILE__)), $styles, null);
    }

    function localize_script() {
        // We also need the wp.template for this script :)
        wc_get_template('single-product/add-to-cart/variation.php');

        $handle = 'wc_add_to_cart_variation';
        $data = array(
            'i18n_no_matching_variations_text' => esc_attr__('Sorry, no products matched your selection. Please choose a different combination.', 'woocommerce'),
            'i18n_unavailable_text' => esc_attr__('Sorry, this product is unavailable. Please choose a different combination.', 'woocommerce'),
        );
        $name = str_replace('-', '_', $handle) . '_params';
        wp_localize_script($handle, $name, apply_filters($name, $data));
    }

    /**
     * Add SVI slug to images
     *
     * @since 1.0.0
     * @return html
     */
    function add_woosvi_attribute($html, $post) {
        $current = get_post_meta($post->ID, 'woosvi_slug', true);
        if ($this->woosvi_options['lens']) {
            $img = wp_get_attachment_image_src($post->ID, 'full');
            $html['data-svizoom-image'] = $img[0];
        }
        $html['data-woosvi'] = $current;

        return $html;
    }

    /**
     * Remove default theme Product Images
     *
     */
    function remove_gallery_and_product_images() {
        if (is_product()) {
            if (!$this->woosvi_options['default']) {
                add_filter('woocommerce_product_thumbnails_columns', array($this, 'woo_svi_filter_woocommerce_product_thumbnails_columns'), 11, 1);
                add_filter('woocommerce_locate_template', array($this, 'woo_svi_locate_template'), 1, 3);

                add_filter('single_product_large_thumbnail_size', create_function('', 'return "shop_single";'));
                add_filter('single_product_small_thumbnail_size', create_function('', 'return "shop_single";'));
            }
        }
    }

    function woo_svi_filter_woocommerce_product_thumbnails_columns($number) {
        $number = $this->woosvi_options['columns'];
        if (empty($number) || $number < 1)
            $number = 3;

        return $number;
    }

    function woo_svi_plugin_path() {
        return untrailingslashit(plugin_dir_path(dirname(__FILE__)));
    }

    function woo_svi_locate_template($template, $template_name, $template_path) {

        global $woocommerce;

        $_template = $template;

        if (!$template_path)
            $template_path = $woocommerce->template_url;

        $plugin_path = $this->woo_svi_plugin_path() . '/woocommerce/';
        // Look within passed path within the theme - this is priority

        $template = locate_template(
                array(
                    $template_path . $template_name,
                    $template_name
                )
        );

        // Modification: Get the template from this plugin, if it exists

        if (file_exists($plugin_path . $template_name)) {
            $template = $plugin_path . $template_name;
        }

        // Use default template

        if (!$template)
            $template = $_template;

        // Return what we found
        return $template;
    }

    function build_mainimage() {
        global $post, $product;

        if (has_post_thumbnail()) {
            $image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
            $image_link = wp_get_attachment_url(get_post_thumbnail_id());
            $image = get_the_post_thumbnail($post->ID, apply_filters('single_product_large_thumbnail_size', 'shop_single'), array(
                'title' => get_the_title(get_post_thumbnail_id())
            ));

            $attachment_count = count($product->get_gallery_attachment_ids());

            if ($attachment_count > 0) {
                $gallery = '[product-gallery]';
            } else {
                $gallery = '';
            }

            echo apply_filters('woocommerce_single_product_image_html', sprintf('<div id="woosvimain"><a href="%s" itemprop="image" class="woocommerce-main-image hidden" title="%s" data-rel="prettyPhoto' . $gallery . '" data-o_href="%s">%s</a></div>', $image_link, $image_caption, $image_link, $image), $post->ID);
        } else {

            echo apply_filters('woocommerce_single_product_image_html', sprintf('<img src="%s" alt="%s" />', wc_placeholder_img_src(), __('Placeholder', 'woocommerce')), $post->ID);
        }
    }

    function build_thumbimage() {
        global $post, $product, $woosvi;

        $attachment_ids = $product->get_gallery_attachment_ids();

        if ($attachment_ids) {
            $loop = 0;
            $columns = apply_filters('woocommerce_product_thumbnails_columns', 3);
            ?>
            <div class="svithumbnails <?php echo 'columns-' . $columns; ?> hidden" data-columns="<?php echo $columns; ?>"><?php
                foreach ($attachment_ids as $attachment_id) {

                    $classes = array('');

                    if ($loop === 0 || $loop % $columns === 0)
                        $classes[] = 'first';

                    if (( $loop + 1 ) % $columns === 0)
                        $classes[] = 'last';

                    $image_link = wp_get_attachment_url($attachment_id);

                    if (!$image_link)
                        continue;

                    $image_title = esc_attr(get_the_title($attachment_id));
                    $image_caption = esc_attr(get_post_field('post_excerpt', $attachment_id));

                    $image = wp_get_attachment_image($attachment_id, apply_filters('single_product_small_thumbnail_size', 'shop_thumbnail'), 0, $attr = array(
                        'title' => $image_title,
                        'alt' => $image_title
                    ));

                    $image_class = esc_attr(implode(' ', $classes));

                    if ($woosvi['data']['lightbox'])
                        $lightbox = 'gallery';
                    else
                        $lightbox = get_post_meta($attachment_id, 'woosvi_slug', true);

                    echo apply_filters('woocommerce_single_product_image_thumbnail_html', sprintf('<a href="%s" class="%s" title="%s" data-rel="prettyPhoto[%s]">%s</a>', $image_link, $image_class, $image_caption, $lightbox, $image), $attachment_id, $post->ID, $image_class);

                    $loop++;
                }
                ?></div>
            <?php
        }
    }

}

function woosvi_class() {
    global $woosvi_class;

    if (!isset($woosvi_class)) {
        $woosvi_class = new woocommerce_svi_frontend();
    }

    return $woosvi_class;
}

// initialize
woosvi_class();
