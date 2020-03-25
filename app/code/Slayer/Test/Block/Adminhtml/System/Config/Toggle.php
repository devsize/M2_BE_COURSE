<?php

namespace Slayer\Test\Block\Adminhtml\System\Config;

use Magento\Config\Block\System\Config\Form\Field;

class Toggle extends Field
{
    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'system/config/toggle/check.phtml';

    /**
     * Render element html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {

        return sprintf(
            '<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5"><h4 id="%s">%s</h4></td></tr>',
            $element->getHtmlId(),
            $element->getHtmlId(),
            $element->getLabel()
        );
    }
}