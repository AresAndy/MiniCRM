<?php

namespace MiniCRM\Sys;

use Mustache_Engine;
use Mustache_Loader_FilesystemLoader;

class MustacheRenderer {
    private $mustache;

    public function __construct($path) {
        $this->mustache = new Mustache_Engine(array(
            "loader" => new Mustache_Loader_FilesystemLoader($path)
        ));
    }

    public function render($response, $templatename, array $data = []) {
        $tpl = $this->mustache->loadTemplate($templatename);
        $output = $tpl->render($data);

        $response->getBody()->write($output);

        return $response;
    }
}