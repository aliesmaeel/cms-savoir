<?php

namespace App\Imports;

use App\Exports\UnImportedDataExport;
use App\Models\Data;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Throwable;

class DataImport implements ToCollection, WithStartRow, WithChunkReading
{
    use Importable;
    private $filename;
    // private collection $unImportedData;
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function collection(Collection $rows)
    {
        // 9 phone, 10 email, 15 mobile, 16 secondary mobile
        foreach ($rows as $key => $row) {
            if (strlen($row[9]) < 6 && strlen($row[15]) < 6 && strlen($row[16]) < 6 && $row[10] == '') {
                // $unImportedData[] = $row;
            } else {
                try {
                    if ($row[9] != '') {
                        $val = trim($row[9]);
                    } else if ($row[15] != '') {
                        $val = trim($row[15]);
                    } else if ($row[16] != '') {
                        $val = trim($row[16]);
                    } else {
                        unset($row);
                    }

                    Data::create([
                        'phone' => $val, 'source' => $this->filename,
                        'P_NUMBER' =>  $row[0],
                        'AREA' => $row[1] == '' ? '-' : $row[1],
                        'USAGE' =>  $row[2] == '' ? '-' : $row[2],
                        'TOTAL_AREA' => $row[3] == '' ? '-' : $row[3],
                        'PLOT_NUMBER' =>  $row[4] == '' ? '-' : $row[4],
                        'EMIRATE' =>  $row[5] == '' ? '-' : $row[5],
                        'NAME' => $row[6] == '' ? '-' : $row[6],
                        'AREA_OWNED' => $row[7] == '' ? '-' : $row[7],
                        'ADDRESS' =>  $row[8] == '' ? '-' : $row[8],
                        'phone_whatsup' =>  $row[9] == '' ? '-' : "https://web.whatsapp.com/send?phone=" . trim($row[9]),
                        'EMAIL' =>  $row[10] == '' ? '-' : trim($row[10]),
                        'FAX' =>  $row[11] == '' ? '-' : $row[11],
                        'PO_BOX' =>  $row[12] == '' ? '-' : $row[12],
                        'GENDER' => $row[13] == '' ? '-' : $row[13],
                        'DOB' =>  $row[14] == '' ? '-' : Carbon::parse($row[14])->toDateString(),
                        'MOBILE' =>  $row[15] == '' ? '-' : trim($row[15]),
                        'MOBILE_whatsup' =>  $row[15] == '' ? '-' : "https://web.whatsapp.com/send?phone=" . trim($row[15]),
                        'SECONDARY_MOBILE' => $row[16] == '' ? '-' : $row[16],
                        'SECONDARY_MOBILE_wahtsup' => $row[16] == '' ? '-' : "https://web.whatsapp.com/send?phone=" . trim($row[16]),
                        'PASSPORT' => $row[17] == '' ? '-' : $row[17],
                        'ISSUE_DATE' =>  $row[18] == '' ? '-' : Carbon::parse($row[18])->toDateString(),
                        'EXPIRY_DATE' => $row[19] == '' ? '-' : Carbon::parse($row[19])->toDateString(),
                        'PLACE_OF_ISSUE' =>  $row[20] == '' ? '-' : $row[20],
                        'EMIRATES_ID_NUMBER' =>  $row[21] == '' ? '-' : $row[21],
                        'EMIRATES_ID_EXPIRY_DATE' => $row[22] == '' ? '-' : Carbon::parse($row[22])->toDateString(),
                        'RESIDENCE_COUNTRY' =>  $row[23] == '' ? '-' : $row[23],
                        'NATIONALITY' =>  $row[24] == '' ? '-' : $row[24],
                        'Master_Project' =>  $row[25] == '' ? '-' : $row[25],
                        'Project' =>  $row[26] == '' ? '-' : $row[26],
                        'Building_Name' =>  $row[27] == '' ? '-' : $row[27],
                        'Agents' =>  $row[28] == '' ? '-' : $row[28],
                        'Flat_Number' => $row[29] == '' ? '-' : $row[29],
                        'No_of_Beds' => $row[30] == '' ? '-' : $row[30],
                        'Floor' =>  $row[31] == '' ? '-' : $row[31],
                        'registration_number' =>  $row[32] == '' ? '-' : $row[32],
                        'lat' =>  $row[33] == '' ? '' : explode(',', $row[33])[0],
                        'lng' =>  $row[33] == '' ? '' : explode(',', $row[33])[1],
                        'file' => $this->filename
                    ]);
                } catch (\Throwable $th) {
                    // $unImportedData[] = $row;
                }
            }
        }
        // dd(count($unImportedData));
        // return (new UnImportedDataExport($unImportedData))->store("file.xlsx");
    }

    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
