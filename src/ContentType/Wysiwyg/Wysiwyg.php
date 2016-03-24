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
    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'uk-button-success';
    }

    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Text';
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'i-cursor';
    }
}