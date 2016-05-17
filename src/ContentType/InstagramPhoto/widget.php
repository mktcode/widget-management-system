<?php

/**
 * @var $contentId
 * @var Unirest\Response $response
 */

$url = $this->getData('url', $contentId) ?: '';

$request = 'http://api.instagram.com/oembed?callback=&url='.$url;

if ('' != $url) {
    $response = Unirest\Request::get($request);

    $html = json_decode($response->raw_body, true);
    if (isset($html['html'])) {
        echo $html['html'];
    } else {
        echo 'invalid media url provided';
    }
}

