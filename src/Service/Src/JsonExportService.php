<?php


namespace App\Service\Src;

use App\Service\Contracts\JsonExportInterface;
use App\Service\ExportServiceAbstract;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class JsonExportService
 *
 * @package \App\Service\Src
 */
class JsonExportService extends ExportServiceAbstract implements JsonExportInterface
{
    public function extension()
    {
        return 'json';
    }

    public function export(string $path)
    {
        $data = $this->data($path);

        $normalizers = [new ObjectNormalizer()];

        $encoders = [
            new JsonEncode()
        ];

        $serialiser = new Serializer($normalizers, $encoders);

        $data = $serialiser->serialize($data, $this->extension());

        return file_put_contents($this->downloadDirectory($path) . '/download' . time() . '.' . $this->extension(), $data);
    }
}