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
    public function render($contentId)
    {
        return 'Wysiwyg';
    }

    public function form($contentId = null)
    {
        include __DIR__ . '/form.php';
    }

    public function save($contentId, $data = [])
    {
        return true;
    }

    public function update($contentId)
    {
        return true;
    }

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