@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="/css/index.css">
@endpush

@section('content')
    <div class="p-6">

        <h1 class="text-2xl mb-4">Histórico de Atendimentos</h1>
        
        <div class="flex justify-between items-center mb-4">

        <div class="flex items-center">
                <input
                    type="text"
                    id="searchInput"
                    onkeyup="searchTable()"
                    placeholder="Pesquisar"
                    class="px-4 py-2 border border-gray-100 rounded-lg mr-2"
                />

            </div>

        </div>
        @include('components.table', [
            'header' => ['ID', 'Serviço', 'Funcionário', 'Cliente', 'Pet', 'Horário Atendimento', 'Horário Conclusão', 'Status'],
            'content' => $appointments->map(function($appointment) {

                $appointmentStatusTranslations = [
                    'Pending' => 'Pendente',
                    'Completed' => 'Concluído',
                    'Canceled' => 'Cancelado',
                ];

                return [
                    $appointment->id, 
                    $appointment->service->name,
                    $appointment->employee->user->name,
                    $appointment->customer->user->name,
                    $appointment->pet->name,
                    $appointment->start_time,
                    $appointment->end_time,
                    $appointmentStatusTranslations[$appointment->status] ?? $appointment->status,
                ];
            }),
            'editRoute' => 'appointments.edit',
            'deleteRoute' => 'appointments.destroy',
        ])
    </div>


@endsection

