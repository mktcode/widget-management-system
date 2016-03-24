<?php

use App\ContentType\ContentTypeInterface;

include 'header.php'; ?>

    <h1>Neuer Inhalt</h1>

    <div class="uk-grid" data-uk-grid-margin>
        <?php
        /** @var ContentTypeInterface $contentType */
        foreach ($vars['contentTypes'] as $contentTypeId => $contentType) {
            ?>
            <div class="uk-width-medium-1-3">
            <a href="<?php echo $this->getUrl('content_new', ['contentTypeId' => $contentTypeId]); ?>"
               class="uk-button uk-button-large button-huge uk-width-1-1 <?php echo $contentType->getButtonClasses(
               ); ?>">
                <?php
                if ($contentType->getIcon()) {
                    ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"></i> <?php
                }
                echo $contentType->getLabel();
                ?>
            </a>
            </div><?php
        }
        ?>
    </div>

<?php include 'footer.php'; ?>