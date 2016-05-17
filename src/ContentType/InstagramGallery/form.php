<label>
    Username<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('username', $content->getId()) : ''; ?>" name="username" placeholder="Username" required />
</label>
<label>
    Password<br>
    <input type="password" class="uk-width-1-1" value="<?php echo $content ? $this->getData('password', $content->getId()) : ''; ?>" name="password" placeholder="Password" required />
</label>
<label>
    Mashape Key<br>
    <input type="text" class="uk-width-1-1" value="<?php echo $content ? $this->getData('mashapekey', $content->getId()) : ''; ?>" name="mashapekey" placeholder="Mashape Key" required />
</label>
