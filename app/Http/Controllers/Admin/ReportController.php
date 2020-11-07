<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

  public $month;

  public function __construct()
  {
    $this->month = [
      '01' => 'Январь',
      '02' => 'Февраль',
      '03' => 'Март',
      '04' => 'Апрель',
      '05' => 'Май',
      '06' => 'Июнь',
      '07' => 'Июль',
      '08' => 'Август',
      '09' => 'Сентябрь',
      '10' => 'Октябрь',
      '11' => 'Ноябрь',
      '12' => 'Декабрь',
    ];
  }
  public function index() {
    $q = DB::select('SELECT date_format(created_at, "%Y-%m") as date, COUNT(1) as count, sum(total_amount) as total FROM orders where created_at is not null AND ship_status = \'received\' GROUP BY date_format(created_at, "%Y-%m")');
    $ch = [];
    $cl = [];
    $summ = 0;
    $i = 0;
    foreach($q as $data) {
      $ch[$i] = [$i, $data->count];
      $cl[$i] = [$i, $this->month[explode('-', $data->date)[1]]];
      $summ += $data->total;
      $i++;
    }
    return view('admin.reports.index', compact('ch', 'cl', 'summ'));
  }
}
