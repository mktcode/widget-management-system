<label>
    Fanpage-URL<br>
    <input type="url" class="uk-width-1-1" value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url" placeholder="http://..." required />
</label>
<label>
    Anzahl Galerien<br>
    <input type="number" class="uk-width-1-1" value="<?php echo $content ? $this->getData('galeries', $content->getId()) : ''; ?>" name="galeries" placeholder="" required />
</label>
<label>
    FB-App ID<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('appID', $content->getId()) : ''; ?>" name="appID" placeholder="" required />
</label>

<label>
    FB-App Secret<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('appSecret', $content->getId()) : ''; ?>" name="appSecret" placeholder="" required />
</label>

<small>Doku f&uuml;r die Galerie: <a href="http://sachinchoolur.github.io/lightGallery/docs/#installation">Doku</a></small><br /><br />