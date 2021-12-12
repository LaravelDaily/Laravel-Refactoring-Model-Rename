@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.reservation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reservations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.reservation.fields.id') }}
                        </th>
                        <td>
                            {{ $reservation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reservation.fields.user') }}
                        </th>
                        <td>
                            {{ $reservation->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reservation.fields.details') }}
                        </th>
                        <td>
                            {{ $reservation->details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.reservation.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Reservation::STATUS_SELECT[$reservation->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.reservations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection