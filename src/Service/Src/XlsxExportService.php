<?php


namespace App\Service\Src;

use App\Service\Contracts\XlsxExportInterface;
use App\Service\Contracts\ExportServiceInterface;
use App\Service\ExportServiceAbstract;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class XlsxExportService
 *
 * @package \App\Service\Src
 */
class XlsxExportService extends ExportServiceAbstract implements XlsxExportInterface
{
    public function extension()
    {
        return 'xlsx';
    }

    public function export(string $path)
    {
        $data = $this->data($path);

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->fromArray($data);

        $writer = new Xlsx($spreadsheet);

        return $writer->save($this->downloadDirectory($path) . '/download' . time() . '.' . $this->extension());
    }
}
