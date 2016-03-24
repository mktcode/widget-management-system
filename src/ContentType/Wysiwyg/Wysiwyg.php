<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 09.03.16
 * Time: 17:49
 */

namespace App\ContentType\Wysiwyg;

use App\ContentType\ContentType;

class Wysiwyg extends ContentType
{
    public function getButtonClasses()
    {
        return 'uk-button-success';
    }

    public function getLabel()
    {
        return 'Text';
    }

    public function getIcon()
    {
        return 'i-cursor';
    }
}