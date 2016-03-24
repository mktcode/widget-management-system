<?php
use App\ContentType\ContentTypeInterface;

include 'header.php';

/** @var ContentTypeInterface $contentType */
$contentType = $vars['contentType'];
?>
    <h1>
        <?php
        if ($contentType->getIcon()) {
            ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"></i> <?php
        }
        echo $contentType->getLabel();
        ?>
    </h1>

    <form action="" method="post" class="uk-form">
        <label class="uk-margin-bottom uk-display-block">
            Titel
            <br>
            <input type="text" name="title" class="uk-form-large uk-width-1-1" required />
        </label>

        <?php $contentType->form(); ?>

        <button type="submit" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-check"></i>
            Speichern
        </button>
    </form>

<?php include 'footer.php'; ?>