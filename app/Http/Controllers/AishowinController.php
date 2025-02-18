<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aishowin;

class AishowinController extends Controller
{
    public function index(){
        $trainUnits = Aishowin::where('tag', '=', '計算力を鍛える')
            ->get();

        $scienceUnits = Aishowin::where('tag', '=', '中学理科')
            ->get();

            $societyUnits = Aishowin::where('tag', '=', '中学社会')
            ->get();

            $appliedUnits = Aishowin::where('tag', '=', '応用問題')
            ->get();

        return view('aishowin.index', compact('trainUnits','scienceUnits','societyUnits','appliedUnits'));
    }
}
