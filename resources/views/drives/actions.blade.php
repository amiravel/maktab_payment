<div class="p-2">
    <a class="btn btn--primary" href="{{ route('drives.edit', $id) }}">{{ __('Edit') }}</a>
    <a class="btn btn--danger" wire:click="delete({{ $id }})">{{ __('Delete') }}</a>
</div>
