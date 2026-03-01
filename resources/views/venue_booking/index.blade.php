@extends('layouts.app')
@section('title', 'Booking Venue')

@section('content')
<section class="content-header">
    <h1>Booking Venue
        <small>Kelola booking venue & event</small>
    </h1>
</section>

<section class="content">
    @component('components.widget', ['class' => 'box-primary'])
        @slot('tool')
            <div class="box-tools">
                @can('venue_booking.create')
                <a class="btn btn-block btn-primary" href="{{ action('VenueBookingController@create') }}">
                    <i class="fa fa-plus"></i> Tambah Booking
                </a>
                @endcan
            </div>
        @endslot

        {{-- Filter --}}
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Venue:</label>
                    {!! Form::select('filter_venue', $venues, null, ['class' => 'form-control select2', 'id' => 'filter_venue', 'placeholder' => 'Semua Venue']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Status:</label>
                    {!! Form::select('filter_status', [
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ], null, ['class' => 'form-control select2', 'id' => 'filter_status', 'placeholder' => 'Semua Status']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Dari Tanggal:</label>
                    {!! Form::date('filter_start_date', null, ['class' => 'form-control', 'id' => 'filter_start_date']) !!}
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label>Sampai Tanggal:</label>
                    {!! Form::date('filter_end_date', null, ['class' => 'form-control', 'id' => 'filter_end_date']) !!}
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="venue_booking_table">
                <thead>
                    <tr>
                        <th>Ref</th>
                        <th>Venue</th>
                        <th>Tamu</th>
                        <th>Event</th>
                        <th>Tgl Event</th>
                        <th>Est. Tamu</th>
                        <th>Total</th>
                        <th>DP</th>
                        <th>Sisa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endcomponent
</section>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        var venue_booking_table = $('#venue_booking_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ action("VenueBookingController@index") }}',
                data: function(d) {
                    d.venue_id = $('#filter_venue').val();
                    d.status = $('#filter_status').val();
                    d.start_date = $('#filter_start_date').val();
                    d.end_date = $('#filter_end_date').val();
                }
            },
            columns: [
                { data: 'booking_ref', name: 'booking_ref' },
                { data: 'venue_name', name: 'venues.name' },
                { data: 'guest_name', name: 'guest_name' },
                { data: 'event_name', name: 'event_name' },
                { data: 'event_date', name: 'event_date' },
                { data: 'estimated_guests', name: 'estimated_guests' },
                { data: 'total_amount', name: 'total_amount' },
                { data: 'dp_amount', name: 'dp_amount' },
                { data: 'remaining_amount', name: 'remaining_amount' },
                { data: 'status_label', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
            order: [[4, 'desc']],
        });

        // Filter change handlers
        $('#filter_venue, #filter_status, #filter_start_date, #filter_end_date').on('change', function() {
            venue_booking_table.ajax.reload();
        });

        // Delete booking
        $(document).on('click', '.delete-booking', function(e) {
            e.preventDefault();
            swal({
                title: LANG.sure,
                text: 'Booking akan dihapus permanen!',
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    var href = $(this).data('href');
                    $.ajax({
                        method: "DELETE",
                        url: href,
                        dataType: "json",
                        success: function(result) {
                            if (result.success) {
                                toastr.success(result.msg);
                                venue_booking_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
