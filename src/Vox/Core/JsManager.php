<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.01.15
 */

namespace Vox\Core;


class JsManager implements ResourceInterface
{

    protected $files;

    /**
     * Registers the files
     *
     * @param $files
     * @return mixed
     */
    public function register($files)
    {
        if (is_array($files)) {
            $this->files = array_merge($this->files, $files);
        } else {
            $this->files[] = $files;
        }
    }

    /**
     * Serves the files
     *
     * @return string
     */
    public function serve()
    {
        $js = "";
        foreach ($this->files as $file) {
            $js .= '<link href="'.$file.'" rel="stylesheet">';
        }

        return $js;
    }

}