<?php

namespace Slayer\Test\Block\Adminhtml\System\Config;

class Toggle extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'system/config/toggle/check.phtml';

    /**
     * Render fieldset html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        return $this->_decorateRowHtml($element, "<td class='label'>" . $element->getLabel() . "</td><td>" . $this->toHtml() . '</td><td></td>');
    }
}