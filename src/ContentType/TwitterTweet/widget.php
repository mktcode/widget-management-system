<?php

/**
 * @var $contentId
 * @var Unirest\Response $response
 */

$url = $this->getData('url', $contentId) ?: '';

$type = $this->getData('withvideo', $contentId) == 'on' ? '&widget_type=video' : '';

$request = 'https://api.twitter.com/1/statuses/oembed.json?url='.$url . $type;

if ('' != $url) {
    $response = Unirest\Request::get($request);

    $html = json_decode($response->raw_body, true);
    if (isset($html['html'])) {
        echo $html['html'];
    } else {
        echo 'invalid tweet url provided';
    }
}
https://www.youtube.com/watch?v=DM52HxaLK-Y&list=PL92E528A5E6F59D16