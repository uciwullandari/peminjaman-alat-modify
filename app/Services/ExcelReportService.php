<?php

namespace App\Services;

use ZipArchive;

class ExcelReportService
{
    /**
     * @param array<int, array<int, scalar|null>> $rows
     */
    public function download(string $filename, array $rows)
    {
        $path = tempnam(sys_get_temp_dir(), 'laporan_') . '.xlsx';
        $zip = new ZipArchive();
        $zip->open($path, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $zip->addFromString('[Content_Types].xml', $this->contentTypes());
        $zip->addFromString('_rels/.rels', $this->rootRelationships());
        $zip->addFromString('xl/workbook.xml', $this->workbook());
        $zip->addFromString('xl/_rels/workbook.xml.rels', $this->workbookRelationships());
        $zip->addFromString('xl/worksheets/sheet1.xml', $this->worksheet($rows));
        $zip->close();

        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }

    private function worksheet(array $rows): string
    {
        $xmlRows = '';

        foreach ($rows as $rowNumber => $row) {
            $cells = '';

            foreach (array_values($row) as $columnNumber => $value) {
                $reference = $this->columnName($columnNumber + 1) . ($rowNumber + 1);
                $escaped = htmlspecialchars((string) ($value ?? ''), ENT_XML1 | ENT_COMPAT, 'UTF-8');
                $isNumber = is_int($value) || is_float($value);
                $type = $isNumber ? 'n' : 'inlineStr';
                $content = $isNumber ? '<v>' . $escaped . '</v>' : '<is><t>' . $escaped . '</t></is>';
                $cells .= '<c r="' . $reference . '" t="' . $type . '">' . $content . '</c>';
            }

            $xmlRows .= '<row r="' . ($rowNumber + 1) . '">' . $cells . '</row>';
        }

        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>' . $xmlRows . '</sheetData></worksheet>';
    }

    private function columnName(int $number): string
    {
        $name = '';

        while ($number > 0) {
            $remainder = ($number - 1) % 26;
            $name = chr(65 + $remainder) . $name;
            $number = intdiv($number - 1, 26);
        }

        return $name;
    }

    private function contentTypes(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '</Types>';
    }

    private function rootRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
    }

    private function workbook(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets><sheet name="Laporan" sheetId="1" r:id="rId1"/></sheets></workbook>';
    }

    private function workbookRelationships(): string
    {
        return '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '</Relationships>';
    }
}
