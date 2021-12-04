<?php


namespace App\Service;


use App\Service\Contracts\ExportServiceInterface;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class ServiceAbstract
 *
 * @package \App\Service
 */
abstract class ExportServiceAbstract implements ExportableDocumentInterface
{
    /**
     * @return mixed
     */
    abstract public function extension();

    /**
     * @param string $path
     *
     * @return mixed
     */
    abstract function export(string $path);

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function data(string $path)
    {
        $normalizers = [new ObjectNormalizer()];

        $encoders = [
            new XmlEncoder()
        ];

        $serialiser = new Serializer($normalizers, $encoders);

        $data = $this->fileContent($path);

        $format = $this->fileExtension($path);

        $result = $serialiser->decode($data, $format);

        if (array_key_exists('product', $result)) {

            return $result['product'];
        }

        return $result;
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function fileExtension(string $path): string
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function fileContent(string $path): string
    {
        return file_get_contents($path);
    }

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function downloadDirectory(string $path): string
    {
        return pathinfo($path, PATHINFO_DIRNAME);
    }
}
