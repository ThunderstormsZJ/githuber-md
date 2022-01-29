<?php

/**
 * Module Name: MarkdownTagExtraParser
 * Module Description: Extend Markdown to parse custom Tag.
 */

namespace Githuber\Module;
use ParsedownExtra;
use Githuber\Model as Model;

class MarkdownTagExtraParser extends ParsedownExtra {
    /**
     * @var Model\MarkdownTagBase[]
     */
    private $tagModelList = array();

    public function __construct()
    {
        $this->BlockTypes['{'] = array('NoteTagMaker');

        $this->tagModelList[] = new Model\MarkdownNoteTag();
        $this->tagModelList[] = new Model\MarkdownToggleTag();
        $this->tagModelList[] = new Model\MarkdownTabTag();
    }

    function text($text)
    {
        $markup = parent::text($text);

        // 替换掉部分\n 防止自动添加<br>
        $markup = preg_replace('/<\/i>\s+<span>/', '</i><span>', $markup);

        return $markup;
    }

    /**
     * @param $tagName string
     * @return Model\MarkdownTagBase
     */
    private function getTagModel($tagName){
        foreach ($this->tagModelList as $tagModel){
            if ($tagModel->getTagName() == $tagName){
                return $tagModel;
            }
        }

        return null;
    }

    // begin with {% [tag] [style] %}
    protected function blockNoteTagMaker($Line)
    {
        // Not Include end tag as begin
        if (preg_match('/{%(\s*\b(?!end)[\s\S]*?)%}/', $Line['text'], $matches)){

            $matchConfig = trim($matches[1]);
            $contentList= explode(" ", $matchConfig);
            $tagName = $contentList[0];
            if (empty($tagName)){
                return null;
            }

            $tagModel = $this->getTagModel($tagName);
            if (is_null($tagModel)){
                return null;
            }

            $element = $tagModel->parseBegin($matchConfig);

            return array(
                'tagName'=> $tagName,
                'char' => $Line['text'][0],
                'element' => $element
            );;
        }
    }

    protected function blockNoteTagMakerContinue($Line, array $Block)
    {
        if (isset($Block['complete']))
        {
            return;
        }

        $tagModel = $this->getTagModel($Block['tagName']);
        $element = $Block['element'];

        // A blank newline has occurred.
        if (isset($Block['interrupted']))
        {
            $element = $tagModel->dealWithInterrupted($element);
            unset($Block['interrupted']);
        }

        // Check for end of the block.
        if (preg_match('/{%(\s*(end.*)\s*?)%}/', $Line['text']))
        {
            $Block['complete'] = true;
            return $Block;
        }

        $element = $tagModel->parseContinue($element, $Line);

        $Block['element'] = $element;
        return $Block;
    }

    // end with {% end[tag] %}
    protected function blockNoteTagMakerComplete($Block)
    {
        $tagModel = $this->getTagModel($Block['tagName']);
        $element = $Block['element'];
        $element = $tagModel->parseEnd($element);
        $Block['element'] = $element;
        return $Block;
    }
}