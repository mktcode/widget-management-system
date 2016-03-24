<?php

namespace App\Controller;

use App\Entity\Content;

class ContentController extends Controller
{
    /**
     * Lists all existing contents.
     *
     * @return string
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
     * @return string
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
     * @return string
     */
    public function newAction($contentTypeId)
    {
        $contentType = $this->getContentType($contentTypeId);

        if ($_POST) {
            // save content entity
            $content = new Content();
            $content->setTitle(trim($_POST['title']));
            $content->setType($contentTypeId);
            $content->setHash(md5(time() . uniqid()));

            $this->getEntityManager()->persist($content);
            $this->getEntityManager()->flush();

            // call type specific save method
            $contentType->save($content->getId(), $_POST);
        }

        return $this->render(['contentType' => $contentType, 'contentTypeId' => $contentTypeId]);
    }
}