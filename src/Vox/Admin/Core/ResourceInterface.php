<?php
/**
 * @author Marco Troisi <hello@marcotroisi.com>
 * @created 02.01.15
 */

namespace Vox\Admin\Core;


interface ResourceInterface {

    /**
     * Registers the files
     *
     * @param $files
     * @return mixed
     */
    public function register($files);

    /**
     * Serves the files
     *
     * @return string
     */
    public function serve();

}