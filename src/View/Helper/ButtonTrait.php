<?php

namespace Riddlestone\Brokkr\Foundation6\View\Helper;

trait ButtonTrait
{
    /**
     * @inheritDoc
     */
    public function createAttributesString(array $attributes)
    {
        if (!array_key_exists('class', $attributes)) {
            $attributes['class'] = 'button';
        }
        return parent::createAttributesString($attributes);
    }
}
