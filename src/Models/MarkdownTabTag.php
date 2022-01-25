<?php
namespace Githuber\Model;

/**
 * {% hideToggle [title,model[show,hide]] %}
 * content
 * {% endhideToggle %}
 */
class MarkdownTabTag extends MarkdownTagBase{
    protected $mTagName = 'tabs';

    public function parseBegin($matchConfig)
    {
        // TODO: Implement parseBegin() method.
    }

    public function parseContinue($element, $line)
    {
        // TODO: Implement parseContinue() method.
    }

    public function parseEnd($element)
    {
        // TODO: Implement parseEnd() method.
    }
}