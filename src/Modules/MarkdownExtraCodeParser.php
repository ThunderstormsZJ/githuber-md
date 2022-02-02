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
	        $element = $Block['element'];
			$class = $element['text']['attributes']['class'];
	        $language = str_replace('language-', '', $class);

            // Change figure element
	        $tools = array(
				'name' => 'div',
				'handler' => 'line',
				'attributes' => array('class' => 'highlight-tools'),
	            'text' => "<div class='code-lang'>$language</div>
<div class='code-notice'>
<i class='fas fa-paste copy-button'></i><i class='fas fa-angle-down expand'></i>
</div>"
	        );

            $figureElement = array(
				'name'=>'figure',
	            'handler' => 'elements',
				'attributes' => array('class' => 'highlight'),
	            'text' => array(
		            $tools,
					$element
	            )
            );
			$Block['element'] = $figureElement;
        }

        return $Block;
    }
}