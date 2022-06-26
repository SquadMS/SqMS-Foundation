@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'sqmsf-border-gray-300 focus:sqmsf-border-indigo-300 focus:sqmsf-ring focus:sqmsf-ring-indigo-200 focus:sqmsf-ring-opacity-50 sqmsf-rounded-md sqmsf-shadow-sm']) !!}>