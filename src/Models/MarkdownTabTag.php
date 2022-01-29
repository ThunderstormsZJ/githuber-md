<?php
namespace Githuber\Model;

/**
 * {% tabs [Unique Name], [Select Index] %}
 * <!-- tab [Tab caption] [@icon] -->
 * content
 * <!-- endtab -->
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
        $tabSelectIndex = 1;
        if (!empty($tabConfig)){
            $tabConfigArray = explode(",", $tabConfig);
            $tabUniqueName = trim($tabConfigArray[0]);
			if (!empty($tabConfigArray[1])){
	            $tabSelectIndex = (int)trim($tabConfigArray[1]);
			}
        }

        return array(
            'name' => 'div',
            'handler' => 'elements',
			'selectIndex' => $tabSelectIndex,
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
			$selectIndex = $element['selectIndex'];
            $curIndex = sizeof($this->tabDataList) + 1;

            $tabId = $id . '-' . $curIndex;
            $tabConfigStr = trim(str_replace('tab', '', $matches[1]));
            $tabConfig = explode("@", $tabConfigStr);
            $tabName = array_key_exists(0, $tabConfig) ? $tabConfig[0] : '';
            $tabIcon = array_key_exists(1, $tabConfig) ? $tabConfig[1] : '';

            $this->curTabData = array(
                'isBegin' => true,
                'id' => $tabId,
                'name' => $tabName,
                'icon' => $tabIcon,
				'isSelect' => $selectIndex == $curIndex,
                'content' => array()
            );
        } elseif (isset($this->curTabData['isBegin'])){
            if ($this->curTabData['isBegin'] and preg_match('/<!--[\s]*endtab[\s]*-->/', $line['body'])){
                // End <!-- endtab -->
                $this->tabDataList[] = $this->curTabData;
                $this->curTabData    = array();
            }else{
                // Content
                $this->curTabData['content'][] = $line['body'];
            }
        }

        return $element;
    }

    public function parseEnd($element)
    {
        foreach ($this->tabDataList as $tabData){
            $element['text'][0]['text'][] = $this->createTableTab( $tabData );
            $element['text'][1]['text'][] = $this->createTableContent( $tabData );
        }
        $this->tabDataList = array();

        return $element;
    }

    /**
     * @param $tabData string 单个tab的配置数据
     */
    private function createTableTab($tabData)
    {
		$isSelect = $tabData['isSelect'];

        $liEelement = array(
            'name' => 'li',
            'handler' => 'element',
            'attributes' => array('class' => 'tab' . ($isSelect?' active':'')),
            'text' => array(
                'name' => 'button',
                'attributes' => array('type' => 'button', 'data-href' => '#' . $tabData['id']),
                'handler' => 'line',
                'text' => array()
            )
        );

	    $icon = $tabData['icon'];
		$titleName = $tabData['name'];

		if (!empty($titleName) and !empty($icon)){// show txt + icon (text and icon)
			$liEelement['text']['text'] = "<i class='$icon'></i>$titleName";
		}elseif (empty($titleName) and !empty($icon)){// only show icon (no text and icon)
			$liEelement['text']['text'] = "<i class='$icon'></i>";
		}else{// only show txt (text/no text and no icon)
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
	    $isSelect = $tabData['isSelect'];

        $contentEelment = array(
            'name' => 'div',
            'attributes' => array('class' => 'tab-item-content' . ($isSelect?' active':''), 'id' => $tabData['id']),
            'handler' => 'lines',
            'text' => $tabData['content']
        );

        return $contentEelment;
    }
}