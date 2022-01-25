<?php

namespace Githuber\Model;

/**
 * {% hideToggle [title,model[show,hide]] %}
 * content
 * {% endhideToggle %}
 */
class MarkdownToggleTag extends MarkdownTagBase{
    protected $mTagName = 'hideToggle';

    public function parseBegin($matchConfig)
    {
        $toggleConfig = trim(str_replace($this->mTagName, '', $matchConfig));
        $toggleStyle = 'hide-button toggle-title';
        $toggleTitle = '';
        if (!empty($toggleConfig)){
            $toggleConfigArray = explode(",", $toggleConfig);
            $toggleTitle = trim($toggleConfigArray[0]);
            $toggleIsShow = strcasecmp($toggleConfigArray[1], 'show');

            if ($toggleIsShow == 0){
                $toggleStyle .= ' open';
            }
        }

        return array(
            'name' => 'div',
            'handler' => 'elements',
            'attributes' => array('class' => 'hide-toggle'),
            'text' => array(
                // Title
                array(
                    'name'=>'div',
                    'handler' => 'elements',
                    'attributes' => array('class' => $toggleStyle),
                    'text' => array(
                        array(
                            'name'=>'i',
                            'attributes' => array('class' => 'fas fa-caret-right fa-fw'),
                            'text'=>''
                        ),
                        array(
                            'name'=>'span',
                            'text'=>$toggleTitle
                        ),
                    )
                ),
                // Content
                array(
                    'name'=>'div',
                    'attributes' => array('class' => 'hide-content'),
                    'handler' => 'lines',
                    'text' => array()
                ),
            ),
        );
    }

    public function parseContinue($element, $line)
    {
        array_push($element['text'][1]['text'], $line['body']);

        return $element;
    }

    public function parseEnd($element)
    {
        return $element;
    }

    public function dealWithInterrupted($element)
    {
        array_push($element['text'][1]['text'], "\n");
        return $element;
    }
}
