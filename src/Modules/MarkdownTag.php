<?php

/**
 * Module Name: MarkdownTag
 */

namespace Githuber\Module;

class MarkdownTag extends ModuleAbstract
{

    public function init()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'front_enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'front_enqueue_scripts' ) );
        add_action( 'wp_print_footer_scripts', array( $this, 'front_print_footer_scripts' ) );
    }

    public function front_enqueue_styles()
    {
        wp_register_style( 'tag-style',GITHUBER_PLUGIN_URL . 'assets/css/md-tag-style.css');
        wp_enqueue_style( 'tag-style');
    }

    public function front_enqueue_scripts()
    {
        wp_register_script( 'tag-src', GITHUBER_PLUGIN_URL . 'assets/js/md-tag-main.js', array( 'jquery' ));
        wp_enqueue_script( 'tag-src' );
    }

    public function front_print_footer_scripts()
    {

    }
}