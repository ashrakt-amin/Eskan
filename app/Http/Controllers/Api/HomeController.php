<?php

namespace App\Http\Controllers\Api;

use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\BazarCustomer;
use App\Models\Souqistanboulform;
use App\Http\Controllers\Controller;
use App\Http\Traits\ResponseTrait as TraitResponseTrait;
use Nette\Utils\Floats;

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
        $data_one_contract = $data_one->where('contract', 1)->count();
        $data_one_rate_contract = $data_one_count == 0 ? 0 :  number_format($data_one_contract /$data_one_count, 1, '.', '');


        // مكاتب إدارية
        $data_two = Souqistanboulform::where('region', 'المكاتب الاداريه');
        $data_two_count = $data_two->count();
        $data_two_contract = $data_two->where('contract', 1)->count();
        $data_two_rate_contract = $data_two_count == 0 ? 0 : number_format($data_two_contract /$data_two_count, 1, '.', '');


        // reservation  project_id=1
        // type = سكنى

        $data_housing = Reservation::where('project_id', 1)->whereHas('unit', function ($query) {
                $query->whereHas('type', function ($subQuery) {
                $subQuery->where('name', 'سكنى');
            });
        });

        $data_housing_count = $data_housing->count();
        $data_housing_contract = $data_housing->where('contract', 1)->count();



        // type = تجارى 
        $data_commercial = Reservation::where('project_id', 1)->whereHas('unit', function ($query) {
            $query->whereHas('type', function ($subQuery) {
                $subQuery->where('name', 'تجارى');
            });
        });
        $data_commercial_count = $data_commercial->count();
        $data_commercial_contract = $data_commercial->where('contract', 1)->count();



        $data_housing_rate_contract = Reservation::where('project_id', 1)->count() == 0 ? 0 : number_format($data_housing_contract / Reservation::where('project_id', 1)->count(), 1, '.', '');
        $data_commercial_rate_contract = Reservation::where('project_id', 1)->count() == 0 ? 0 : number_format($data_commercial_contract / Reservation::where('project_id', 1)->count(), 1, '.', '');

        // BazarCustomer

        $bazarCustomer_count = BazarCustomer::count();
        $bazarCustomer_contract = $data_two->where('contract', 1)->count();
        $bazarCustomer_rate_contract = $bazarCustomer_count == 0 ? 0 : number_format($bazarCustomer_contract / $bazarCustomer_count, 1, '.', '');



        $response = [
            'Souqistanboul_تفصيل وخياطة' => [
                'count'         => $data_one_count,
                'contract'      => $data_one_contract ,
                'rate_contract' => $data_one_rate_contract * 100
            ],
            'Souqistanboul_مكاتب إدارية' => [
                'count'          => $data_two_count,
                'contract'       => $data_two_contract,
                'rate_contract'  => $data_two_rate_contract * 100 
            ],
            'reservation_سكنى'     => [
                'count'         => $data_housing_count,
                'contract'       => $data_housing_contract,
                'rate_contract' => $data_housing_rate_contract * 100
            ],
            'reservation_تجارى'    => [
                'count'          => $data_commercial_count,
                'contract'        => $data_commercial_contract,
                'rate_contract'  => $data_commercial_rate_contract * 100
            ],
            'BazarCustomer'        => [
                'count'          => $bazarCustomer_count,
                'contract'        => $bazarCustomer_contract,
                'rate_contract'  => $bazarCustomer_rate_contract * 100
            ]
        ];


        return $this->sendResponse($response, "كل البيانات", 200);
    }
}
