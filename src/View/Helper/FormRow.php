<?php

namespace Riddlestone\Brokkr\Foundation6\View\Helper;

use Laminas\Form\ElementInterface;
use Laminas\Form\Exception;
use Laminas\Form\LabelAwareInterface;
use Laminas\Form\View\Helper\FormRow as LaminasFormRow;

class FormRow extends LaminasFormRow
{
    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @param  null|string      $labelPosition
     * @throws Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element, $labelPosition = null)
    {
        if ($element->getMessages()) {
            if ($element instanceof LabelAwareInterface) {
                $labelAttributes = $element->getLabelAttributes() ?: [];
                $labelAttributes['class'] = implode(' ', array_merge(
                    explode(' ', $labelAttributes['class'] ?? ''),
                    ['is-invalid-label']
                ));
                $element->setLabelAttributes($labelAttributes);
            }
            $element->setAttribute('class', 'is-invalid-input');
        }
        return parent::render($element, $labelPosition);
    }
}
