<?php

namespace App\Http\Controllers\Api\Ai;

use App\Http\Controllers\Controller;
use App\Http\Traits\PaginationTrait;
use App\Http\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    use PaginationTrait, ResponseTrait;

    public function index(Request $request)
    {
        $admin = Auth::user();
        $this->authorize('register', $admin);


        try {
            // 1. جلب البيانات من API الخارجي
            $response = Http::get('https://chat.enterprise-egy.com/chats/get_latest');

            if (!$response->successful()) {
                return $this->sendError('فشل جلب البيانات من الخادم الخارجي', [], 500);
            }

            // 2. تحويل البيانات إلى مصفوفة
            $allData = $response->json();

            // 3. تطبيق الباجينيشن باستخدام التريت
            $paginatedData = $this->paginateData($allData, $request, $request->input('paginate', 10));

            // 4. إنشاء روابط الباجينيشن باستخدام التريت
            $paginationUrls = $this->generatePaginationUrls(
                $paginatedData->currentPage(),
                $paginatedData->lastPage(),
                $request
            );

            // 5. بناء الرد النهائي
            $response = [
                'current_page' => $paginatedData->currentPage(),
                'data' => $paginatedData->items(),
                'total_pages' => $paginatedData->lastPage(),
                'next_page_url' => $paginationUrls['next_page_url'],
                'prev_page_url' => $paginationUrls['prev_page_url'],
            ];

            return $this->sendResponse($response, "بيانات المحادثات", 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 500);
        }
    }

    public function show($id)
    {
        $admin = Auth::user();
        $this->authorize('register', $admin);

        try {
            // 1. جلب البيانات من API الخارجي
            $response = Http::get('https://chat.enterprise-egy.com/chats/get?chat_id=' . $id);

            if (!$response->successful()) {
                return $this->sendError('فشل جلب البيانات من الخادم الخارجي', [], 500);
            }

            return $this->sendResponse($response->json(), "بيانات المحادثة", 200);
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), [], 500);
        }
    }
}
