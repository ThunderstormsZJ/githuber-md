<?php 
if ( ! defined('GITHUBER_PLUGIN_NAME') ) die; 
/**
 * View for CSS
 *
 * @author Terry Lin
 * @link https://terryl.in/
 *
 * @package Githuber
 * @since 1.6.1
 * @version 1.6.1
 */
?>

<?php if ( 'yes' === githuber_get_option( 'support_task_list', 'githuber_extensions' ) ) : ?>
    .gfm-task-list {
        border: 1px solid transparent;
        list-style-type: none;
    }
    .gfm-task-list input {
        margin-right: 10px !important;
    }
<?php endif; ?>

<?php if ( 'yes' === githuber_get_option( 'support_katex', 'githuber_modules' ) ) : ?>
    .katex-container {
        margin: 25px !important;
        text-align: center;
    }
    .katex-container.katex-inline {
        display: inline-block !important;
        background: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    pre .katex-container {
        font-size: 1.4em !important;
    }
    .katex-inline {
        background: none !important;
        margin: 0 3px;
    }
<?php endif; ?>

<?php if ( '_blank' === githuber_get_option( 'post_link_target_attribute', 'githuber_preferences' ) ) : ?>
    code.kb-btn {
        display: inline-block;
        color: #666;
        font: bold 9pt arial;
        text-decoration: none;
        text-align: center;
        padding: 2px 5px;
        margin: 0 5px;
        background: #eff0f2;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border-top: 1px solid #f5f5f5;
        -webkit-box-shadow: inset 0 0 20px #e8e8e8, 0 1px 0 #c3c3c3, 0 1px 0 #c9c9c9, 0 1px 2px #333;
        -moz-box-shadow: inset 0 0 20px #e8e8e8, 0 1px 0 #c3c3c3, 0 1px 0 #c9c9c9, 0 1px 2px #333;
        box-shadow: inset 0 0 20px #e8e8e8, 0 1px 0 #c3c3c3, 0 1px 0 #c9c9c9, 0 1px 2px #333;
        text-shadow: 0px 1px 0px #f5f5f5;
    }
<?php endif; ?>

<?php if ( 'yes' == githuber_get_option( 'support_toc', 'githuber_modules' ) ) : ?>

    .md-widget-toc {
        padding: 15px;
    }
    .md-widget-toc a {
        color: #333333;
    }
    .post-toc-header {
        font-weight: 600;
        margin-bottom: 10px;
    }
    .md-post-toc {
        font-size: 0.9em;
    }
    .post h2 {
        overflow: hidden;
    }
    .post-toc-block {
        margin: 0 10px 20px 10px;
        overflow: hidden;
    }
    .post-toc-block.with-border {
        border: 1px #dddddd solid;
        padding: 10px;
    }
    .post-toc-block.float-right {
        max-width: 320px;
        float: right;
    }
    .post-toc-block.float-left {
        max-width: 320px;
        float: left;
    }
    .md-widget-toc ul, .md-widget-toc ol, .md-post-toc ul, .md-post-toc ol {
        padding-left: 15px;
        margin: 0;
    }
    .md-widget-toc ul ul, .md-widget-toc ul ol, .md-widget-toc ol ul, .md-widget-toc ol ol, .md-post-toc ul ul, .md-post-toc ul ol, .md-post-toc ol ul, .md-post-toc ol ol {
        padding-left: 2em;
    }
    .md-widget-toc ul ol, .md-post-toc ul ol {
        list-style-type: lower-roman;
    }
    .md-widget-toc ul ul ol, .md-widget-toc ul ol ol, .md-post-toc ul ul ol, .md-post-toc ul ol ol {
        list-style-type: lower-alpha;
    }
    .md-widget-toc ol ul, .md-widget-toc ol ol, .md-post-toc ol ul, .md-post-toc ol ol {
        padding-left: 2em;
    }
    .md-widget-toc ol ol, .md-post-toc ol ol {
        list-style-type: lower-roman;
    }
    .md-widget-toc ol ul ol, .md-widget-toc ol ol ol, .md-post-toc ol ul ol, .md-post-toc ol ol ol {
        list-style-type: lower-alpha;
    }

<?php endif; ?>

<?php if ( 'yes' == githuber_get_option( 'support_mathjax', 'githuber_modules' ) ) : ?>

    .post pre code script, .language-mathjax ~ .copy-button {
        display: none !important;
    }

<?php endif; ?>

<?php if ( 'yes' === githuber_get_option( 'support_emojify', 'githuber_modules' ) ) : ?>
    <?php $emoji_size = githuber_get_option( 'emojify_emoji_size', 'githuber_modules' ); ?> 
    <?php if ( '1.5em' !== $emoji_size ) : ?> 
  
    .post .emoji {
        width: <?php echo $emoji_size; ?>;
        height: <?php echo $emoji_size; ?>;
    }
  
    <?php endif; ?>
<?php endif; ?>
