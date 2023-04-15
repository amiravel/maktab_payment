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
use Shetabit\Multipay\Invoice;
use Illuminate\Support\Facades\Log;
use Exception;

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
        try {
            Log::channel('payment')->info('Log payment data', $request->only(['user_id', 'name', 'email', 'mobile', 'description', 'amount', 'callback', 'extra_callback', 'information']));
        } catch (Exception $e) {
            //
        }
        if ($request->has('tags')) {
            $payment->tags()->sync($request->get('tags'));
            try {
                Log::channel('payment')->info('sync tags', $request->only(['tags']));
            } catch (Exception $e) {
                //
            }
        }

        $cycle = GetActiveCycle::run();
        $payment->cycles()->sync($cycle->id);
        $payment->drive_id = $request->has('fake') ? 8 : Drive::whereValue($cycle->drive)->first()->id;
        $payment->save();

        $invoice = new Invoice();
        $invoice->amount(($payment->drive->value == 'vandar' || $payment->drive->value == 'pasargad') ? ($payment->amount * 10) : $payment->amount);
        try {
            Log::channel('payment')->info('invoice ', ['drive' => $payment->drive->value, 'amount' => $payment->amount]);
        } catch (Exception $e) {
            //
        }


        $details = $payment->only(['name', 'email', 'mobile', 'description']);
        $invoice->detail($details);
        try {
            Log::channel('payment')->info('details ', [$payment->only(['name', 'email', 'mobile', 'description'])]);
        } catch (Exception $e) {
            //
        }

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
}
