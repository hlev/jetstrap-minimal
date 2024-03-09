<x-form-section submit="updateTeamName">
    <x-slot name="title">
        {{ __('Team Name') }}
    </x-slot>

    <x-slot name="description">
        {{ __('The team\'s name and owner information.') }}
    </x-slot>

    <x-slot name="form">
        <x-action-message on="saved">
            {{ __('Saved.') }}
        </x-action-message>

        <!-- Team Owner Information -->
        <div class="mb-4">
            <x-label value="{{ __('Team Owner') }}" />

            <div class="d-flex mt-2">
                <img class="rounded-circle me-2" width="48" src="{{ $team->owner->profile_photo_url }}">
                <div>
                    <div>{{ $team->owner->name }}</div>
                    <div class="text-muted">{{ $team->owner->email }}</div>
                </div>
            </div>
        </div>

        <!-- Team Name -->
        <div class="w-md-75">
            <div class="form-group">
                <x-label for="name" value="{{ __('Team Name') }}" />

                <x-input id="name"
                             type="text"
                             class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                             wire:model.defer="state.name"
                             :disabled="! Gate::check('update', $team)" />

                <x-input-error for="name" />
            </div>
        </div>
    </x-slot>

    @if (Gate::check('update', $team))
        <x-slot name="actions">
			<div class="d-flex align-items-baseline">
				<x-button>
                    <div wire:loading class="spinner-border spinner-border-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    
					{{ __('Save') }}
				</x-button>
			</div>
        </x-slot>
    @endif
</x-form-section>