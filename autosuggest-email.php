<?php
/*
Plugin Name:  Autosuggest Email
Plugin URI:   https://github.com/mpandzo/autosuggest-email
Description:  A WordPress plugin that allows you to provide autosuggest functionality for type=email input fields
Version:      1.0.0
Author:       mpandzo
Author URI:   https://mthit.com
License:      MIT License
*/

namespace MPandzo\AutoSuggestEmail;

defined( "ABSPATH" ) || exit; // Exit if accessed directly

if (!defined("AUTOCORRECT_EMAIL_VERSION")) {
    define("AUTOCORRECT_EMAIL_VERSION", "1.0.0");
}

class AutoSuggestEmail
{
    private $plugin_name = "AutoSuggestEmail";

    public function __construct()
    {
        add_action("wp_enqueue_scripts", array($this, "wp_enqueue_scripts"));
        add_action("admin_menu", array($this, "admin_menu"), 10);
        add_action("init", array($this, "load_plugin_textdomain"));
        add_action("admin_init", array($this, "register_autosuggest_email_settings"));
    }

    public function register_autosuggest_email_settings() {
        register_setting("autosuggest-email-settings", "ase_email_providers");
        register_setting("autosuggest-email-settings", "ase_email_tlds");
    }

    public function wp_enqueue_scripts() {
        wp_enqueue_script("autosuggest-email-lib", plugin_dir_url( __FILE__ ) . "js/autosuggest-email.js", array("jquery"), AUTOCORRECT_EMAIL_VERSION, true);
        wp_enqueue_script("autosuggest-email-script", plugin_dir_url( __FILE__ ) . "js/script.js", array("jquery"), AUTOCORRECT_EMAIL_VERSION, true);

        $custom_providers = get_option("ase_email_providers");
        $custom_tlds = get_option("ase_email_tlds");

        $custom_providers_array = array_filter(explode("\r\n", $custom_providers));
        $custom_tlds_array = array_filter(explode("\r\n", $custom_tlds));

        $ase = array(
            "domains" => $custom_providers_array,
            "tlds" => $custom_tlds_array,
        );

        wp_localize_script("autosuggest-email-script", "ase", $ase);
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain("autosuggest-email", false, dirname( plugin_basename( __FILE__ ) ) . "/languages" ); 
    }

    public function admin_menu() {
        add_menu_page(  $this->plugin_name, __("Autosuggest Email", "autosuggest-email"), "administrator", $this->plugin_name, array($this, "display_plugin_dashboard" ), "dashicons-email", 20);
    }

    public function display_plugin_dashboard() {
        require_once plugin_dir_path( __FILE__ ) . "/partials/admin-settings.php";
    }
}

new AutoSuggestEmail();