<?php
/**
 * Created by PhpStorm.
 * User: Mirco Illmann
 * Date: 13.04.16
 * Time: 15:07
 */

namespace App\ContentType\FacebookEvents;


use App\ContentType\ContentType;

class FacebookEvents extends ContentType{
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
        return 'Facebook Events';
    }
} 