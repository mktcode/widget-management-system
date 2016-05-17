<label>
    Benutzername<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('username', $content->getId()) : ''; ?>" name="username" placeholder="Username" required />
</label>
