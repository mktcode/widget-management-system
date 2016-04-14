<label>
    Fanpage-URL<br>
    <input type="url" class="uk-width-1-1" value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url" placeholder="http://..."/>
</label>
<label>
    Anzahl Events<br>
    <input type="number" class="uk-width-1-1" value="<?php echo $content ? $this->getData('events', $content->getId()) : ''; ?>" name="events" placeholder=""/>
</label>
<label>
    FB-App ID<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('appID', $content->getId()) : ''; ?>" name="appID" placeholder=""/>
</label>

<label>
    FB-App Secret<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('appSecret', $content->getId()) : ''; ?>" name="appSecret" placeholder=""/>
</label>