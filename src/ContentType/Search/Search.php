<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 27.04.16
 * Time: 15:46
 */

namespace App\ContentType\Search;


use App\ContentType\ContentType;

class Search extends ContentType
{
    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Search';
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'search';
    }

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'uk-button-success';
    }

}