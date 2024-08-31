<?php

use App\Models\Appointment;
use App\Models\Employee;
use App\Models\Customer;
use App\Models\Pet;
use App\Models\Service;

test('list of appointments is displayed', function () {
    $employee = Employee::factory()->create();
    $appointments = Appointment::factory()->for($employee)->count(3)->create();

    $response = $this->actingAs($employee->user, 'web')
        ->get(route('appointments.index'));

    foreach ($appointments as $appointment) {
        $this->assertDatabaseHas('appointments', [
            'employee_id' => $employee->id,
            'customer_id' => $appointment->customer->id,
            'pet_id' => $appointment->pet->id,
            'service_id' => $appointment->service->id,
            'status' => $appointment->status,
            'start_time' => $appointment->start_time,
            'end_time' => $appointment->end_time
        ]);
    }
    $response->assertStatus(200);
});

test('list of appointments is empty when no appointments have been created', function () {
    $employee = Employee::factory()->create();
    $this->actingAs($employee->user, 'web')
        ->get(route('appointments.index'));

    $this->assertDatabaseCount('appointments', 0);
});

test('employee can update existing appointment info', function () {
    $employee = Employee::factory()->create();
    $appointment = Appointment::factory()->for($employee)->create();

    $dataToUpdate = [
        'pet_id' => $appointment->pet->id, 
        'customer_id' => $appointment->customer->id,
        'service_id' => $appointment->service->id,
        'status' => 'pending',
        'start_time' => '2024-08-30 03:54:01',
        'end_time' => null, 
    ];

    $response = $this
        ->actingAs($employee->user, 'web')
        ->put(route('appointments.update', compact('appointment')), $dataToUpdate);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('appointments.index'))
        ->assertSessionHas('success', 'Registro de atendimento atualizado com sucesso.');

        $this->assertDatabaseHas('appointments', $dataToUpdate);
});

test('employee cannot update non-existing appointment info', function () {
    $employee = Employee::factory()->create();
    $appointment = Appointment::factory()->for($employee)->create();

    $response = $this->actingAs($employee->user, 'web')
        ->put('/appointments/33',[
            'pet_id' => $appointment->pet->id, 
            'customer_id' => $appointment->customer->id,
            'service_id' => $appointment->service->id,
            'status' => 'pending',
            'start_time' => '2024-08-30 03:54:01',
            'end_time' => null, 
        ]);

    $response
        ->assertStatus(404);
});

test('employee cannot add an appointment w/ invalid info', function () {
    $employee = Employee::factory()->create();
    $appointment = Appointment::factory()->for($employee)->create();

    $dataToUpdate = [
        'pet_id' =>  '1', 
        'customer_id' => $appointment->customer->id,
        'service_id' => $appointment->service->id,
        'status' => 'nada', 
        'start_time' => '2024 03:54:01', 
        'end_time' => null, 
    ];
    
    $response = $this
        ->actingAs($employee->user, 'web')
        ->put(route('appointments.update', compact('appointment')), $dataToUpdate);
    
    $response->assertInvalid(['pet_id' => 'O campo de pet deve ser preenchido por um id válido.']);
    $response->assertInvalid(['status' => 'O status do atendimento deve ser "pendente", "concluído" ou "cancelado".']);
    $response->assertInvalid(['start_time' => 'O horário para o atendimento deve ter o formato Y-m-d H:i:s.']);
});

test('employee can destroy existing appointment', function () {
    $employee = Employee::factory()->create();
    $appointment = Appointment::factory()->for($employee)->create();

    $response = $this->actingAs($employee->user, 'web')
        ->delete('/appointments/'.$appointment->id);

    $createdAppointment = appointment::find($appointment->id);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('appointments.index'))
        ->assertSessionHas('success', 'Registro de atendimento removido com sucesso.');

    $this->assertEquals(null, $createdAppointment);
    $this->assertDatabaseMissing('appointments', [
        'id' => $appointment->id,
    ]);
});

test('employee cannot destroy non-existing appointment', function () {
    $employee = Employee::factory()->create();
    $response = $this->actingAs($employee->user, 'web')
        ->delete('/appointments/33');
    $response->assertStatus(500);
});

test('employee can create a new appointment', function () {
    $employee = Employee::factory()->create();
    $service = Service::factory()->create();
    $pet = Pet::factory()->create();
    $customer = Customer::factory()->create();

    $data = [
        'employee_id' => $employee->id,
        'pet_id' => $pet->id, 
        'customer_id' => $customer->id,
        'service_id' => $service->id,
        'status' => 'pending',
        'start_time' => '2024-08-30 03:54:01',
        'end_time' => null, 
    ];

    $response = $this
        ->actingAs($employee->user, 'web')
        ->post(route('appointments.store'), $data);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('appointments.index'))
        ->assertSessionHas('success', 'Registro de atendimento criado com sucesso.');

        $this->assertDatabaseHas('appointments', $data);
});

test('employee cannot create appointment w/ invalid info', function () {
    $employee = Employee::factory()->create();
    $service = Service::factory()->create();
    $pet = Pet::factory()->create();

    $data = [
        'employee_id' => $employee->id,
        'pet_id' => $pet->id, 
        'customer_id' => '2',
        'service_id' => $service->id,
        'status' => 'nada',
        'start_time' => null,
        'end_time' => null, 
    ];

    $response = $this
        ->actingAs($employee->user, 'web')
        ->post(route('appointments.store'), $data);

        $response->assertInvalid(['customer_id' => 'O campo de cliente deve ser preenchido por um id válido.']);
        $response->assertInvalid(['status' => 'O status do atendimento deve ser "pendente", "concluído" ou "cancelado".']);
        $response->assertInvalid(['start_time' => 'O campo de horário do atendimento é obrigatório.']);

        $this->assertDatabaseMissing('appointments', [
            'employee_id' => $employee->id,
            'pet_id' => $pet->id,
            'service_id' => $service->id,
        ]);
});