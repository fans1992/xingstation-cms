<?php
/**
 * Created by PhpStorm.
 * User: jhk
 * Date: 2018/5/20
 * Time: 下午4:10
 */

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AbstractExport implements FromCollection, WithStrictNullComparison, WithEvents
{
    public function collection()
    {
    }

    public function registerEvents(): array
    {
        return [];
    }
}