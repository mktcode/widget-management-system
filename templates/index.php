<?php

use App\ContentType\ContentType;
use App\Entity\Content;
use App\Entity\ContentCategory;

include 'header.php';

?><h1><?php echo $this->translate('content.contents'); ?></h1><?php

if ($this->isAdmin()) {
    ?>
    <div class="uk-text-center <?php if (!count($vars['contents']) && !count($vars['categories'])) {
        echo ' uk-margin-large-top';
    } ?>">
        <a href="<?php echo $this->getUrl('content_types'); ?>"
           class="uk-button uk-button-success uk-button-large button-huge<?php echo !count(
               $vars['contents']
           ) && !$vars['category'] && !$vars['categories'] ? ' button-enormous' : ''; ?> uk-width-1-1">
            <i class="uk-icon-plus"></i>
            <?php echo $this->translate('content.new_content'); ?>
        </a>
    </div>
    <div class="uk-text-center">
        <a href="<?php echo $this->getUrl('content_category_form'); ?>"
           class="uk-button uk-button-success uk-button-large<?php echo !count(
               $vars['contents']
           ) && !$vars['category'] && !$vars['categories'] ? ' button-huge' : ''; ?> uk-margin-top uk-width-1-1">
            <i class="uk-icon-plus"></i>
            <?php echo $this->translate('content.new_category'); ?>
        </a>
    </div>
<?php
}

if (count($vars['categories']) || $vars['category']) {
    ?>
    <hr class="uk-margin-top"><?php
}

if ($vars['category']) {
    $parentUrl = $vars['category']->getParent()
        ? $this->getUrl('content_category', ['categoryId' => $vars['category']->getParent()->getId()])
        : $this->getUrl('index');
    ?><h2 class="uk-margin-top-remove">
    <a href="<?php echo $parentUrl; ?>" class="uk-button">
        <i class="uk-icon-angle-double-left"></i>
    </a>
    <?php echo $this->getService('helper')->getCategoryPath($vars['category']); ?>
    <?php
    if ($this->isAdmin()) {
        ?><a href="<?php echo $this->getUrl('content_category_form', ['categoryId' => $vars['category']->getId()]); ?>"
             class="uk-button uk-button-success"
             data-uk-tooltip title="<?php echo $this->translate('content.edit_category'); ?>">
            <i class="uk-icon-edit"></i>
        </a>
        <a href="#delete-category-modal"
           class="uk-button uk-button-danger"
           data-uk-tooltip title="<?php echo $this->translate('content.delete_category'); ?>"
           data-uk-modal>
            <i class="uk-icon-trash"></i>
        </a><?php
    }
    ?>
    </h2>
<?php
}

if (count($vars['categories'])) {
    /** @var ContentCategory $cat */
    foreach ($vars['categories'] as $cat) {
        ?><a href="<?php echo $this->getUrl('content_category', ['categoryId' => $cat->getId()]); ?>"
             class="uk-button uk-button-large uk-margin-small-top uk-margin-small-bottom">
        <i class="uk-icon-folder"></i>
        <?php echo $cat->getName(); ?>
        <span class="uk-badge uk-badge-success">
            <?php echo $this->getService('helper')->getRecursiveCategoryContentCount($cat); ?>
        </span>
        </a> <?php
    }
    ?>
    <hr class="uk-margin-top"><?php
}

