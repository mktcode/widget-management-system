<?php

use App\ContentType\ContentType;

include 'header.php'; ?>

    <h1><?php echo $this->translate('content.new_content'); ?></h1>

    <div class="uk-grid" data-uk-grid-margin>
        <?php
        /** @var ContentType $contentType */
        foreach ($vars['contentTypes'] as $contentTypeId => $contentType) {
            ?>
            <div class="uk-width-medium-1-3">
            <a href="<?php echo $this->getUrl('content_form', ['contentTypeId' => $contentTypeId]); ?>"
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