<?php

namespace App\Service;

interface ExportableDocumentInterface
{
    /**
     * @param string $path
     *
     * @return mixed
     */
    public function data(string $path);

    /**
     * @param string $path
     *
     * @return string
     */
    public function fileExtension(string $path): string;

    /**
     * @param string $path
     *
     * @return string
     */
    public function fileContent(string $path): string;


    /**
     * @param string $path
     *
     * @return string
     */
    public function downloadDirectory(string $path): string;
}
