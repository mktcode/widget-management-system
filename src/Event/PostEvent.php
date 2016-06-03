<?php
/**
 * Created by PhpStorm.
 * User: mkt
 * Date: 03.06.16
 * Time: 09:17
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\Event;

class PostEvent extends Event
{
    const NAME = 'request.post';

    private $postData;

    public function __construct($postData) {

        $this->postData = $postData;
    }

    /**
     * @return mixed
     */
    public function getPostData()
    {
        return $this->postData;
    }
}