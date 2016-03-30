<?php

namespace App\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class TemplateController extends Controller
{
    /**
     * Show the file browser for the web directory.
     *
     * @param string $dir
     * @return Response
     */
    public function indexAction($dir = '')
    {
        $finder = new Finder();
        $finder
            ->in(__DIR__ . '/../../web/' . $dir)
            ->depth('< 1')
            ->filter(
                function (\SplFileInfo $file) {
                    if (!$file->isDir() && !in_array($file->getExtension(), ['html', 'htm', 'css', 'js', 'txt'])) {
                        return false;
                    }
                    return true;
                }
            )
            ->sortByName()
            ->sortByType();

        return $this->render(
            [
                'finder' => $finder,
                'dir' => $dir
            ]
        );
    }

    /**
     * Show the edit form and save updates to files.
     *
     * @param $file
     * @return Response
     */
    public function editAction($file)
    {
        if ($_POST) {
            $fs = new Filesystem();
            $fs->dumpFile(__DIR__ . '/../../web/' . $file, $_POST['file']);
        }

        $content = file_get_contents(__DIR__ . '/../../web/' . $file);
        return $this->render(['file' => $file, 'content' => $content]);
    }

    /**
     * Clears the cache.
     *
     * @return RedirectResponse
     */
    public function clearCacheAction()
    {
        $fs = new Filesystem();
        $fs->remove(glob(__DIR__ . '/../../cache/frontend/*'));

        if ($_SERVER['HTTP_REFERER']) {
            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }

        return new RedirectResponse('/');
    }
}