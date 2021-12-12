<?php

namespace App\Http\Requests;

use App\Models\Reservation;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReservationRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reservation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reservations,id',
        ];
    }
}
