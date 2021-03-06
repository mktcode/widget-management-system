<?php
use App\ContentType\ContentType;
use App\Entity\Content;
use App\Entity\ContentCategory;

include 'header.php';

/** @var ContentType $contentType */
$contentType = $vars['contentType'];
/** @var Content $content */
$content = $vars['content'];
$categories = $vars['categories'];
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
            <input type="text" name="title" class="uk-form-large uk-width-1-1"
                   style="font-size: 24px; line-height: 26px;"
                   placeholder="Titel eingeben..."
                   value="<?php if ($content) {
                       echo $content->getTitle();
                   } ?>" required/>
        </label>

        <?php
        if ($categories) {
            ?><label class="uk-margin-bottom uk-display-block">
            <select name="category" class="uk-form-large uk-width-1-1">
                <option value=""><?php echo $this->translate('content.choose_category'); ?></option>
                <?php
                /** @var ContentCategory $cat */
                foreach ($categories as $cat) {
                    $currentContentCategorySelected = $content && $content->getContentCategory() && $cat->getId() == $content->getContentCategory()->getId();
                    $newContentCategorySelected = !$content && $cat->getId() == (int) $_GET['categoryId'];
                    if ($currentContentCategorySelected || $newContentCategorySelected) {
                        $selected = ' selected="selected"';
                    }
                    ?>
                    <option value="<?php echo $cat->getId(); ?>"<?php echo $selected; ?>><?php echo $cat->getName(); ?></option><?php
                }
                ?>
            </select>
            </label><?php
        }
        ?>

        <?php echo $contentType->form($content ? $content->getId() : null); ?>

        <button type="submit" name="action" value="save" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-check"></i>
            <?php echo $this->translate('save'); ?>
        </button>

        <button type="submit" name="action" value="save_and_new" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-plus"></i>
            <?php echo $this->translate('save_and_new'); ?>
        </button>

        <button type="submit" name="action" value="save_and_close" class="uk-button uk-button-success uk-margin-top uk-margin-top">
            <i class="uk-icon-times"></i>
            <?php echo $this->translate('save_and_close'); ?>
        </button>

        <a href="<?php echo (int) isset($_GET['categoryId']) ? $this->getUrl('content_category', ['categoryId' => (int) $_GET['categoryId']]) : $this->getUrl('index'); ?>" class="uk-button uk-button-danger uk-margin-top uk-margin-top">
            <i class="uk-icon-times"></i>
            <?php echo $this->translate('close'); ?>
        </a>
    </form>

<?php include 'footer.php'; ?>