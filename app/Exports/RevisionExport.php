<?php 
namespace App\Exports;
 
use Carbon\Carbon;
use App\Models\Revision;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
 
class RevisionExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //returns Data with User data, all user data, not restricted to start/end dates
        return Revision::all();
    }
 
    public function map($data) : array {
        return [
            $data->user->name,
            $data->order->name,
            $data->revisions,
            $data->start_date,
            $data->complete,
            $data->work_from

        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            'user name',
            'Order name',
            'Revision concept',
            'Start date',
            'Complete',
            'work from'
        ] ;
    }
}