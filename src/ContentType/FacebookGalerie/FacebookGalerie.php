<?php
/**
 * Created by PhpStorm.
 * User: Tim Strakerjahn
 * Date: 18.04.16
 * Time: 10:13
 */

namespace App\ContentType\FacebookGalerie;

use App\ContentType\ContentType;

class FacebookGalerie extends ContentType{
    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'facebook';
    }

    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Facebook Galerie';
    }

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'button-facebook';
    }
} 