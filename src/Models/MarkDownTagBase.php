<?php

namespace Githuber\Model;

abstract class MarkDownTagBase
{
    protected $mTagName = '';

    public function __construct()
    {
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->mTagName;
    }

    /**
     * 开始解析 返回一个Element
     * @param $matchConfig string 标签后的内容
     * @return array
     */
    abstract public function parseBegin($matchConfig);

    /**
     * 继续解析内容
     * @param $element array 元素对象
     * @param $line string 解析行
     * @return array 返回element
     */
    abstract public function parseContinue($element, $line);

    /**
     * 结束解析
     * @param $element array 元素对象
     * @return array 返回element
     */
    abstract public function parseEnd($element);

    /**
     * 处理空行
     * @param $element array 元素对象
     * @return array 返回element
     */
    public function dealWithInterrupted($element)
    {

    }
}

