<?php

namespace App\Http\Livewire;

use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

    public $year, $salesByMonth_Data = [], $top5Data =[], $weekSales_Data=[], $listYears=[] ;

    public function mount()
    {
        if ($this->year == '') $this->year = date('Y');
    }


    public function render()
    {
        $this->listYears =[];
        $currentYear =  date('Y') -1;
        for ($i=1; $i < 7 ; $i++) {
            array_push($this->listYears, $currentYear +$i);
        }

        $this->getTop5();

        return view('livewire.dash.component')->layout('layouts.theme.app');
    }

    public function getTop5 ()
    {
        $this->top5Data = OrderDetail::join('products as p', 'order_details.product_id','p.id')
        ->select(
            DB::raw("p.name as product, sum(order_details.quantity * p.price) as total")
        )->whereYear('order_details.created_at', $this->year)
        ->groupBy('p.name')
        ->orderBy(DB::raw("sum(order_details.quantity * p.price)"), 'desc')
        ->get()->take(5)->toArray();

        $contDif = ( 5 - count($this->top5Data)); // si la consulta devuelve 5 productos o menos

        if ($contDif > 0) {
            for ($i=1; $i <= $contDif; $i++) {
                array_push($this->top5Data, ["product" => "-", "total" => 0]);
            }
        }

    }
}
