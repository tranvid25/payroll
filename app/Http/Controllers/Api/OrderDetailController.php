<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\OrderDetail;
use App\Models\Seat;
use App\Models\Showtime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OrderDetailController extends Controller
{
    public function index(){
     $Order=OrderDetail::all();
     if($Order){
        return response()->json([
            'status'=>200,
            'content'=>$Order
        ]);
     }
     else{
        return response()->json([
            'status'=>404,
            'message'=>'not found Order'
        ]);
     }
    }
    public function show($id){
        $Order=OrderDetail::findOrFail($id);
        if($Order){
            return response()->json([
                'status'=>200,
                'message'=>$Order
            ]);
        }
        else{
            return response()->json([
                'status'=>404,
                'message'=>'not found Order'
            ]);
        }
    }
    public function store(Request $request)
{
    // 1. Validate dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'maLichChieu' => 'required|exists:showtimes,id',
        'danhSachGhe' => 'required|string',
        'danhSachMaGhe' => 'required|string',
        'tongTien' => 'required|numeric|min:0',
        'userId' => 'nullable|exists:users,id',
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 422,
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors()
        ], 422);
    }

    // 2. Lấy thông tin từ lịch chiếu và liên kết
    $showtime = Showtime::with('rapChieu', 'phim')->find($request->maLichChieu);

    if (!$showtime || !$showtime->rapChieu || !$showtime->phim) {
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy thông tin suất chiếu, rạp hoặc phim'
        ], 404);
    }

    $tenRap = $showtime->rapChieu->tenRap;
    $tenPhim = $showtime->phim->tenPhim;
    $gioChieu = $showtime->gioChieu;
    $ngayChieu = $showtime->ngayChieu;
    $maPhim = $showtime->maPhim;

    // 3. Kiểm tra ghế đã được đặt chưa
    $arrMaGhe = array_map('intval', explode(',', $request->danhSachMaGhe));
    $gheDaDat = Seat::whereIn("maGhe", $arrMaGhe)
                    ->whereNotNull('nguoiDat')
                    ->pluck('maGhe');

    if ($gheDaDat->count() > 0) {
        return response()->json([
            'status' => 409,
            'message' => 'Một số ghế đã được đặt: ' . $gheDaDat->implode(', ')
        ], 409);
    }

    // 4. Lưu đơn hàng
    $order = OrderDetail::create([
        'maLichChieu' => $request->maLichChieu,
        'maPhim' => $maPhim,
        'phim' => $tenPhim,
        'rapChieu' => $tenRap,
        'gioChieu' => $gioChieu,
        'ngayChieu' => $ngayChieu,
        'danhSachGhe' => $request->danhSachGhe,
        'tongTien' => $request->tongTien,
        'userId' => $request->userId,
        'name' => $request->name,
        'email' => $request->email,
    ]);

    // 5. Đánh dấu ghế đã được đặt
    Seat::whereIn("maGhe", $arrMaGhe)->update([
        'nguoiDat' => $request->userId,
    ]);

    // 6. Gửi email xác nhận
    Mail::send('mail.sendEmail', [
        'rapChieu' => $tenRap,
        'phim' => $tenPhim,
        'gioChieu' => $gioChieu,
        'ngayChieu' => $ngayChieu,
        'danhSachGhe' => $request->danhSachGhe,
        'tongTien' => $request->tongTien,
        'name' => $request->name,
        'email' => $request->email,
    ], function ($message) use ($request) {
        $message->to($request->email, $request->name)
                ->subject('PHTV - Thông tin đặt vé');
    });

    // 7. Trả kết quả
    return response()->json([
        'status' => 200,
        'message' => 'Đặt vé thành công!',
        'content' => $order
    ]);
}
    public function showByUser($id)
    {
        $order = OrderDetail::where('userId', $id)->get();
        if ($order) {
            return response()->json([
                'status' => 200,
                'content' => $order
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no such order found'
            ], 404);
        }
    }


    public function doanhthu($year)
    {
        $order = OrderDetail::whereYear('created_at', $year)->get();
        if ($order->count() >= 0) {
            return response()->json([
                'status' => 200,
                'content' => $order
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'no oder found'
            ], 404);
        }
    }


}
