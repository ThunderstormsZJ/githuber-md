<?php

namespace Githuber\Model;

abstract class MarkdownTagBase
{
    protected $mTagName = '';

    public function __construct()
    {
    }

    /**
     * 获取配置内容
     * @param $matchConfig string
     * @return string
     */
    protected function getTagConfigStr($matchConfig)
    {
        return trim(str_replace($this->mTagName, '', $matchConfig));
    }

    /**
     * @return string
     */
    public function getTagName()
    {
        return $this->mTagName;
    }

    /**
     * 开始解析 返回一个基础Element
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
        return $element;
    }
}

