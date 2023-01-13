<?php

namespace App\Imports;

use App\Models\Nationality;
use Maatwebsite\Excel\Concerns\ToModel;

class NationalitiesImport implements ToModel
{
    static $x = 0;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // if (NationalitiesImport::$x > 0) {
        //     $code = $row[0];
        //     $label = $row[1];
        //     return new Nationality([
        //         'code'=> $code,
        //         'label' => $label
        //     ]);
        // } else {
        //     NationalitiesImport::$x++;
        // }
    }
}
