<?php

use App\ContentType\ContentType;
use App\Entity\Content;
use App\Entity\ContentCategory;

include 'header.php';

if ($this->isAdmin()) {
    ?>
    <div class="uk-text-center <?php if (!count($vars['contents'])) {
        echo ' uk-margin-large-top';
    } ?>">
        <a href="<?php echo $this->getUrl('content_types'); ?>"
           class="uk-button uk-button-success uk-button-large button-huge<?php echo !count(
               $vars['contents']
           ) && !$vars['category'] && !$vars['categories'] ? ' button-enormous' : ''; ?> uk-width-1-1">
            <i class="uk-icon-plus"></i>
            Neuer Inhalt
        </a>
    </div>
    <div class="uk-text-center">
        <a href="<?php echo $this->getUrl('content_category_form'); ?>"
           class="uk-button uk-button-success uk-button-large<?php echo !count(
               $vars['contents']
           ) && !$vars['category'] && !$vars['categories'] ? ' button-enormous' : ''; ?> uk-margin-top uk-width-1-1">
            <i class="uk-icon-plus"></i>
            Neue Kategorie
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
            data-uk-tooltip title="Kategorie bearbeiten">
            <i class="uk-icon-edit"></i>
        </a>
        <a href="#delete-category-modal"
           class="uk-button uk-button-danger"
           data-uk-tooltip title="Kategorie Löschen"
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
             class="uk-button uk-button-large">
        <i class="uk-icon-folder"></i>
        <?php echo $cat->getName(); ?>
        <span class="uk-badge uk-badge-success">
            <?php echo $this->getService('helper')->getRecursiveCategoryContentCount($cat); ?>
        </span>
        </a> <?php
    }
    ?>
    <hr><?php
}

if (count($vars['contents'])) {
    ?>
    <table class="uk-table uk-table-striped uk-table-hover">
        <tr class="uk-hidden-small">
            <th width="15"></th>
            <th>
                Titel
                <i class="uk-icon-question-circle" data-uk-tooltip
                   title="Der Titel wird im Template nicht angezeigt. Er dient nur der internen Bezeichnung von Inhalten."></i>
            </th>
            <?php
            if ($this->isAdmin()) {
                ?>
                <th>
                    Snippet
                    <i class="uk-icon-question-circle" data-uk-tooltip
                       title="Das Snippet muss im Template eingefügt werden. An dieser Stelle erscheint dann der Inhalt."></i>
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
                    ?><i class="uk-icon-<?php echo $contentType->getIcon(); ?>"></i><?php
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
                   data-uk-tooltip title="Inhalt de-/aktivieren">
                    <i class="<?php echo $content->isActive() ? 'uk-icon-check-circle-o' : 'uk-icon-circle-o'; ?>"></i>
                </a>
                <a href="<?php echo $this->getUrl(
                    'content_form',
                    ['contentTypeId' => $content->getType(), 'contentId' => $content->getId()]
                ); ?>"
                   class="uk-button uk-button-success"
                   data-uk-tooltip title="Inhalt bearbeiten">
                    <i class="uk-icon-edit"></i>
                </a>
                <?php
                if ($this->isAdmin()) {
                    ?><a href="<?php echo $this->getUrl('content_delete', ['contentId' => $content->getId()]); ?>"
                         class="open-delete-modal uk-button uk-button-danger"
                         data-uk-tooltip title="Inhalt Löschen">
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
                <h2><i class="uk-icon-trash-o"></i> Löschen bestätigen</h2>
            </div>
            Möchten Sie diesen Inhalt wirklich löschen?
            <div class="uk-modal-footer">
                <a href="#" class="uk-button uk-button-danger uk-modal-close">
                    <i class="uk-icon-times"></i>
                    Nein!
                </a>
                <a href="#" class="uk-button uk-button-success uk-float-right">
                    <i class="uk-icon-check"></i>
                    Ja, jetzt löschen!
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
            <h2><i class="uk-icon-trash-o"></i> Löschen bestätigen</h2>
        </div>
        Möchten Sie diese Kategorie wirklich löschen?
        <?php
        $contentsCount = $this->getService('helper')->getRecursiveCategoryContentCount($vars['category']);
        if ($contentsCount) {
            echo '<br><br>Inhalte in dieser Kategorie: <b>' . $contentsCount . '</b> (Einschließlich Unterkategorien).';
        }
        ?>
        <br><br><b class="uk-text-danger">Es werden alle Inhalte, Unterkategorien und deren Inhalte gelöscht!</b>

        <div class="uk-modal-footer">
            <a href="#" class="uk-button uk-button-danger uk-modal-close">
                <i class="uk-icon-times"></i>
                Nein!
            </a>
            <a href="<?php echo $this->getUrl(
                'content_category_delete',
                ['categoryId' => $vars['category']->getId()]
            ); ?>" class="uk-button uk-button-success uk-float-right">
                <i class="uk-icon-check"></i>
                Ja, jetzt löschen!
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