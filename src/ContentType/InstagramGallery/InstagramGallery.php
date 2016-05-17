<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 27.04.16
 * Time: 15:46
 */

namespace App\ContentType\InstagramGallery;


use App\ContentType\ContentType;

class InstagramGallery extends ContentType
{
    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Instagram Galerie';
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'instagram';
    }

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'button-instagram';
    }

}