<label>
    Foto Url<br>
    <input type="url" class="uk-width-1-1" value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url" placeholder="http://..." required />
</label>
