<?php

namespace App\Controller;

use App\Entity\Content;
use App\Entity\ContentCategory;
use App\Entity\ContentData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContentController extends Controller
{

    /**
     * Lists all existing contents.
     *
     * @param int|null $categoryId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($categoryId = null)
    {
        // load contents and categories
        $category = $this->getEntityLoader('App\Entity\ContentCategory')->loadById(['id' => $categoryId]);
        $categories = $this->getEntityLoader('App\Entity\ContentCategory')->loadAll(['parent' => $categoryId ?: null]);
        $contents = $this->getEntityLoader('App\Entity\Content')->loadAll(['contentCategory' => $category ?: null]);

        return $this->render([
            'categories' => $categories,
            'category' => $category,
            'contents' => $contents
        ]);
    }

    /**
     * Shows a list of available content types.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contentTypesAction()
    {
        // get all available content types
        $contentTypes = $this->getContentTypes();

        return $this->render(['contentTypes' => $contentTypes]);
    }

    /**
     * Shows the dialog for a new content and calls the save method of the content type if data is posted.
     *
     * @param $contentTypeId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function formAction($contentTypeId, $contentId = null)
    {
        $contentType = $this->getContentType($contentTypeId);
        $content = null;
        $categories = $this->getEntityLoader('App\Entity\ContentCategory')->loadAll();
        $message = '';

        if ($contentId) {
            $content = $this->getEntityLoader('App\Entity\Content')->loadById(['id' => $contentId]);
        }

        if ($_POST) {
            // save content entity
            $redirect = false;
            if (!$content) {
                // create new content entity
                $content = new Content();
                $this->getEntityManager()->persist($content);

                $content->setType($contentTypeId);
                $content->setHash(md5(time() . uniqid()));
                $content->setActive(1);

                $redirect = true;
            }
            if ((int)$_POST['category']) {
                /** @var ContentCategory $category */
                $category = $this->getEntityLoader('App\Entity\ContentCategory')->loadById(['id' => (int)$_POST['category']]);
                $content->setContentCategory($category);
            }
            $content->setTitle(trim($_POST['title']));

            $this->getEntityManager()->flush();

            // call type specific save method
            $contentType->save($content->getId(), $_POST);

            if ($redirect) {
                return new RedirectResponse($this->getUrl('content_form', [
                    'contentTypeId' => $contentTypeId,
                    'contentId' => $content->getId()
                ]));
            }

            $message = '<i class="uk-icon-check"></i> Inhalt gespeichert!';
        }

        return $this->render([
            'content' => $content,
            'contentId' => $contentId,
            'contentType' => $contentType,
            'contentTypeId' => $contentTypeId,
            'categories' => $categories,
            'message' => $message
        ]);
    }

    /**
     * @param $contentId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($contentId)
    {
        /** @var Content $content */
        $content = $this->getEntityLoader('App\Entity\Content')->loadById(['id' => $contentId]);

        /** @var ContentData $ContentData */
        foreach ($content->getContentData() as $ContentData) {
            $this->getEntityManager()->remove($ContentData);
        }

        $this->getEntityManager()->remove($content);
        $this->getEntityManager()->flush();

        return new RedirectResponse($this->getUrl('index'));
    }

    /**
     * Toggles the active status of a content.
     *
     * @param $contentId
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function toggleActiveAction($contentId)
    {
        /** @var Content $content */
        $content = $this->getEntityLoader('App\Entity\Content')->loadById(['id' => $contentId]);

        $content->setActive(!$content->isActive());

        $this->getEntityManager()->flush();

        return new JsonResponse(['active' => $content->isActive()]);
    }

    /**
     * Shows category form.
     *
     * @param $categoryId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryFormAction($categoryId = null)
    {
        $category = null;
        $categories = $this->getEntityLoader('App\Entity\ContentCategory')->loadAll();
        $message = '';

        if ($categoryId) {
            $category = $this->getEntityLoader('App\Entity\ContentCategory')->loadById(['id' => $categoryId]);
        }

        if ($_POST) {
            $redirect = false;
            // save content entity
            if (!$category) {
                $category = new ContentCategory();
                $this->getEntityManager()->persist($category);

                $redirect = true;
            }
            $category->setName(trim($_POST['name']));
            /** @var ContentCategory $parent */
            if (array_key_exists('parent', $_POST) && (int)$_POST['parent']) {
                $parent = $this->getEntityLoader('App\Entity\ContentCategory')->loadById(['id' => (int)$_POST['parent']]);
                $category->setParent($parent);
            }

            $this->getEntityManager()->flush();

            if ($redirect) {
                return new RedirectResponse($this->getUrl('content_category_form', ['categoryId' => $category->getId()]));
            }

            $message = '<i class="uk-icon-check"></i> Kategorie gespeichert!';
        }

        return $this->render([
            'category' => $category,
            'categoryId' => $categoryId,
            'categories' => $categories,
            'message' => $message
        ]);
    }

    /**
     * @param $categoryId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function categoryDeleteAction($categoryId)
    {
        $this->deleteCategoriesRecursive($categoryId);

        return new RedirectResponse($this->getUrl('index'));
    }

    private function deleteCategoriesRecursive($categoryId)
    {
        /** @var ContentCategory $category */
        $category = $this->getEntityLoader('App\Entity\ContentCategory')->loadById(['id' => $categoryId]);
        $contents = $category->getContents();
        $subCategories = $category->getChildren();

        /** @var Content $content */
        foreach ($contents as $content) {
            $contentData = $this->getEntityLoader('App\Entity\ContentData')->loadAll(['content' => $content->getId()]);
            foreach ($contentData as $data) {
                $this->getEntityManager()->remove($data);
            }
            $this->getEntityManager()->remove($content);
        }

        /** @var ContentCategory $subCategory */
        foreach ($subCategories as $subCategory) {
            $this->deleteCategoriesRecursive($subCategory->getId());
            $this->getEntityManager()->remove($subCategory);
        }

        $this->getEntityManager()->remove($category);

        $this->getEntityManager()->flush();
    }
}