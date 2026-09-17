<x-filament-panels::page>
    <form
        wire:submit="save"
        class="fi-form flex flex-col gap-y-6"
    >
        {{ $this->form }}

        <div class="fi-form-actions flex justify-end gap-3">
            <x-filament::button
                type="submit"
                color="primary"
                icon="heroicon-m-check"
            >
                Save changes
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