if (count($vars['contents'])) {
    ?>
    <table class="uk-table uk-table-striped uk-table-hover">
        <tr class="uk-hidden-small">
            <th width="15"></th>
            <th>
                <?php echo $this->translate('content.table.columns.title'); ?>
                <i class="uk-icon-question-circle" data-uk-tooltip
                   title="<?php echo $this->translate('content.table.columns.title.text'); ?>"></i>
            </th>
            <?php
            if ($this->isAdmin()) {
                ?>
                <th>
                <?php echo $this->translate('content.table.columns.snippet'); ?>
                <i class="uk-icon-question-circle" data-uk-tooltip
                   title="<?php echo $this->translate('content.table.columns.snippet.text'); ?>"></i>
                </th><?php
            }
            ?>
            <th></th>
        </tr>
        <?php
        /** @var Content $content */
        foreach ($vars['contents'] as $content) {
            /** @var ContentType $contentType */
            $contentType = $this->services->get($content->getType());
            ?>
            <tr>
            <td>
                <?php
                if ($contentType->getIcon()) {
                    ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"
                    data-uk-tooltip title="<?php echo $contentType->getLabel(); ?>"></i><?php
                }
                ?>
            </td>
            <td>
                <?php echo $content->getTitle(); ?>
                <input class="snippet-input uk-visible-small" onclick="this.select();"
                       value="&lt;!--<?php echo $content->getHash(); ?>--&gt;"/>
            </td>
            <?php
            if ($this->isAdmin()) {
                ?>
                <td class="uk-hidden-small">
                <input class="snippet-input" onclick="this.select();"
                       value="&lt;!--<?php echo $content->getHash(); ?>--&gt;"/>
                </td><?php
            }
            ?>
            <td class="uk-text-right" width="120">
                <a href="<?php echo $this->getUrl('content_toggle_active', ['contentId' => $content->getId()]); ?>"
                   class="uk-button toggle-active"
                   data-uk-tooltip title="<?php echo $this->translate('content.table.buttons.toggle'); ?>">
                    <i class="<?php echo $content->isActive() ? 'uk-icon-check-circle-o' : 'uk-icon-circle-o'; ?>"></i>
                </a>
                <a href="<?php echo $this->getUrl(
                    'content_form',
                    ['contentTypeId' => $content->getType(), 'contentId' => $content->getId()]
                ); ?>"
                   class="uk-button uk-button-success"
                   data-uk-tooltip title="<?php echo $this->translate('content.table.buttons.edit'); ?>">
                    <i class="uk-icon-edit"></i>
                </a>
                <?php
                if ($this->isAdmin()) {
                    ?><a href="<?php echo $this->getUrl('content_delete', ['contentId' => $content->getId()]); ?>"
                         class="open-delete-modal uk-button uk-button-danger"
                         data-uk-tooltip title="<?php echo $this->translate('content.table.buttons.delete'); ?>">
                        <i class="uk-icon-trash"></i>
                    </a><?php
                }
                ?>
            </td>
            </tr><?php
        }
        ?>
    </table>

    <div id="delete-modal" class="uk-modal">
        <div class="uk-modal-dialog">
            <a class="uk-modal-close uk-close"></a>

            <div class="uk-modal-header">
                <h2><i class="uk-icon-trash-o"></i> <?php echo $this->translate('content.delete.title'); ?></h2>
            </div>
            <?php echo $this->translate('content.delete.text'); ?>
            <div class="uk-modal-footer">
                <a href="#" class="uk-button uk-button-danger uk-modal-close">
                    <i class="uk-icon-times"></i>
                    <?php echo $this->translate('content.delete.cancel'); ?>
                </a>
                <a href="#" class="uk-button uk-button-success uk-float-right">
                    <i class="uk-icon-check"></i>
                    <?php echo $this->translate('content.delete.confirm'); ?>
                </a>
            </div>
        </div>
    </div><?php
}

if ($vars['category']) {
    ?>
    <div id="delete-category-modal" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>

        <div class="uk-modal-header">
            <h2><i class="uk-icon-trash-o"></i> <?php echo $this->translate('content.delete.title'); ?></h2>
        </div>
        <?php echo $this->translate('content.category.delete.text1'); ?>
        <?php
        $contentsCount = $this->getService('helper')->getRecursiveCategoryContentCount($vars['category']);
        if ($contentsCount) {
            echo '<br><br>' . $this->translate('content.category.delete.text2', ['%contents_count%' => $contentsCount]);
        }
        ?>
        <br><br><b class="uk-text-danger"><?php echo $this->translate('content.category.delete.text3'); ?></b>

        <div class="uk-modal-footer">
            <a href="#" class="uk-button uk-button-danger uk-modal-close">
                <i class="uk-icon-times"></i>
                <?php echo $this->translate('content.delete.cancel'); ?>
            </a>
            <a href="<?php echo $this->getUrl(
                'content_category_delete',
                ['categoryId' => $vars['category']->getId()]
            ); ?>" class="uk-button uk-button-success uk-float-right">
                <i class="uk-icon-check"></i>
                <?php echo $this->translate('content.delete.confirm'); ?>
            </a>
        </div>
    </div>
    </div><?php
}
?>

    <script>
        $(function () {
            var modal = UIkit.modal("#delete-modal"),
                successButton = modal.find('.uk-button-success');

            $('.open-delete-modal').click(function (e) {
                e.preventDefault();

                successButton.attr('href', this.href);
                modal.show();
            });

            $('.toggle-active').click(function (e) {
                e.preventDefault();
                $.get($(this).attr('href'));
                $(this).find('i').toggleClass('uk-icon-circle-o uk-icon-check-circle-o');
            });
        });
    </script>

<?php include 'footer.php'; ?>