<?php

namespace Riddlestone\Brokkr\Foundation6;

use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'console' => [
        'commands' => [
            Command\Foundation::class,
        ],
    ],
    'portal_manager' => [
        'provider_names' => [
            PortalConfigProvider::class,
        ],
        'factories' => [
            PortalConfigProvider::class => PortalConfigProviderFactory::class,
        ],
    ],
    'service_manager' => [
        'factories' => [
            Command\Foundation::class => Command\FoundationFactory::class,
            Service\FoundationConfig::class => Service\FoundationConfigFactory::class,
        ],
    ],
    'view_helpers' => [
        'aliases' => [
            'formbutton' => View\Helper\FormButton::class,
            'form_button' => View\Helper\FormButton::class,
            'formButton' => View\Helper\FormButton::class,
            'FormButton' => View\Helper\FormButton::class,
            'formelementerrors' => View\Helper\FormElementErrors::class,
            'form_element_errors' => View\Helper\FormElementErrors::class,
            'formElementErrors' => View\Helper\FormElementErrors::class,
            'FormElementErrors' => View\Helper\FormElementErrors::class,
            'formrow' => View\Helper\FormRow::class,
            'form_row' => View\Helper\FormRow::class,
            'formRow' => View\Helper\FormRow::class,
            'FormRow' => View\Helper\FormRow::class,
            'formsubmit' => View\Helper\FormSubmit::class,
            'form_submit' => View\Helper\FormSubmit::class,
            'formSubmit' => View\Helper\FormSubmit::class,
            'FormSubmit' => View\Helper\FormSubmit::class,
        ],
        'factories' => [
            View\Helper\FormButton::class => InvokableFactory::class,
            View\Helper\FormElementErrors::class => InvokableFactory::class,
            View\Helper\FormRow::class => InvokableFactory::class,
            View\Helper\FormSubmit::class => InvokableFactory::class,
        ],
    ],
    'foundation' => [
        'enabled' => false,
        'foundation_path' => 'vendor/zurb/foundation',
        'jquery_path' => 'vendor/components/jquery',
        'settings' => false,
        'extra_includes' => [],
        'modules' => [
            'grid_float' => false,
            'grid_flex' => false,
            'grid_xy' => false,
            'button' => false,
            'button_group' => false,
            'close_button' => false,
            'forms' => false,
            'label' => false,
            'progress_bar' => false,
            'slider' => false,
            'switch' => false,
            'table' => false,
            'badge' => false,
            'breadcrumbs' => false,
            'callout' => false,
            'card' => false,
            'dropdown' => false,
            'pagination' => false,
            'tooltip' => false,
            'accordion' => false,
            'media_object' => false,
            'orbit' => false,
            'responsive_embed' => false,
            'tabs' => false,
            'thumbnail' => false,
            'menu' => false,
            'menu_icon' => false,
            'accordion_menu' => false,
            'drilldown_menu' => false,
            'dropdown_menu' => false,
            'off_canvas' => false,
            'reveal' => false,
            'sticky' => false,
            'title_bar' => false,
            'top_bar' => false,
            'float_classes' => false,
            'flex_classes' => false,
            'visibility_classes' => false,
            'prototype_classes' => false,
            'abide' => false,
        ],
    ],
];
