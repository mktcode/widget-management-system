<?php

namespace App\Controller;

use App\Entity\Content;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ContentController extends Controller
{

    /**
     * Lists all existing contents.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // load all contents
        $contents = $this->getEntityLoader('App\Entity\Content')->loadAll();

        return $this->render(['contents' => $contents]);
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
        $message = '';

        if ($contentId) {
            $content = $this->getEntityLoader('App\Entity\Content')->loadById(['id' => $contentId]);
        }

        if ($_POST) {
            // save content entity
            if (!$content) {
                $content = new Content();
                $this->getEntityManager()->persist($content);

                $content->setType($contentTypeId);
                $content->setHash(md5(time() . uniqid()));
            }
            $content->setTitle(trim($_POST['title']));

            $this->getEntityManager()->flush();

            // call type specific save method
            $contentType->save($content->getId(), $_POST);

            $message = '<i class="uk-icon-check"></i> Inhalt gespeichert!';
        }

        return $this->render([
            'content' => $content,
            'contentId' => $contentId,
            'contentType' => $contentType,
            'contentTypeId' => $contentTypeId,
            'message' => $message
        ]);
    }

    /**
     * @param $contentId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction($contentId)
    {
        $content = $this->getEntityLoader('App\Entity\Content')->loadById(['id' => $contentId]);
        $this->getEntityManager()->remove($content);
        $this->getEntityManager()->flush();

        return new RedirectResponse($this->getUrl('index'));
    }
}