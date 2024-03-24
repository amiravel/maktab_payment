<?php

namespace App\Http\Controllers;

use App\Actions\GetActiveCycle;
use App\Actions\Payment\PaymentMarkAsRead;
use App\Actions\Payment\PaymentMarkAsUnRead;
use App\Actions\Payment\PaymentVerify;
use App\Http\Requests\CreatePaymentRequest;
use App\Models\Drive;
use App\Models\Payment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Shetabit\Multipay\Invoice;

class PaymentController extends Controller
{

    public function index()
    {
        return view('payments.index');
    }

    public function create()
    {
        $tags = Tag::query()
            ->whereNull('parent')
            ->get();

        return view('payments.create', compact('tags'));
    }

    public function store(CreatePaymentRequest $request)
    {
        DB::beginTransaction();

        /**
         * @var Payment $payment
         */
        $payment = Payment::create($request->only([
            'user_id', 'name', 'email', 'mobile', 'description', 'amount', 'callback', 'extra_callback', 'information'
        ]));

        if ($request->has('tags')) {
            $payment->tags()->sync($request->get('tags'));
        }

        $cycle = GetActiveCycle::run();
        $payment->cycles()->sync($cycle->id);
        $payment->drive_id = $request->has('fake') ? 8 : Drive::whereValue($cycle->drive)->first()->id;
        $payment->save();

        $invoice = new Invoice();
        $invoice->amount(($payment->drive->value == 'vandar' || $payment->drive->value == 'pasargad') ? ($payment->amount * 10) : $payment->amount);

        if (in_array($request->get('mobile'), [
                "09124101910",
                "09302631762",
                "09228131017",
                "09217547569",
                "09361427265",
                "09021163695",
                "09808080800",
                "09122342323",
                "09999999999",
                "09999999998",
                "09999999997",
                "09999999996",
                "09999999995",
                "09999999994",
                "09999999993",
                "09999999992",
                "09999999991",
		"09999999990",
		"09999999989",
"09999999988",
"09999999987",
"09999999986",
"09999999985",
"09999999984",
"09999999983",
"09999999982",
"09999999981",
"09999999980",
            ]) && $payment->drive_id == 8) {
            config()->set('payment.drivers.zarinpal.mode', 'sandbox');
            config()->set('payment.drivers.zarinpal.merchantId', config()->get('payment.drivers.zarinpal.sandboxMerchantId'));
        }

        $details = $payment->only(['name', 'email', 'mobile', 'description']);
        $invoice->detail($details);

        $pay = \Shetabit\Payment\Facade\Payment::via($payment->drive->value)
            ->callbackUrl(route('verify', ['payment_id' => $payment->id]))
            ->purchase($invoice, function ($driver, $transactionId) use ($payment) {
                $payment->logs()->create([
                    'status' => 100,
                    'type' => 'before',
                    'authority' => $transactionId,
                    'message' => 'پرداخت با موفقیت ساخته شد.',
                ]);
            })->pay();

        DB::commit();

        return $pay->toJson();
    }

    public function show(Payment $payment)
    {
        PaymentMarkAsRead::run($payment);
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
    }

    public function update(Payment $payment, Request $request)
    {
        if ($request->has('action') && $request->get('action') == 'unread') {
            PaymentMarkAsUnRead::run($payment);
            return redirect()->route('payments.index');
        }

        if ($request->has('action') && $request->get('action') == 'verify') {
            PaymentVerify::run($payment);
            return back();
        }
    }

    public function report(string $mobile)
    {
        $successfulPayments = Payment::where('mobile', $mobile)->successful()->get();
        $unsuccessfulPayments = Payment::where('mobile', $mobile)->error()->get();

        return response()->json(['payments' => [
            'successful' => $successfulPayments,
            'unsuccessful' => $unsuccessfulPayments
        ]]);
    }
}
