<?php
use App\ContentType\ContentType;
use App\Entity\Content;

include 'header.php';

/** @var ContentType $contentType */
$contentType = $vars['contentType'];
/** @var Content $content */
$content = $vars['content'];
?>
    <h1>
        <?php
        if ($contentType->getIcon()) {
            ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"></i> <?php
        }
        echo $contentType->getLabel();
        ?>
    </h1>

    <?php
    if ($vars['message']) {
        ?><div class="uk-alert" data-uk-alert>
            <a href="" class="uk-alert-close uk-close"></a>
            <p><?php echo $vars['message']; ?></p>
        </div><?php
    }
    ?>

    <form action="" method="post" class="uk-form">
        <label class="uk-margin-bottom uk-display-block">
            Titel
            <br>
            <input type="text" name="title" class="uk-form-large uk-width-1-1" value="<?php if ($content) { echo $content->getTitle(); } ?>" required />
        </label>

        <?php $contentType->form(); ?>

        <button type="submit" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-check"></i>
            Speichern
        </button>
    </form>

<?php include 'footer.php'; ?>