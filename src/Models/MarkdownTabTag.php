<?php
namespace Githuber\Model;

/**
 * {% tabs [Unique Name], [Select Index] %}
 * <!-- tabs [Tab caption] [@icon] -->
 * content
 * <!-- endtabs -->
 * {% endtabs %}
 */
class MarkdownTabTag extends MarkdownTagBase{
    protected $mTagName = 'tabs';
    private $tabDataList = array(); // 保存每个Tab的内容数据
    private $curTabData = array(); // 当前的Tab内容数据

    public function parseBegin($matchConfig)
    {
        $tabConfig = $this->getTagConfigStr($matchConfig);
        $tabUniqueName = '';
        $tabSelectIndex = 0;
        if (!empty($tabConfig)){
            $tabConfigArray = explode(",", $tabConfig);
            $tabUniqueName = trim($tabConfigArray[0]);
            $tabSelectIndex = trim($tabConfigArray[1]);
        }

        return array(
            'name' => 'div',
            'handler' => 'elements',
            'attributes' => array('class' => 'tabs', 'id' => $tabUniqueName),
            'text' => array(
                // nav-tabs
                array(
                    'name' => 'ul',
                    'handler' => 'elements',
                    'attributes' => array('class' => 'nav-tabs'),
                    'text' => array()
                ),
                array(
                    'name' => 'div',
                    'handler' => 'elements',
                    'attributes' => array('class' => 'tab-contents'),
                    'text' => array()
                )
            )
        );
    }

    public function parseContinue($element, $line)
    {
        // Begin <!-- tab name, -->
        if (!isset($this->curTabData['isBegin']) and preg_match('/<!--[\s]*([\s\S]*)-->/', $line['body'], $matches)){
            $id = $element['attributes']['id'];
            $curIndex = sizeof($this->tabDataList) + 1;

            $tabId = $id . '-' . $curIndex;
            $tabConfigStr = trim(str_replace('tab', '', $matches));
            $tabConfig = explode("@", $tabConfigStr);
            $tabName = array_key_exists(0, $tabConfig) ? $tabConfig[0] : '';
            $tabIcon = array_key_exists(1, $tabConfig) ? $tabConfig[1] : '';

            $this->curTabData = array(
                'isBegin' => true,
                'id' => $tabId,
                'name' => $tabName,
                'icon' => $tabIcon,
                'content' => array()
            );
        } elseif (isset($this->curTabData['isBegin'])){
            if ($this->curTabData['isBegin'] and preg_match('/<!--[\s]*endtab[\s]*-->/', $line['body'])){
                // End <!-- endtabs -->
                array_push($this->tabDataList, $this->curTabData);
                $this->curTabData = array();
            }else{
                // Content
                array_push($this->curTabData['content'], $line['body']);
            }
        }

        return $element;
    }

    public function parseEnd($element)
    {
        foreach ($this->tabDataList as $tabData){
            array_push($element['text'][0]['text'], $this->createTableTab($tabData));
            array_push($element['text'][1]['text'], $this->createTableContent($tabData));
        }
        $this->tabDataList = array();

        return $element;
    }

    /**
     * @param $tabData string 单个tab的配置数据
     */
    private function createTableTab($tabData)
    {
        $liEelement = array(
            'name' => 'li',
            'handler' => 'element',
            'attributes' => array('class' => 'tab'),
            'text' => array(
                'name' => 'button',
                'attributes' => array('type' => 'button', 'data-href' => '#' . $tabData['id']),
                'handler' => 'elements',
                'text' => array()
            )
        );

        if (!empty($tabData['icon'])){
            // support icon
            array_push($liEelement['text']['text'], array(
                'name' => 'i',
                'attributes' => array('class' => $tabData['icon']),
                'text' => ''
            ));
        }

        if (!empty($tabData['name'])){
            array_push($liEelement['text']['text'], array(
                'text' => $tabData['name']
            ));
        }

        if (empty($tabData['icon']) and empty($tabData['name'])){
            unset($liEelement['text']['handler']);
            $liEelement['text']['text'] = $tabData['id'];
        }

        return $liEelement;
    }

    /**
     * @param $tabData string 单个tab的配置数据
     */
    private function createTableContent($tabData)
    {
        $contentEelment = array(
            'name' => 'div',
            'attributes' => array('class' => 'tab-item-content', 'id' => $tabData['id']),
            'handler' => 'lines',
            'text' => $tabData['content']
        );

        return $contentEelment;
    }
}