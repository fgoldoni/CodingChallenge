<?php


namespace App\Service\Src;

use App\Service\Contracts\CsvExportInterface;
use App\Service\ExportServiceAbstract;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class CsvExportService
 *
 * @package \App\Service\Src
 */
class CsvExportService extends ExportServiceAbstract implements CsvExportInterface
{
    public function extension()
    {
        return 'csv';
    }

    public function export(string $path)
    {
       $data = $this->data($path);

        $normalizers = [new ObjectNormalizer()];

        $encoders = [
            new CsvEncoder()
        ];

        $serialiser = new Serializer($normalizers, $encoders);

        $data = $serialiser->encode($data, $this->extension());

        return file_put_contents($this->downloadDirectory($path) . '/products' . time() . '.' . $this->extension(), $data);
    }
}
