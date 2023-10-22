<div class="mb-4">
    <select
        class="block appearance-none w-full rounded text-red-700 leading-tight focus:outline-none focus:shadow-outline selectize"
        id="{{ $name }}"
        name="{{ $name }}"
        model="{{ $model }}"
        required
    >
        <option value="" selected>All {{ strtolower($label) }}s </option>
    </select>
</div>