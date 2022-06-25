<?php
    /** @var \App\Filament\Resources\ExerciseResource\Pages\EditExercise $this */
?>

<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <input type="text"
            {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
        >
        <h1> {{$getState()}} </h1>
    </div>
</x-forms::field-wrapper>
