<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 09.03.16
 * Time: 17:49
 */

namespace App\ContentType\FacebookLikeBox;

use App\ContentType\ContentType;

class FacebookLikeBox extends ContentType
{
    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'button-facebook';
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'facebook';
    }

    public function getLabel()
    {
        return 'Facebook Like Box';
    }
}