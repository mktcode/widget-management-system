<label>
    Video Url<br>
    <input type="url" class="uk-width-1-1" value="<?php echo $content ? $this->getData('url', $content->getId()) : ''; ?>" name="url" placeholder="http://..." required />
</label>
<br />
<br />
<label>
    Modal<br>
    <input type="radio" <?php echo $this->getData('modal', $content->getId())==1 ? 'checked="checked"' : ''; ?> value="1" name="modal" /> Ja<br />
    <input type="radio" <?php echo $this->getData('modal', $content->getId())==2 or $this->getData('modal', $content->getId())!=1 ? 'checked="checked"' : ''; ?> value="2" name="modal" /> Nein
</label>
<br />
<br />
<label>
    Sichtbar<br>
    <input type="text" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo $content ? $this->getData('von', $content->getId()) : ''; ?>" name="von"  placeholder="von"/>
    -
    <input type="text" data-uk-datepicker="{format:'YYYY-MM-DD'}" value="<?php echo $content ? $this->getData('bis', $content->getId()) : ''; ?>" name="bis"  placeholder="bis"/>
</label>
<br /><br />
