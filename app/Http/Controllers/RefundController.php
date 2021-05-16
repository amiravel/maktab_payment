<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRefundRequest;
use App\Models\Payment;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('refunds.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('refunds.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRefundRequest $request)
    {
        $validated = $request->validated();

        $refund = Refund::create($validated);

        return response()
            ->json([
                "status" => "ثبت موفقیت‌آمیز",
                "message" => "درخواست عودت وجه شما با موفقیت ثبت گردید.",
                "date" => $refund
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function show(Refund $refund)
    {
        $payments = Payment::query()
            ->whereHas('logs', function ($query) use ($refund) {
                $query->where('refID', $refund->refID);
            })->get();

        return view('refunds.show', compact('refund', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function edit(Refund $refund)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Refund $refund)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Refund $refund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Refund $refund)
    {
        //
    }
}
