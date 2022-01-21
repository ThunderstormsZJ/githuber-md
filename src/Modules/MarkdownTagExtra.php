<?php

/**
 * Module Name: MarkdownTagExtra
 * Module Description: Extend Markdown to parse custom Tag.
 */

namespace Githuber\Module;
use Markdown;
use ParsedownExtra;

class MarkdownTagExtra extends ParsedownExtra {
    const TagType_Note = 'note';
    const TagType_HideBlock = 'hideBlock';

    // Mode To Css Style
    protected $tagModeStyleMap = array(
        'flat'=>'flat',
        'simple'=>'flat',
        'modern'=>'modern',
        'no-icon'=>'no-icon flat',
    );

    public function __construct()
    {
        $this->BlockTypes['{'] = array('NoteTagMaker');
    }

    // begin with {% [tag] [style] %}
    protected function blockNoteTagMaker($Line, $Block)
    {
        // Not Include end tag as begin
        if (preg_match('/{%(\s*\b(?!end)[\s\S]*?)%}/', $Line['text'], $mathches)){

            $classContent = trim($mathches[1]);

            // Change Css Style
            $styleArray = explode(" ", $classContent);
            foreach ($styleArray as $index => $style) {
                if (isset($this->tagModeStyleMap[$style])){
                    $styleArray[$index] = $this->tagModeStyleMap[$style];
                }
            }

            $Element = array(
                'name' => 'div',
                'handler' => 'element',
                'attributes' => array('class'=>implode(" ", $styleArray)),
                'text' => array(
                    'name' => 'p',
                    'text' => '',
                ),
            );

            $Block = array(
                'char' => $Line['text'][0],
                'element' => $Element
            );

            return $Block;
        }
    }

    protected function blockNoteTagMakerContinue($Line, array $Block)
    {
        if (isset($Block['complete']))
        {
            return;
        }
        // A blank newline has occurred.
        if (isset($Block['interrupted']))
        {
            $Block['element']['text']['text'] .= "\n";
            unset($Block['interrupted']);
        }

        // Check for end of the block.
        if (preg_match('/{%(\s*(end.*)\s*?)%}/', $Line['text']))
        {
            $Block['element']['text']['text']  = substr($Block['element']['text']['text'] , 1);

            // This will flag the block as 'complete':
            // 1. The 'continue' function will not be called again.
            // 2. The 'complete' function will be called instead.
            $Block['complete'] = true;
            return $Block;
        }

        $Block['element']['text']['text']  .= "\n" . $Line['body'];

        return $Block;
    }

    // end with {% end[tag] %}
    protected function blockNoteTagMakerComplete($Block)
    {
        return $Block;
    }

    //region Note Tag Parse



    //endregion

    //region Hide Toggle Tag Parse

    //endregion
}