<?php

namespace Riddlestone\Brokkr\Foundation6\View\Helper;

use Laminas\Form\View\Helper\FormElementErrors as LaminasFormElementErrors;

class FormElementErrors extends LaminasFormElementErrors
{
    /**@+
     * @var string Templates for the open/close/separators for message tags
     */
    protected $messageCloseString     = '</li></ul>';
    protected $messageOpenFormat      = '<ul%s><li class="form-error is-visible">';
    protected $messageSeparatorString = '</li><li class="form-error is-visible">';
    /**@-*/

    /**
     * @var array Default attributes for the open format tag
     */
    protected $attributes = [
        'class' => 'no-bullet',
    ];
}
