<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function getCombinedData()
    {
        try {
            // Lấy dữ liệu từ Laravel (MySQL)
            $laravelData = Employee::all()->toArray();

            // Lấy URL API Java từ biến môi trường
            $javaApiUrl = env('JAVA_API_URL');

            if (empty($javaApiUrl)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Chưa cấu hình JAVA_API_URL trong .env'
                ], 500);
            }

            // Gọi API Java
            $javaResponse = Http::timeout(5)->get($javaApiUrl);

            // Kiểm tra phản hồi từ Java
            if (!$javaResponse->successful()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Lỗi khi gọi API Java',
                    'status' => $javaResponse->status(),
                    'message' => $javaResponse->body()
                ], $javaResponse->status());
            }

            // Parse dữ liệu JSON từ Java
            $javaData = $javaResponse->json();

            // Map dữ liệu Java theo ID để merge
            $javaMap = collect($javaData)->keyBy('id');

            // Merge dữ liệu theo ID
            $mergedData = collect($laravelData)->map(function ($item) use ($javaMap) {
                $id = $item['id'];
                $javaItem = $javaMap->get($id, []);
                return array_merge($item, $javaItem);
            });

            // Trả kết quả
            return response()->json([
                'success' => true,
                'data' => $mergedData->values() // đảm bảo index đẹp
            ]);

        } catch (\Exception $e) {
            // Ghi log lỗi nếu cần
            Log::error('Lỗi khi merge dữ liệu từ Laravel và Java API', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => 'Lỗi tổng hợp dữ liệu',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
