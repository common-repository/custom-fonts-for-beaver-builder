<?php

/*
Plugin Name: Custom Fonts For Beaver Builder
Description: Use Elegant Custom Fonts with Beaver Builder. Font families added in Elegant Custom Fonts will appear in the font dropdowns in Beaver Builder Theme and Beaver Builder.
Version: 1.0
Author: Louis Reingold
Author URI: http://louisreingold.com/
License: MIT
*/






class ECF_BB_Plugin {
    public function __construct() {

        add_filter('fl_theme_system_fonts', array($this, 'merge_fonts')); // beaver builder theme customizer

        add_filter('fl_builder_font_families_system', array($this, 'merge_fonts')); // beaver buidler itself

        register_activation_hook(__FILE__, array($this, 'activation_hook'));

        add_action('admin_notices', array($this, 'admin_notices'));
    }

    function merge_fonts($existing_fonts) {

        if (class_exists('ECF_Plugin')) {
            $font_family_list = ECF_Plugin::get_font_families();

            foreach ($font_family_list as $family_name) {

                $existing_fonts[$family_name] = 
                array(
                    fallback => 'sans-serif',
                    weights => array('100', '200', '300', '400', '500', '600', '700', '800', '900')
                );

            }

        }

        return $existing_fonts;

    }

    function activation_hook() {
        set_transient('ECF_BB_Plugin-notice', true, 5);
    }

     function admin_notices() {
        if (get_transient('ECF_BB_Plugin-notice')) {
            if (class_exists('ECF_Plugin')) {
                ?>
                <div class="notice notice-success is-dismissible">
                    <p>Fonts added with Elegant Custom Fonts are now available for use with Beaver Builder and Beaver Builder theme.</p>
                </div>
                <?php
            } else {
                ?>
                <div class="notice notice-error is-dismissible">
                    <p>Elegant Custom Fonts must be active. <a href="plugin-install.php?tab=plugin-information&amp;plugin=elegant-custom-fonts&amp;TB_iframe=true&amp;width=772&amp;height=429" class="thickbox open-plugin-details-modal" aria-label="More information about Elegant Custom Fonts" data-title="Elegant Custom Fonts">Click here to install Elegant Custom Fonts from WordPress.org.</a></p>
                </div>
                <?php
            }

            delete_transient('ECF_BB_Plugin-notice');
        }
    }
    

}


$ECF_BB_Plugin = new ECF_BB_Plugin();

