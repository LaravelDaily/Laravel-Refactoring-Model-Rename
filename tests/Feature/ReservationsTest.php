<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ReservationsTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');

        $this->user = User::first(); // admin
        $this->actingAs($this->user);
    }

    public function testReservationsIndex()
    {
        $response = $this->get('/admin/reservations');

        $response->assertStatus(200);
    }

    public function testReservationsCreate()
    {
        $response = $this->get('/admin/reservations/create');

        $response->assertStatus(200);
    }

    public function testReservationsStoreAndEdit()
    {
        $reservation = [
            'user_id' => $this->user->id,
            'details' => 'Some details',
            'status' => 'accepted'
        ];
        $response = $this->post('/admin/reservations', $reservation);

        $response->assertRedirect('/admin/reservations');
        $this->assertDatabaseHas('reservations', $reservation);

        $response = $this->get('/admin/reservations/1/edit');
        $response->assertStatus(200);
    }

    public function testReservationsUpdate()
    {
        $reservation = Reservation::factory()->create();

        $updatedReservation = [
            'user_id' => $this->user->id,
            'details' => 'Some details',
            'status' => 'cancelled'
        ];
        $response = $this->put('/admin/reservations/' . $reservation->id, $updatedReservation);

        $response->assertRedirect('/admin/reservations');
        $this->assertDatabaseHas('reservations', $updatedReservation);

        $response = $this->get('/admin/reservations/'.$reservation->id.'/edit');
        $response->assertStatus(200);
    }

    public function testReservationsDelete()
    {
        $reservation = Reservation::factory()->create();
        $this->delete('/admin/reservations/' . $reservation->id);

        $reservation = Reservation::withTrashed()->find($reservation->id);
        $this->assertNotNull($reservation->deleted_at);

        $response = $this->get('/admin/reservations/'.$reservation->id.'/edit');
        $response->assertStatus(404);
    }
}
