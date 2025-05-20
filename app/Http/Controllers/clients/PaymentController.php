<?php

namespace App\Http\Controllers\clients;

use App\Http\Controllers\Controller;
use App\Models\clients\Booking;
use App\Models\clients\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function vnpay_payment(Request $request)
    {
        $orderCode = $request->input('order_code');
        $totalPrice = $request->input('total_price');

        if (!$orderCode || !$totalPrice) {
            return response()->json([
                'code' => '01',
                'message' => 'Thiếu order_code hoặc total_price'
            ], 400);
        }
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/vnpay-return"; //Api xử lý callback
        $vnp_TmnCode = "IEKAFZ2J";
        $vnp_HashSecret = "P1ZNFQSGKJY40E7H5OOV63VWA9V18TY8";

        $vnp_TxnRef = $orderCode;
        $vnp_OrderInfo = 'Thanh toán đơn hàng' . $vnp_TxnRef;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $totalPrice * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $hashdata = urldecode(http_build_query($inputData));
        $query = http_build_query($inputData);
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= "?" . $query . '&vnp_SecureHash=' . $vnp_SecureHash;
        return response()->json([
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        ]);
    }
    public function vnPayReturn(Request $request)
    {
        $inputData = $request->all();
        if (!isset($inputData['vnp_SecureHash'])) {
            return response()->json([
                'message' => 'Thiếu thông tin chữ ký'
            ], 400);
        }
        $vnp_HashSecret = "P1ZNFQSGKJY40E7H5OOV63VWA9V18TY8";
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);
        ksort($inputData);
        $hashdata = urldecode(http_build_query($inputData));
        $secureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        if ($secureHash !== $vnp_SecureHash) {
            return response()->json([
                'message' => 'Sai chữ ký'
            ], 400);
        }
        Payment::create([
            'order_code' => $request->input('vnp_TxnRef'),
            'amount' => $request->input('vnp_Amount') / 100,
            'bank_code' => $request->input('vnp_BankCode'),
            'transaction_no' => $request->input('vnp_TransactionNo'),
            'response_code' => $request->input('vnp_ResponseCode'),
            'transaction_status' => $request->input('vnp_TransactionStatus'),
            'order_info' => $request->input('vnp_OrderInfo'),
            'Pay_date' => $request->input('vnp_PayDate'),
            'ip_address' => $request->input('vnp_IpAddr'),
        ]);
        $booking = Booking::where('order_code', $request->input('vnp_TxnRef'))->first();
        if ($booking && $request->input('vnp_ResponseCode') == '00') {
            $booking->BookingStatus = 'payment_success';
            $booking->save();
        }
        return redirect()->away('http://localhost:8080/weblinhkienmaytinh/checkout?status=success');
    }
}
