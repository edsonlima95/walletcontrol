@extends('admin.layout')

@section('content')

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Fixas</h1>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Espelho das parcelas fixas
                </div>
                <div class="card-body">
                    <table class="table table-striped table-borderless" id="data-table">
                        <thead>
                        <tr>
                            <th scope="col">Descrição</th>
                            <th scope="col">Lançamento</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Dia do Vencimento</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($fixes))
                            @foreach($fixes as $fixed)
                                <tr>
                                    <td>{{$fixed->description}}</td>
                                    <td>{{$fixed->type == 'fixed_expense' ? 'Despesa' : 'Receita'}}</td>
                                    <td>Fixa</td>
                                    <td>{{$fixed->category()->first()->name}}</td>
                                    <td>Todo dia {{date('d',strtotime($fixed->due_at))}}</td>
                                    <td>R$ {{$fixed->value}}</td>
                                    <td>
                                        <i class="fas fa-thumbs-up mr-3"></i>
                                        <a href="{{route('control.invoiceEdit',['id'=>$fixed])}}"><i
                                                class="fas fa-edit"></i></a>
                                    </td>
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
