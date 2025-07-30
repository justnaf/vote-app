<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VotersExport implements FromCollection, WithHeadings
{
    protected $users;

    /**
     * Menerima data pengguna yang akan diekspor melalui constructor.
     *
     * @param array $users
     */
    public function __construct(array $users)
    {
        $this->users = $users;
    }

    /**
     * Mengembalikan koleksi data yang akan ditulis ke dalam file Excel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->users);
    }

    /**
     * Mendefinisikan judul untuk setiap kolom.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Username',
            'Password',
        ];
    }
}
