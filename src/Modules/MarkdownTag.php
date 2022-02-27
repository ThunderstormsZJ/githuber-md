<?php

/**
 * Module Name: MarkdownTag
 */

namespace Githuber\Module;

class MarkdownTag extends ModuleAbstract
{
	public $tag_version = '1.0.0';

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
	    wp_enqueue_script( 'tag-src', GITHUBER_PLUGIN_URL . 'assets/js/md-tag-main.js', array(), $this->tag_version, true);
    }

    public function front_print_footer_scripts()
    {

    }
}