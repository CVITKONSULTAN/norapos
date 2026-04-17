@extends('layouts.app')
@section('title', 'Bahan Baku Booking Venue')

@section('content')
<section class="content-header">
    <h1>Bahan Baku Event
        <small>{{ $booking->booking_ref }}</small>
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-4">
            @component('components.widget', ['class' => 'box-primary', 'title' => 'Info Booking'])
                <table class="table table-condensed">
                    <tr>
                        <td><strong>Ref</strong></td>
                        <td>{{ $booking->booking_ref }}</td>
                    </tr>
                    <tr>
                        <td><strong>Venue</strong></td>
                        <td>{{ $booking->venue->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Event</strong></td>
                        <td>{{ $booking->event_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tanggal</strong></td>
                        <td>{{ $booking->event_date ? $booking->event_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tamu</strong></td>
                        <td>{{ $booking->guest_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Est. Tamu</strong></td>
                        <td>{{ $booking->estimated_guests }}</td>
                    </tr>
                </table>
            @endcomponent
        </div>
        <div class="col-sm-8">
            @component('components.widget', ['class' => 'box-success', 'title' => 'Input Bahan Baku yang Digunakan'])
                <p class="text-muted"><small><i class="fa fa-info-circle"></i> Isi estimasi bahan baku untuk event ini. Data ini membantu tim purchasing menyiapkan kebutuhan sebelum acara.</small></p>

                {!! Form::open(['url' => action('VenueBookingController@saveIngredients', [$booking->id]), 'method' => 'post', 'id' => 'venue_booking_ingredients_form']) !!}
                <div class="table-responsive">
                    <table class="table table-bordered" id="ingredients_table">
                        <thead>
                            <tr>
                                <th style="width: 35%;">Bahan Baku</th>
                                <th style="width: 15%;">Qty Estimasi</th>
                                <th style="width: 15%;">Satuan</th>
                                <th>Catatan</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody id="ingredients_body">
                            @forelse($booking->ingredientUsages as $index => $usage)
                                <tr class="ingredient-row">
                                    <td>
                                        <select name="ingredients[{{ $index }}][ingredient_id]" class="form-control ingredient-select select2" required>
                                            <option value="">Pilih bahan baku</option>
                                            @foreach($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}"
                                                    data-unit-name="{{ $ingredient->unit->short_name ?? $ingredient->unit->actual_name ?? '-' }}"
                                                    data-unit-id="{{ $ingredient->unit_id ?? '' }}"
                                                    {{ (int) $usage->ingredient_id === (int) $ingredient->id ? 'selected' : '' }}>
                                                    {{ $ingredient->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="ingredients[{{ $index }}][qty]" class="form-control" min="0" step="0.01" value="{{ (float) $usage->qty }}" required>
                                    </td>
                                    <td>
                                        <span class="ingredient-unit-label">{{ $usage->unit->short_name ?? $usage->unit->actual_name ?? $usage->ingredient->unit->short_name ?? $usage->ingredient->unit->actual_name ?? '-' }}</span>
                                        <input type="hidden" name="ingredients[{{ $index }}][unit_id]" class="ingredient-unit-id" value="{{ $usage->unit_id ?? $usage->ingredient->unit_id ?? '' }}">
                                    </td>
                                    <td>
                                        <input type="text" name="ingredients[{{ $index }}][note]" class="form-control" value="{{ $usage->note }}" placeholder="Catatan tambahan (opsional)">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs remove-ingredient-row"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="ingredient-row">
                                    <td>
                                        <select name="ingredients[0][ingredient_id]" class="form-control ingredient-select select2" required>
                                            <option value="">Pilih bahan baku</option>
                                            @foreach($ingredients as $ingredient)
                                                <option value="{{ $ingredient->id }}"
                                                    data-unit-name="{{ $ingredient->unit->short_name ?? $ingredient->unit->actual_name ?? '-' }}"
                                                    data-unit-id="{{ $ingredient->unit_id ?? '' }}">
                                                    {{ $ingredient->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="ingredients[0][qty]" class="form-control" min="0" step="0.01" value="1" required>
                                    </td>
                                    <td>
                                        <span class="ingredient-unit-label">-</span>
                                        <input type="hidden" name="ingredients[0][unit_id]" class="ingredient-unit-id" value="">
                                    </td>
                                    <td>
                                        <input type="text" name="ingredients[0][note]" class="form-control" placeholder="Catatan tambahan (opsional)">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs remove-ingredient-row"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <button type="button" class="btn btn-success btn-sm" id="add_ingredient_row">
                                        <i class="fa fa-plus"></i> Tambah Bahan Baku
                                    </button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-right">
                    <a href="{{ action('VenueBookingController@show', [$booking->id]) }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> Kembali ke Detail
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-save"></i> Simpan Bahan Baku
                    </button>
                </div>
                {!! Form::close() !!}
            @endcomponent
        </div>
    </div>
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var ingredientIndex = {{ $booking->ingredientUsages->count() ?: 1 }};

        function refreshSelect2(scope) {
            scope.find('.select2').select2({
                width: '100%'
            });
        }

        function updateIngredientUnit(row) {
            var selected = row.find('.ingredient-select option:selected');
            row.find('.ingredient-unit-label').text(selected.data('unit-name') || '-');
            row.find('.ingredient-unit-id').val(selected.data('unit-id') || '');
        }

        $('#add_ingredient_row').on('click', function() {
            var row = `<tr class="ingredient-row">
                <td>
                    <select name="ingredients[${ingredientIndex}][ingredient_id]" class="form-control ingredient-select select2" required>
                        <option value="">Pilih bahan baku</option>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->id }}"
                                data-unit-name="{{ $ingredient->unit->short_name ?? $ingredient->unit->actual_name ?? '-' }}"
                                data-unit-id="{{ $ingredient->unit_id ?? '' }}">
                                {{ $ingredient->name }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td><input type="number" name="ingredients[${ingredientIndex}][qty]" class="form-control" min="0" step="0.01" value="1" required></td>
                <td>
                    <span class="ingredient-unit-label">-</span>
                    <input type="hidden" name="ingredients[${ingredientIndex}][unit_id]" class="ingredient-unit-id" value="">
                </td>
                <td><input type="text" name="ingredients[${ingredientIndex}][note]" class="form-control" placeholder="Catatan tambahan (opsional)"></td>
                <td><button type="button" class="btn btn-danger btn-xs remove-ingredient-row"><i class="fa fa-times"></i></button></td>
            </tr>`;

            $('#ingredients_body').append(row);
            refreshSelect2($('#ingredients_body').find('tr:last'));
            ingredientIndex++;
        });

        $(document).on('change', '.ingredient-select', function() {
            updateIngredientUnit($(this).closest('tr'));
        });

        $(document).on('click', '.remove-ingredient-row', function() {
            if ($('#ingredients_body .ingredient-row').length === 1) {
                $(this).closest('tr').find('input[type="text"], input[type="number"]').val('');
                $(this).closest('tr').find('.ingredient-select').val('').trigger('change');
                return;
            }
            $(this).closest('tr').remove();
        });

        refreshSelect2($(document));
        $('#ingredients_body .ingredient-row').each(function() {
            updateIngredientUnit($(this));
        });
    });
</script>
@endsection
