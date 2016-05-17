<?php
/**
 * Created by PhpStorm.
 * User: nico
 * Date: 27.04.16
 * Time: 15:46
 */

namespace App\ContentType\TwitterTweet;


use App\ContentType\ContentType;

class TwitterTweet extends ContentType
{
    /**
     * Returns the label for the button.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'Twitter Tweet';
    }

    /**
     * Returns the icon class for the button.
     *
     * @return string
     */
    public function getIcon()
    {
        return 'twitter';
    }

    /**
     * Returns possible css classes for the button.
     *
     * @return string
     */
    public function getButtonClasses()
    {
        return 'button-twitter';
    }



}