@php
    use Carbon\Carbon;
@endphp
<div class="container" wire:init="loadData">
    <div>
        <div class="container-table">
            <div class="titulo">
                {{ __('invoices.tutorials') }}
            </div>
            <div class="table-wrapper">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>{{ __('booking.start_date') }}</th>
                            <th>{{ __('booking.end_date') }}</th>
                            @role('tutor')
                            <th>{{ __('booking.student_name') }}</th>
                            <th>{{__('booking.status') }} </th>
                            @elserole('student')
                            <th>{{ __('booking.tutor_name') }}</th>
                            <th>{{__('booking.status') }} </th>
                            <th data-translate="invoices_claims">
                                Reclamos
                            </th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @if (!$tutorias->isEmpty())
                            {{-- @php
                            dd($tutorias)
                            @endphp --}}
                            @foreach($tutorias as $order)
                                <tr class="table-row">
                                    <td><span class="table-cell-content">{{ $order?->start_time }}</span></td>
                                    <td><span class="table-cell-content">{{ $order?->end_time }}</span></td>
                                    @role('student')
                                    <td>
                                        <span class="table-cell-content">
                                            {{$order->tutor->first_name }} - {{$order->tutor->last_name}}
                                        </span>
                                    </td>
                            @elserole('tutor')




                                        <td>
                                            <span class="table-cell-content">
                                                @if($order->booker && $order->booker->profile)
                                                    {{ $order->booker->profile->first_name }} - {{ $order->booker->profile->last_name }}
                                                @endif
                                            </span>
                                        </td>



                                        @endrole
                                        <td>
                                            @php
                                                $statusValue = trim((string) ($order['status'] ?? $order->status ?? ''));
                                                $statusKey = mb_strtolower($statusValue, 'UTF-8');

                                                $statusMap = [
                                                    'aceptado' => [
                                                        'text' => __('material-support.accepted'),
                                                        'class' => 'status-accepted',
                                                        'translate' => 'material_support_status_accepted',
                                                    ],
                                                    'accepted' => [
                                                        'text' => __('material-support.accepted'),
                                                        'class' => 'status-accepted',
                                                        'translate' => 'material_support_status_accepted',
                                                    ],

                                                    'pendiente' => [
                                                        'text' => __('material-support.pending'),
                                                        'class' => 'status-pending',
                                                        'translate' => 'material_support_status_pending',
                                                    ],
                                                    'pending' => [
                                                        'text' => __('material-support.pending'),
                                                        'class' => 'status-pending',
                                                        'translate' => 'material_support_status_pending',
                                                    ],

                                                    'no completado' => [
                                                        'text' => __('material-support.not_completed'),
                                                        'class' => 'status-incomplete',
                                                        'translate' => 'material_support_status_not_completed',
                                                    ],
                                                    'not completed' => [
                                                        'text' => __('material-support.not_completed'),
                                                        'class' => 'status-incomplete',
                                                        'translate' => 'material_support_status_not_completed',
                                                    ],
                                                    'not_completed' => [
                                                        'text' => __('material-support.not_completed'),
                                                        'class' => 'status-incomplete',
                                                        'translate' => 'material_support_status_not_completed',
                                                    ],

                                                    'rechazado' => [
                                                        'text' => __('invoices.status_rejected'),
                                                        'class' => 'status-rejected',
                                                        'translate' => 'invoices_status_rejected',
                                                    ],
                                                    'rejected' => [
                                                        'text' => __('invoices.status_rejected'),
                                                        'class' => 'status-rejected',
                                                        'translate' => 'invoices_status_rejected',
                                                    ],

                                                    'completado' => [
                                                        'text' => __('material-support.completed'),
                                                        'class' => 'status-completed',
                                                        'translate' => 'material_support_status_completed',
                                                    ],
                                                    'completed' => [
                                                        'text' => __('material-support.completed'),
                                                        'class' => 'status-completed',
                                                        'translate' => 'material_support_status_completed',
                                                    ],
                                                ];

                                                $currentStatus = $statusMap[$statusKey] ?? [
                                                    'text' => ucfirst($statusValue),
                                                    'class' => 'status-default',
                                                    'translate' => null,
                                                ];
                                            @endphp

                                            <span
                                                class="status-badge {{ $currentStatus['class'] }}"
                                                @if($currentStatus['translate']) data-translate="{{ $currentStatus['translate'] }}" @endif>
                                                {{ $currentStatus['text'] }}
                                            </span>
                                        </td>
                                        @role('student')
                                        <td>
                                            @php
                                                $yaReclamo = $order->claims && $order->claims->count() > 0;
                                                $pasada_hora = now()->greaterThan(Carbon::parse($order->end_time)->addMinutes(2));
                                            @endphp
                                            @if($order->status == "Aceptado" && !$pasada_hora && !$yaReclamo)
                                                <button class="claim-btn-action btn-warning"
                                                    wire:click="openClaimModal({{ $order->id }})">
                                                    <span data-translate="invoices_claim_action">
                                                        Reclamar
                                                    </span>
                                                </button>
                                            @elseif($yaReclamo)
                                                <span class="claim-status-sent" data-translate="invoices_claim_sent">
                                                    Reclamo enviado
                                                </span>
                                            @else
                                                <span class="claim-status-expired" data-translate="invoices_claim_expired">
                                                    Fuera de Tiempo Para hacer Reclamo
                                                </span>
                                            @endif
                                        </td>
                                        @endrole
                                    </tr>
                                @endforeach
                        @endif
                    </tbody>
                </table>


            </div>

            <div class="pagination-wrapper">
                {{ $tutorias->links('livewire::simple-bootstrap') }}
            </div>

            @if($showClaimModal)
                @include('livewire.pages.admin.invoices.components.modal')
            @endif

        </div>





    </div>



    @push('scripts')
        <script type="text/javascript" data-navigate-once>
            var component = '';
            document.addEventListener('livewire:navigated', function () {
                component = @this;
            }, { once: true });
            document.addEventListener('loadPageJs', (event) => {
                component.dispatch('initSelect2', { target: '.am-select2' });
            })
        </script>
    @endpush

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/estilos/variables.css') }}">
        <link rel="stylesheet" href="{{ asset('css/livewire/pages/invoices/invoices.css') }}">
        <link rel="stylesheet" href="{{ asset('css/livewire/pages/invoices/components/modal.css') }}">
    @endpush



    @push('styles')
        <style>
            /* Paginación */
            .pagination-wrapper {
                margin-top: 18px;
                text-align: center;
            }

            .pagination {
                display: inline-flex;
                gap: 4px;
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .pagination li {
                display: inline;
            }

            .pagination .active span,
            .pagination li a {
                padding: 6px 12px;
                border-radius: 6px;
                background: #f7f7f7;
                color: #333;
                text-decoration: none;
                font-weight: 500;
                transition: background 0.2s;
            }

            .pagination .active span {
                background: #e38705ff;
                color: #fff;
            }

            .pagination li a:hover {
                background: #e3f2fd;
                color: #1976d2;
            }

            .pagination .disabled span {
                background: #eee;
                color: #aaa;
                cursor: not-allowed;
            }


            .page-link {
                background: #FB8500;
                color:white;
            }

            .page-link:hover  {
                background: #e57b02ff !important;
                color: white;
            }
        </style>


    @endpush