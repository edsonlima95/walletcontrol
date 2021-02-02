@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i class="fa fa-list-alt mr-2"></i>Lista
                        de {{$type  == 'expense' ? 'despesas' : 'receitas'}}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="btn btn-dark"
                                                       href="{{route('control.invoice',['type'=>$type])}}"><i
                                    class="fa fa-plus-circle mr-2"></i>Lançar</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{route('control.invoices',['type'=>$type])}}" method="post" class="col-lg-3 d-flex">
                        @csrf
                        <div class="form-group mr-4">
                            <lable>Data início</lable>
                            <input type="date" class="form-control" name="date1">
                        </div>
                        <div class="form-group">
                            <lable>Data fim</lable>
                            <input type="date" class="form-control" name="date2">
                        </div>
                        <div class="ml-2 form-group d-flex align-items-end">
                            <lable></lable>
                            <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-borderless" id="data-table">
                        <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>Vecimento</th>
                            <th>Categoria</th>
                            <th>Parcela</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th>Editar</th>
                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($invoices))
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{$invoice->description}}</td>
                                    <td>{{(date($invoice->due_at) == date('Y-m-d') ? 'Hoje' : date('d/m',strtotime($invoice->due_at)))}}</td>
                                    <td>{{$invoice->category()->first()->name}}</td>
                                    <td>{{$invoice->repeat_when == 'single' ? 'Unica' : ($invoice->repeat_when == 'fixed' ? 'Fixa' : "Parcelada em {$invoice->enrollments}x")}}</td>
                                    <td class="value" data-total="{{$invoice->value}}">R$ {{$invoice->value}}</td>

                                    <td class="text-center">
                                        <i data-id="{{$invoice->id}}" style="cursor: pointer"
                                           class="fas fa-thumbs-{{$invoice->status == 'unpaid' ? 'down red-status' : 'up'}} mr-3 paidunpaid"
                                           data-action="{{route('control.invoice-onpaid',['id'=>$invoice->id])}}">
                                        </i>
                                    </td>

                                    <td>
                                        <a style="color: black"
                                           href="{{route('control.invoiceEdit',['id'=>$invoice->id])}}">
                                            <i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <p class="font-weight-bold">Total: R$ {{number_format($total,2,',','.')}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('i.paidunpaid').on('click', function () {
                var action = $(this).data('action');
                var button = $(this);

                $.post(action, {}, function (response) {

                    if (response.status === 'paid') {
                        $(button).removeClass('fas fa-thumbs-down red-status').addClass('fas fa-thumbs-up');
                    } else if (response.status === 'unpaid') {
                        $(button).removeClass('fas fa-thumbs-up').addClass('fas fa-thumbs-down red-status');
                    }
                }, 'json');
            })
        })
    </script>
@endsection
