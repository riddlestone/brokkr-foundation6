<?php

namespace Riddlestone\Brokkr\Foundation6\View\Helper;

use Laminas\Form\View\Helper\FormElementErrors as LaminasFormElementErrors;

class FormElementErrors extends LaminasFormElementErrors
{
    public function __construct()
    {
        $this->messageCloseString = '</li></ul>';
        $this->messageOpenFormat = '<ul%s><li class="form-error is-visible">';
        $this->messageSeparatorString = '</li><li class="form-error is-visible">';
        $this->attributes['class'] = 'no-bullet';
    }
}
