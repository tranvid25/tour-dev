<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Booking;
use App\Models\clients\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Predis\Command\Redis\TIME;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::all();
        return response()->json([
            'message' => 'Hiển thị thành công',
            'bookings' => $bookings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tourId' => 'required|exists:tbl_tour,tourId',
            'numAdults' => 'required|integer|min:0',
            'numChildren' => 'required|integer|min:0',
            'specicalRequestes' => 'nullable|string' // Đúng tên
        ]);

        $tour = Tour::findOrFail($request->tourId);
        $totalTickets = $request->numAdults + $request->numChildren;

        if ($tour->quantity < $totalTickets) {
            return response()->json([
                'message' => 'Tour đã hết chỗ hoặc không đủ vé còn lại.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $totalPrice = ($tour->priceAdult * $request->numAdults) + ($tour->priceChild * $request->numChildren);
            $orderCode = 'ORDER' . time();
            $booking = Booking::create([
                'tourId' => $tour->tourId,
                'userId' => auth()->id(),
                'bookingDate' => now(),
                'numAdults' => $request->numAdults,
                'numChildren' => $request->numChildren,
                'totalPrice' => $totalPrice,
                'order_code' => $orderCode,
                'bookingStatus' => 'pending',
                'specicalRequestes' => $request->specicalRequestes // đúng tên
            ]);

            $tour->quantity -= $totalTickets;
            $tour->save();

            DB::commit();
            //tạo link thanh toánVNPAY với $orderCode và $totalprice
            $paymentUrl = "/api/user/payment/vnpay"
                . "?order_code={$orderCode}"
                . "&total_price={$totalPrice}";
            return response()->json([
                'message' => 'Đặt tour thành công!',
                'booking' => $booking,
                'payment_url' => $paymentUrl
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi khi đặt tour',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    //tourId sẽ đc đính vào nút đặt
    //còn userID sẽ đc lấy khi có token trong backend
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bookings = Booking::findOrFail($id);
        return response()->json([
            'message' => 'Chi tiết booking',
            'bookings' => $bookings
        ]);
    }
    public function myBookings()
    {
        $user = Auth::id();
        $bookings = Booking::with('tour')->where('userId', $user)->get();
        $message = __('messages.booking.success');
        return response()->json([
            'message_key' => 'booking.success',  // key để frontend dùng
            'message_text' => $message,//testbackend
            'bookings'=>$bookings
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookings = Booking::findOrFail($id);
        $bookings->delete();
        return response()->json([
            'message' => 'Xóa thành công'
        ]);
    }
    public function cancel(Request $request, string $id)
    {
        $request->validate([
            'reasonId' => 'required|exists:tbl_reason,reasonId', // đúng tên bảng
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $booking = Booking::findOrFail($id);

            if ($booking->bookingStatus === 'canceled') {
                return response()->json([
                    'message' => 'Booking đã bị hủy trước đó.'
                ], 400);
            }

            // Gán lý do hủy và ghi chú
            $booking->reasonId = $request->reasonId;
            $booking->note = $request->note;
            $booking->bookingStatus = 'canceled';
            $booking->save();

            // Tăng lại số lượng tour
            $tour = Tour::findOrFail($booking->tourId);
            $totalTickets = $booking->numAdults + $booking->numChildren;
            $tour->quantity += $totalTickets;
            $tour->save();

            // Xóa mềm
            $booking->delete();

            DB::commit();

            return response()->json([
                'message' => 'Hủy booking thành công.'
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Lỗi khi hủy booking.',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
