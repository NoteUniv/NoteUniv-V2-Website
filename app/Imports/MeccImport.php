<?php

namespace App\Imports;

use App\Models\Mecc;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class MeccImport implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $promo = $rows[0][1];
        $year = $rows[0][3];

        // skip first 3 rows
        $rows = $rows->slice(3);

        foreach ($rows as $row) {
            Mecc::create([
                'ue' => $row[1],
                'semester'  => $row[0],
                'subject_code' => $row[2],
                'subject_name' => $row[3],
                'coefficient' => $row[4],
                'promo' => $promo,
                'year' => $year,
            ]);
        }
    }
}

// HeadingRowFormatter::default('none');

// // NOTE Mapping not working with heading row (skipping first rows)

// class MeccImport implements ToModel, WithMappedCells, WithHeadingRow
// {
//     public function mapping(): array
//     {
//         return [
//             'Promotion' => 'B1',
//             'Année' => 'D1',
//         ];
//     }

//     /**
//      * @param array $row
//      *
//      * @return \Illuminate\Database\Eloquent\Model|null
//      */
//     public function model(array $row)
//     {
//         return new Mecc([
//             'ue' => $row[1],
//             'semester'  => $row['N° du semestre'],
//             'subject_code' => $row['Code de la matière'],
//             'subject_name' => $row['Nom complet de la matière'],
//             'coefficient' => $row['Coefficient'],
//             'promo' => $row['Promotion'],
//             'year' => $row['Année'],
//         ]);
//     }

//     public function headingRow(): int
//     {
//         return 3;
//     }
// }
