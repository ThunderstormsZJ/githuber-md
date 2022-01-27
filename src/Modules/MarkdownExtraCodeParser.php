<?php

/**
 * Code 解析扩展
 */
namespace Githuber\Module;

trait MarkdownExtraCodeParser {
    protected function blockFencedCode($Line){
        $Block = parent::blockFencedCode($Line);
        $prism_line_number = githuber_get_option( 'prism_line_number', 'githuber_modules' );
        if ($prism_line_number == 'yes' and !is_null($Block)){
            $Block['element']['attributes'] = array('class'=>'line-numbers');
            return $Block;
        }
    }

    protected function blockFencedCodeComplete($Block){
        $Block = parent::blockFencedCodeComplete($Block);

        if (!is_null($Block)){
            // --TODO Change figure element
//            $element = $Block['element'];
//            $figureElement = array(
//
//            );
        }

        return $Block;
    }
}