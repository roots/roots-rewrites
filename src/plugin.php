<?php
class Roots_Rewrites {
  private static $path; // Setup path, doubles as a singleton class

  function __construct($path) {
    if (isset(self::$path)) { return; }
    self::$path = $path;

    register_activation_hook($path, array($this, 'flush_rewrites'));
    register_deactivation_hook($path, array($this, 'flush_rewrites'));

    $get_theme_name = explode('/themes/', get_template_directory());
    $home_url = array(home_url('/', 'http'), home_url('/', 'https'));

    /**
     * Define helper constants
     */
    define('RELATIVE_PLUGIN_PATH',  str_replace($home_url, '', plugins_url()));
    define('RELATIVE_CONTENT_PATH', str_replace($home_url, '', content_url()));
    define('THEME_NAME',            next($get_theme_name));
    define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME . '/assets');

    if (is_admin()) {
      add_action('admin_init', array($this, 'backend'));
    } else {
      add_action('after_setup_theme', array($this, 'frontend'));
    }
  }

  public function frontend() {
    if ($this->disabled() || is_admin()) { return; }
    $tags = array(
      'plugins_url',
      'bloginfo',
      'stylesheet_directory_uri',
      'template_directory_uri',
      'script_loader_src',
      'style_loader_src'
    );

    $this->add_filters($tags, array($this, 'roots_clean_urls'));
  }

  public function backend() {
    if ($this->disabled()) { return; }
    global $wp_rewrite;

    $roots_new_non_wp_rules = array(
      'assets/(.*)'  => THEME_PATH . '/$1',
      'plugins/(.*)' => RELATIVE_PLUGIN_PATH . '/$1'
    );

    $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $roots_new_non_wp_rules);
    return;
  }

  public function roots_clean_urls($content) {
    if (strpos($content, RELATIVE_PLUGIN_PATH) > 0) {
      return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);
    } else {
      return str_replace('/' . THEME_PATH, '/assets', $content);
    }
  }

  public function flush_rewrites() {
    flush_rewrite_rules();
  }

  private function deactivated() {
    $path = plugin_basename(self::$path);
    return did_action('deactivate_' . $path);
  }

  private function disabled() {
    if (is_multisite() || is_child_theme() || $this->deactivated()) { return true; }
    return false;
  }

  private function add_filters($tags, $function) {
    foreach($tags as $tag) {
      add_filter($tag, $function);
    }
  }

}
