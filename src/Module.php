<?php

namespace Riddlestone\Brokkr\Foundation6;

class Module
{
    public function getConfig()
    {
        return require __DIR__ . '/../config/module.config.php';
    }
}
