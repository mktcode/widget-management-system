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
     * Renders the final output of the content type.
     *
     * @param $contentId
     * @return string
     */
    public function render($contentId)
    {
        ob_start();
        include __DIR__ . '/widget.php';

        return ob_get_clean();
    }

    /**
     * Renders the form for backend editing.
     *
     * @param null $contentId
     * @return string
     */
    public function form($contentId = null)
    {
        include __DIR__ . '/form.php';
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