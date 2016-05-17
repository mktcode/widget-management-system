<?php

/**
 * @var $contentId
 * @var Unirest\Response $response
 */

define('REQUEST_SCHEMA', 'https://www.googleapis.com/youtube/v3/videos?id=%s&part=statistics&key=%s');
define('GOOGLE_KEY', 'AIzaSyDfxo-sHTgmMoD2B_zvCBe_HZ4wijW3mKk');
define('YT_EMBED','<div class="responsive-video"><iframe class="youtube_video"  width="560" height="315"  src="https://www.youtube.com/embed/%s" frameborder="0" allowfullscreen></iframe></div>');


$url = $this->getData('url', $contentId) ?: '';
$apikey = $this->getData('apikey', $contentId) ?: '';
$withStats = $this->getData('withstats', $contentId) ?: 'off';

parse_str(parse_url($url, PHP_URL_QUERY), $query);

$extend = isset($query['list']) ? '?list=' . $query['list'] : '' ;

$id = parse_youtube($url);
if ($withStats == 'on') {

    if ($id != false) {

        $data = json_decode(file_get_contents(sprintf(REQUEST_SCHEMA, $id, $apikey)), true);

        $views = $data['items'][0]['statistics']['viewCount'];
        $likes = $data['items'][0]['statistics']['likeCount'];
        $dislikes = $data['items'][0]['statistics']['dislikeCount'];
        $favs = $data['items'][0]['statistics']['favoriteCount'];
        $commentCount = $data['items'][0]['statistics']['commentCount'];

        echo '<div class="youtube">

        '.sprintf(YT_EMBED, $id.$extend).'
<div class="youtube_stats">
<ul>
<li>
'.$views .' Views
</li>
<li>
'.$likes .' Likes
</li>
<li>
'.$dislikes .' Dislikes
</li>
<li>
'.$commentCount .' Kommentare
</li>

</ul>
</div>
</div>';

    } else {
        echo '<small>Invalid Youtube URL</small>';
    }

} else {
    if ($id != false) {
        echo sprintf(YT_EMBED, $id.$extend);
    } else {
        echo '<small>Invalid Youtube URL</small>';
    }
}

function parse_youtube($queryString)
{
    $queryString = urldecode($queryString);
    preg_match('/(?:youtube(?:-nocookie)?\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $queryString, $v);
    if (count($v) == 2) {
        return $v[1];
    }
    return false;
}
