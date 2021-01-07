@extends('layouts.app')

@section('content')
    <div class="p-relative py-2 px-3 d-flex align-items-center justify-content-start bg-light rounded mb-4">
        <a href="{{ route('payments.show', ['id' => $payment->id]) }}" class="btn btn-sm btn-dark mr-2">
            <i class="fas fa-chevron-left"></i>
        </a>

        <p class="m-0 font-bold">{{ __('Edit') }} {{ __('Payment #') . $payment->id }}</p>
    </div>

    <form action="{{ route('payments.update', ['id' => $payment->id]) }}" method="post">
        <input type="hidden" name="_method" value="PATCH">

        <fieldset>
            <legend>{{ __('Information') }}</legend>
            <div class="form-group">
                <label for="name">{{ __('Name') }} *</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ $payment->name }}">
            </div>

            <div class="form-group form-row">
                <div class="col-md">
                    <label for="email">{{ __('Email') }}</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $payment->email }}">
                </div>
                <div class="col-md">
                    <label for="mobile">{{ __('Mobile') }}</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{ $payment->mobile }}">
                </div>
            </div>

            <div class="form-group">
                <label for="description">{{ __('Description') }} *</label>
                <textarea name="description" id="description" class="form-control" rows="4"
                          required>{{ $payment->description }}</textarea>
            </div>
        </fieldset>

        <fieldset>
            <legend>{{ __('Tags') }}</legend>
            <div class="form-group form-row">
                @foreach($tags as $index => $parent)
                    <div class="col-md-6">
                        <label for="{{ $parent->id }}">{{ $parent->name }}</label>

                        <select name="tags[]" id="{{ $parent->id }}" class="custom-select">
                            <option value="" selected disabled hidden></option>
                            @foreach($parent->children as $jndex => $tag)
                                <option value="{{ $tag->id }}"
                                        @if(in_array($tag->id, $payment->tags->pluck('id')->toArray())) selected @endif>
                                    {{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </fieldset>

        <div class="form-group">
            <label for="amount">{{ __('Amount') }} *</label>
            <input type="number" min="5000" class="form-control" id="amount" aria-describedby="amountHelp" name="amount"
                   value="{{ $payment->amount }}" disabled>
            <small id="amountHelp" class="form-text text-muted">
                {{ __('Enter the amount in Tomans.') }}
            </small>
        </div>

        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
    </form>
@endsection
