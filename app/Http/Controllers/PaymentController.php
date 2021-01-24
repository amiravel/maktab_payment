<?php

namespace App\Http\Controllers;

use App\Actions\Payment\PaymentMarkAsRead;
use App\Http\Requests\CreatePaymentRequest;
use App\Models\Payment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'user_id', 'name', 'email', 'mobile', 'description', 'amount', 'callback', 'information'
        ]));

        if ($request->has('tags')) {
            $payment->tags()->sync($request->get('tags'));
        }

        if (!in_array($payment->drive->value, ['pasargad', 'zarinpal'])) {
            DB::rollBack();
            return back()
                ->with('message', 'درگاه پرداخت وارد شده معتبر نیست.');
        }

        $invoice = new Invoice();
        $invoice->amount(($payment->drive->value == 'pasargad') ? ($payment->amount * 10) : $payment->amount);
        $invoice->detail($payment->only(['name', 'email', 'mobile', 'description']));

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

    }
}
