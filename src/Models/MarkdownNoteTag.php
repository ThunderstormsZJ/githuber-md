<?php

namespace Githuber\Model;

/**
 * {% note [style] [model] %}
 * content
 * {% endnote %}
 */
class MarkdownNoteTag extends MarkDownTagBase
{
    protected $mTagName = 'note';
    // Mode To Css Style
    private $tagModeStyleMap = array(
        'flat' => 'flat',
        'simple' => 'flat',
        'modern' => 'modern',
        'no-icon' => 'no-icon flat',
    );

    public function parseBegin($matchConfig)
    {
        // Change Css Style
        $styleArray = explode(" ", $matchConfig);
        foreach ($styleArray as $index => $style) {
            if (isset($this->tagModeStyleMap[$style])) {
                $styleArray[$index] = $this->tagModeStyleMap[$style];
            }
        }

        return array(
            'name' => 'div',
            'handler' => 'element',
            'attributes' => array('class' => implode(" ", $styleArray)),
            'text' => array(
                'name' => 'p',
                'handler' => 'line',
                'text' => ''
            ),
        );
    }

    public function dealWithInterrupted($element)
    {
        $element['text']['text'] .= "\n";
        return $element;
    }

    public function parseContinue($element, $line)
    {
        $element['text']['text']  .= "\n" . $line['body'];
        return $element;
    }

    public function parseEnd($element)
    {
        $element['text']['text']  = substr($element['text']['text'] , 1);
        return $element;
    }
}