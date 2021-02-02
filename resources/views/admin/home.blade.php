@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#"></a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Por Receber
                </div>
                <div class="card-body d-flex">
                    <div class="col-3">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                    <div class="col-9 text-right">
                        <p>Total</p>
                        <p>R$ {{number_format($incomeUnpaid,2,',','.')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    Por Pagar
                </div>
                <div class="card-body d-flex">
                    <div class="col-3">
                        <i class="fas fa-dollar-sign fa-2x"></i>
                    </div>
                    <div class="col-9 text-right">
                        <p>Total</p>
                        <p>R$ {{number_format($expenseUnpaid,2,',','.')}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    {{\App\Models\Wallet::where('id',session('wallet'))->first()->name}}
                </div>
                <div class="card-body d-flex">
                    <div class="col-3">
                        <i class="fa fa-wallet fa-2x"></i>
                    </div>
                    <div class="col-9 text-right">
                        <p>Saldo Total</p>
                        <p style="font-size: 25px" class="badge {{$total <= 0 ? 'badge-danger' : 'badge-success'}}">R$ {{number_format($total,2,',','.')}}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <p class="mb-2">Recebido: R$ {{number_format($income,2,',','.')}}</p>
                    <p class="m-0">Pago: R$ {{number_format($expense,2,',','.')}}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Por Receber
                </div>
                <div class="card-body">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Faltam</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($incomeDateUnpaid))
                            @foreach($incomeDateUnpaid as $incomeDate)
                                @php
                                    $date = (new DateTime(date('Y-m-d')));
                                    $date2 = (new \DateTime($incomeDate->due_at));
                                    $diff = $date->diff($date2);
                                @endphp
                                <tr>
                                    <td>{{date('d/m/Y', strtotime($incomeDate->due_at))}}</td>
                                    <td>{{$diff->days}} / dias</td>
                                    <td>R$ {{$incomeDate->value}}</td>
                                    <td>{{$incomeDate->status == 'unpaid' ? 'Pendente' : 'Pago'}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    Por Pagar
                </div>
                <div class="card-body">
                    <table class="table table-striped table-borderless">
                        <thead>
                        <tr>
                            <th scope="col">Data</th>
                            <th scope="col">Faltam</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($expenseDateUnpaid))
                            @foreach($expenseDateUnpaid as $expenseDate)
                                @php
                                    $date = (new DateTime(date('Y-m-d')));
                                    $date2 = (new \DateTime($expenseDate->due_at));
                                    $diff = $date->diff($date2);
                                @endphp
                                <tr>
                                    <td>{{date('d/m/Y', strtotime($expenseDate->due_at))}}</td>
                                    <td>{{$diff->days}} / dias</td>
                                    <td>R$ {{$expenseDate->value}}</td>
                                    <td>{{$expenseDate->status == 'unpaid' ? 'Pendente' : 'Pago'}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
