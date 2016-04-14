<?php

require_once 'facebook-sdk/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => $this->getData('appID', $contentId),
    'app_secret' => $this->getData('appSecret', $contentId),
    'default_graph_version' => 'v2.5',
]);

$fb->setDefaultAccessToken($this->getData('appID', $contentId) . '|' . $this->getData('appSecret', $contentId));

try {

    $pageNameEx = explode('com/', $this->getData('url', $contentId));
    $pageName = explode('/', $pageNameEx[1]);

    $res = $fb->get('/' . $pageName[0] . '/events?fields=cover,attending_count,declined_count,end_time,description,maybe_count,name,place,start_time.order(chronological)&limit='.$this->getData('events', $contentId));

    $fbEvents = $res->getDecodedBody();

    $fbEventsData=array_reverse($fbEvents['data']);

    $html = '';
    //Alle Event Daten von Facebook
    if ($fbEventsData) {
        foreach ($fbEventsData as $event) {

            $html .= '<div class="fbEvent">';
            $html .= '<div class="fbEventImage"><img src="' . $event['cover']['source'] . '" /></div>';
            $html .= '<div class="fbEventContent">';
            $html .= '<div class="fbEventTitle">' . $event['name'] . '</div>';
            $html .= '<div class="fbEventDatum">' . date('d.m.Y', strtotime($event['start_time'])) . ' Uhr</div>';
            $html .= '<div class="fbEventZeit">' . date('H:i', strtotime($event['start_time'])) . '</div>';

            $html .= '<div class="fbEventDescription">' .nl2br($event['description']) . '</div>';

            $html .= '<div class="fbEventAttending">' .$event['attending_count'] . '</div>';
            $html .= '<div class="fbEventDeclined">' .$event['declined_count'] . '</div>';
            $html .= '<div class="fbEventMaybe">' .$event['maybe_count'] . '</div>';
            $html .= '</div>';
            $html .= '</div>';

        }
    }
    print $html;

} catch (Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
   // echo 'Graph returned an error: ' . $e->getMessage();
    exit;
}


?>