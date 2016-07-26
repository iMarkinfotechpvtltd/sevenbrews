<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class woocommerce_svi_admin {

    private static $_this;

    /**
     * init
     *
     * @since 1.0.0
     * @return bool
     */
    public function __construct() {
        $this->rosendolink = 'http://www.rosendo.pt';
        $this->title = __('Smart Variations Images for WooCommerce', 'wc_svi');
        $this->menutitle = __('SVI', 'wc_svi');

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
        self::$_this = $this;

        add_action('admin_enqueue_scripts', array($this, 'load_admin_scripts'));
        add_action('admin_menu', array($this, 'svi_menu'));

        add_filter('attachment_fields_to_edit', array($this, 'woo_svi_field'), 10, 2);
        add_filter('attachment_fields_to_save', array($this, 'woo_svi_field_save'), 10, 2);

// gets the author role
        $role = get_role('shop_manager');

// This only works, because it accesses the class instance.
// would allow the author to edit others' posts for current theme only
        $role->add_cap('manage_options');

        add_action('wp_ajax_woosvi_options', array($this, 'form_woosvi_options'));

        return true;
    }

    function form_woosvi_options() {

        $params = array();
        parse_str($_POST['data'], $params);

        $params = wp_parse_args($params, $this->defaults);

        $this->woosvi_options = $params;
        $res = update_option('woosvi_options', $this->woosvi_options, true);
        header("Content-type: application/json");
        echo json_encode($res);
        die();
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
     * load admin scripts
     *
     * @since 1.0.0
     * @return bool
     */
    function load_admin_scripts() {
        $suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '';

        $screen = get_current_screen();
        if ($screen->base == 'woocommerce_page_woocommerce_svi') {
            wp_enqueue_script('woo_svibootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'));
            wp_enqueue_script('bootstrap-checkbox.min', plugins_url('assets/js/bootstrap-checkbox.min.js', dirname(__FILE__)), array('jquery', 'woo_svibootstrap'));
            wp_enqueue_script('woo_svijs', plugins_url('assets/js/svi-admin-settings' . $suffix . '.js', dirname(__FILE__)), array('jquery', 'woo_svibootstrap'));
            wp_enqueue_style('font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css', null, null);
            wp_enqueue_style('woo_svicss_admin', plugins_url('assets/css/woo_svi_admin.css', dirname(__FILE__)), array('font-awesome'), null);
        }
    }

    /**
     * Add menu items.
     */
    function svi_menu() {
        add_submenu_page('woocommerce', $this->title, $this->menutitle, 'manage_woocommerce', 'woocommerce_svi', array($this, 'options_page'));
    }

    function options_page() {
        ?>
        <div id="woosvi_strap">
            <div class="container-fluid">
                <div class="col-lg-12">
                    <h1 class="text-center"><?php echo $this->title; ?></h1>
                    <center><small>by <a class="rosendo_logo" href="<?php echo $this->rosendolink; ?>" target="_blank">rosendo wDev</a></small></center>
                </div>
                <div class="clearfix"></div>
                <br>
                <ul class="nav nav-tabs">
                    <li class="active"><a aria-expanded="true" href="#home" data-toggle="tab"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> General settings</a></li>
                    <li><a aria-expanded="true" href="#pro" data-toggle="tab"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> PRO VERSION</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="home">
                        <div class="clearfix"></div>
                        <form class="form-horizontal" id="woosvi_options">
                            <div class="form-group">
                                <label class="col-lg-1 control-label lead">Deactivate SVI</label>
                                <div class="col-lg-10">
                                    <input class="woosvi_input input-default" type="checkbox" name="default" value="1" <?php checked($this->woosvi_options['default'], true, true); ?>>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <label class="col-lg-1 control-label lead">Slider <span class="text-warning">*</span></label>
                                <div class="col-lg-1">
                                    <input class="woosvi_input input-slider" type="checkbox" disabled="disabled">
                                </div>
                                <div class="form-subgroup">
                                    <label class="col-lg-1 control-label lead">Position <span class="text-warning">*</span></label>
                                    <div class="col-lg-2">
                                        <input type="checkbox" data-off-class="btn-warning" data-off-label="Bottom" data-on-label="Left" data-on-class="btn-primary" class="woosvi_input input-slider-position" value="1" disabled="disabled">
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label class="col-lg-1 control-label lead">Ligthbox</label>
                                <div class="col-lg-10">
                                    <input class="woosvi_input input-lightbox" type="checkbox" name="lightbox" value="1" <?php checked($this->woosvi_options['lightbox'], true, true); ?>>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label class="col-lg-1 control-label lead">Hide Thumbs</label>
                                <div class="col-lg-10">
                                    <input class="woosvi_input input-hide_thumbs" type="checkbox" name="hide_thumbs" value="1" <?php checked($this->woosvi_options['hide_thumbs'], true, true); ?>>
                                    <small>Hide thumbs until variations selected</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label class="col-lg-1 control-label lead">Magnifier Lens</label>
                                <div class="col-lg-1">
                                    <input class="woosvi_input input-lens" type="checkbox" name="lens" value="1" <?php checked($this->woosvi_options['lens'], true, true); ?>>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-subgroup">
                                        <div class="col-lg-1 control-label lead">Lens type <span class="text-warning">*</span></div>
                                        <div class="col-lg-2">
                                            <select class="form-control input-col" disabled="disabled">
                                                <option value="round">Round</option>
                                                <option value="square">Square</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-subgroup">
                                        <div class="col-lg-1 control-label lead">Lens Size <span class="text-warning">*</span></div>
                                        <div class="col-lg-1">
                                            <input type="number" class="form-control input-col" placeholder="150" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="form-subgroup">
                                        <div class="col-lg-2 control-label lead">Zoom Type <span class="text-warning">*</span></div>
                                        <div class="col-lg-2">
                                            <select disabled="disabled" class="form-control input-col">
                                                <option value="lens">Lens</option>
                                                <option value="window">Window</option>
                                                <option value="inner">Inner</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="form-subgroup">
                                        <div class="col-lg-2 control-label lead">Scrool Zoom <span class="text-warning">*</span></div>
                                        <div class="col-lg-2">
                                            <input class="woosvi_input input-lens-scrollzoom" type="checkbox" disabled="disabled">
                                        </div>
                                    </div>
                                    <div class="form-subgroup">
                                        <div class="col-lg-2 control-label lead">Lens Fade <span class="text-warning">*</span></div>
                                        <div class="col-lg-2">
                                            <input class="woosvi_input input-lens-fade" type="checkbox" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label for="thumbCol" class="col-lg-1 control-label lead">Thumbnail Columns</label>
                                <div class="col-lg-1">
                                    <?php $cols = ($this->woosvi_options['columns'] == '') ? 4 : $this->woosvi_options['columns']; ?>
                                    <input class="form-control input-col" id="thumbCol" placeholder="4" name="columns" value="<?php echo $cols; ?>" type="number" min="1" max="5" required> <small>(max: 5)</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label class="col-lg-1 control-label lead">Force SVI <span class="text-warning">*</span></label>
                                <div class="col-lg-4">
                                    <input class="woosvi_input input-sviforce" type="checkbox" disabled="disabled"><br>
                                    <small>(Try this option if layout seems broken, if it doesnt work please use a Custom class)</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label for="thumbCustomClass" class="col-lg-1 control-label lead">Custom class <span class="text-warning">*</span></label>
                                <div class="col-lg-3">
                                    <input class="form-control input-col" id="thumbCustomClass" readonly="readonly" type="text">
                                    <small>(Insert custom css class(es) to fit your theme needs)</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label for="thumbCustomClass" class="col-lg-1 control-label lead">Cart Image <span class="text-warning">*</span></label>
                                <div class="col-lg-3">
                                    <input class="woosvi_input input-svicart" type="checkbox" disabled="disabled"><br>
                                    <small>Display choosen variation image in cart/checkout instead of default Product image</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group hidden">
                                <label for="thumbCustomClass" class="col-lg-1 control-label lead">Swap Select <span class="text-warning">*</span></label>
                                <div class="col-lg-3">
                                    <input class="woosvi_input input-swselect" type="checkbox" disabled="disabled"><br>
                                    <small>Swap Variation select on thumbnail click</small>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary"><span class="submittext">Submit</span> <i class="fa fa-refresh fa-spin hidden"></i></button>
                                </div>
                            </div>
                        </form>
                        <p class="lead text-warning pull-right">* available in <strong>Pro version</strong></p>
                    </div>
                    <div class="tab-pane fade" id="pro">
                        <h2 class="bs-docs-featurette-title">SVI PRO Designed to work everywhere.</h2>
                        <p class="lead">Woocommerce doesnt allow multiple images for variation, SVI does and turns it even easier!</p>
                        <hr class="half-rule">
                        <div class="row">
                            <div class="col-sm-3">
                                <h3>Vertical and Horizontal slider</h3>
                                <p>The most modern mobile touch slider with hardware accelerated transitions and amazing native behavior.</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Extra zoom options</h3>
                                <p>Zooming images within a container or also in a "lens" that floats overtop of web page.</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Theme compatability</h3>
                                <p>Compatible with most of the major themes! If it doesnt work? Contact-me, we will figure out a solution.</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>WPML compatability</h3>
                                <p>Compatible with WPML! All slugs correctly translated!</p>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-sm-3">
                                <h3>Custom CSS Class</h3>
                                <p>Breaking your theme? Insert custom css class(es) to fit your theme needs.</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Force SVI</h3>
                                <p>Not showing in position? Try forcing it to position so that it stays either at the left or right side.</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Variation image in Cart</h3>
                                <p>The variation selected by the user get automaticly added to the cart instead of the default image</p>
                            </div>
                            <div class="col-sm-3">
                                <h3>Swap Select</h3>
                                <p>When the user click a thumbnail of the variation, automaticly shows al images related to that variation.</p>
                            </div>
                        </div>
                        <hr class="half-rule">
                        <p class="lead">Try de demo, before you buy!</p>
                        <p><b>URL: </b> <a href="http://svi.rosendo.pt/pro">http://svi.rosendo.pt/pro</a><br>
                            <b>user: </b> woosvi_tester<br>
                            <b>pass: </b> woosvi_tester<br>
                        </p>
                        <center>
                            <a class="btn btn-lg btn-success" href="http://www.rosendo.pt/product/smart-variations-images-pro/" target="_blank">BUY NOW!</a><br>
                            <br><p><strong>No refunds</strong>, test the free version before buying!</p>
                        </center>
                    </div>
                </div>

                <center><a href="https://wordpress.org/support/view/plugin-reviews/smart-variations-images" target="_blank"><img src="<?php echo plugins_url('/assets/images/review.png', dirname(__FILE__)); ?>"></a></center>

            </div>
        </div>
        <?php
    }

    /**
     * Add woovsi field to media uploader
     *
     * @param $form_fields array, fields to include in attachment form
     * @param $post object, attachment record in database
     * @return $form_fields, modified form fields
     */
    function woo_svi_field($form_fields, $post) {

        if (isset($_POST['post_id']) && $_POST['post_id'] != '0') {
            $in_use = false;
            $wc = new WC_Product($_POST['post_id']);
            $att = $wc->get_attributes();

            if (!empty($att)) {

                $current = get_post_meta($post->ID, 'woosvi_slug', true);

                $html .= "<select name='attachments[{$post->ID}][woosvi-slug]' id='attachments[{$post->ID}][woosvi-slug]'>";

                $variations = false;

                $html .= "<option value='' " . selected($current, '', false) . ">none</option>";

                foreach ($att as $key => $attribute) {
                    if ($attribute['is_taxonomy']) {

                        $terms = wp_get_post_terms($_POST['post_id'], $key, 'all');

                        if (!empty($terms)) {
                            $variations = true;
                            foreach ($terms as $term) {
                                if ($current == $term->slug)
                                    $in_use = true;
                                $html .= "<option value='" . $term->slug . "' " . selected($current, $term->slug, false) . ">" . $term->name . "</option>";
                            }
                        }
                    } else {
                        $values = str_replace(" ", "", $attribute['value']);
                        $terms = explode('|', $values);
                        if (!empty($terms)) {
                            $variations = true;
                            foreach ($terms as $term) {
                                if ($current == strtolower($term))
                                    $in_use = true;
                                $html .= "<option value='" . strtolower($term) . "' " . selected($current, strtolower($term), false) . ">" . $term . "</option>";
                            }
                        }
                    }
                }

                if (!$in_use && $current != '')
                    $html .= "<option value='$current' " . selected($current, $current, false) . ">" . $current . "</option>";

                $html .= '</select>';
                $helps = '';
                if (!$in_use && $current != '')
                    $helps = '<div style="color:red;">Image in use by other product, if you wish to use with this product upload another new/same image.<br><strong>Image will not be displayed!</strong></div><br>';

                if ($variations) {
                    $form_fields['woosvi-slug'] = array(
                        'label' => 'Variation',
                        'input' => 'html',
                        'html' => $html,
                        'application' => 'image',
                        'exclusions' => array(
                            'audio',
                            'video'
                        ),
                        'helps' => $helps . 'Choose the variation'
                    );
                } else {
                    $form_fields['woosvi-slug'] = array(
                        'label' => 'Variation',
                        'input' => 'html',
                        'html' => 'This product doesn\'t seem to be using any variations.',
                        'application' => 'image',
                        'exclusions' => array(
                            'audio',
                            'video'
                        ),
                        'helps' => 'Add variations to the product and Save'
                    );
                }
            }
        }
        return $form_fields;
    }

    /**
     * Save values of woovsi in media uploader
     *
     * @param $post array, the post data for database
     * @param $attachment array, attachment fields from $_POST form
     * @return $post array, modified post data
     */
    function woo_svi_field_save($post, $attachment) {
        if (isset($attachment['woosvi-slug']))
            update_post_meta($post['ID'], 'woosvi_slug', $attachment['woosvi-slug']);


        return $post;
    }

}

new woocommerce_svi_admin();
