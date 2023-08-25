<?php 
namespace App\Exports;
 
use Carbon\Carbon;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
 
class OrderExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //returns Data with User data, all user data, not restricted to start/end dates
        return Order::all();
    }
 
    public function map($data) : array {
        return [
            $data->user->name,
            $data->name,
            $data->concepts,
            $data->client->name,
            $data->start_date,
            $data->logo_type,
            $data->complete,
            $data->final,
            $data->work_from
        ] ;
 
 
    }
 
    public function headings() : array {
        return [
            'user name',
            'Order name',
            'Order concept',
            'Client name',
            'Start date',
            'Logo type',
            'Complete',
            'Final',
            'work from'
        ] ;
    }
}