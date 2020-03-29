<?php

namespace Slayer\Test\Block\Adminhtml\System\Config;

class ShowCMSBlockOnPLP extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Template path
     *
     * @var string
     */
    protected $_template = 'system/config/advance/check.phtml';

    /**
     * Render fieldset html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        //$columns = $this->getRequest()->getParam('website') || $this->getRequest()->getParam('store') ? 2 : 1;
        return $this->_decorateRowHtml($element, "<td class='label'>" . $element->getLabel() . "</td><td>" . $this->toHtml() . '</td><td></td>');
//        return $this->_toHtml();
        //$this->toHtml()
       /* return sprintf(
            '<tr class="system-fieldset-sub-head" id="row_%s"><td colspan="5"><h4 id="%s">%s</h4></td></tr>',
            $element->getHtmlId(),
            $element->getHtmlId(),
            $element->getLabel()
        );*/
    }
}