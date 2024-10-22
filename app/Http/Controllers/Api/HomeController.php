<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\BazarCustomer;
use App\Models\Souqistanboulform;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;


class HomeController extends Controller
{
    use TraitResponseTrait;

    public function index()
    {
        // Souqistanboul-form?region=تفصيل وخياطة
        // Souqistanboul-form?region=مكاتب إدارية
        // reservation?latest&count=10000000&project_id=1&type=سكنى
        // reservation ? latest & count = 10000000 & project_id = 1 & type = تجارى
        //     / bazar_customer

        // تفصيل وخياطة
        $data_one = Souqistanboulform::where('region', 'تفصيل وخياطة');
        $data_one_count = $data_one->count();
        // $data_one_contact = $data_one->where('contact', 1)->count();
        // $data_one_rate = $data_one_contact / $data_one_count;


        // مكاتب إدارية
        $data_two = Souqistanboulform::where('region', 'المكاتب الاداريه');
        $data_two_count = $data_two->count();
        // $data_two_contact = $data_two->where('contact', 1)->count();
        // $data_two_rate = $data_two_contact / $data_two_count;


        // reservation  project_id=1
        // type = سكنى

        $data_housing_count = Reservation::where('project_id', 1)->whereHas('unit', function ($query) {
                $query->whereHas('type', function ($subQuery) {
                $subQuery->where('name', 'سكنى');
            });
        })->count();


        // type = تجارى 
        $data_commercial_count = Reservation::where('project_id', 1)->whereHas('unit', function ($query) {
            $query->whereHas('type', function ($subQuery) {
                $subQuery->where('name', 'تجارى');
            });
        })->count();
    

        $data_housing_rate = Reservation::where('project_id', 1)->count() == 0 ? 0 : $data_housing_count / Reservation::where('project_id', 1)->count();
        $data_commercial_rate = Reservation::where('project_id', 1)->count() == 0 ? 0 : $data_commercial_count / Reservation::where('project_id', 1)->count();

        // BazarCustomer

        $bazarCustomer = BazarCustomer::count();


        $response = [
            'Souqistanboul_تفصيل وخياطة' => [
                'count'  => $data_one_count,
                //  'contact'=> $data_one_contact ,
                //  'rate'   => $data_one_rate 
            ],
            'Souqistanboul_مكاتب إدارية' => [
                'count'   => $data_two_count,
                // 'contact' => $data_two_contact,
                // 'rate'    => $data_two_rate 
            ],
            'reservation_سكنى'     => [
                'count'  => $data_housing_count,
                'rate'   => $data_housing_rate * 100
            ],
            'reservation_تجارى'    => [
                'count'  => $data_commercial_count,
                'rate'   => $data_commercial_rate * 100
            ],
            'BazarCustomer'        => [
                'count'  => $bazarCustomer,
            ]
        ];


        return $this->sendResponse($response, "كل البيانات", 200);
    }
}
