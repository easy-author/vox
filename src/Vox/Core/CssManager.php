<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.01.15
 */

namespace Vox\Core;


class CssManager implements ResourceInterface
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
        $css = "";
        foreach ($this->files as $file) {
            $css .= '<link href="'.$file.'" rel="stylesheet">';
        }

        return $css;
    }

}