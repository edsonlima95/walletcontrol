@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i
                            class="fa fa-plus-circle mr-2"></i> Edição de carteira
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a class="btn btn-dark"
                                                       href="{{route('control.wallets.index')}}"><i
                                    class="fa fa-list-alt mr-2"></i> Listar</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row justify-content-center">
        <div class="col-lg-7">
            {{-- Exibe os erros de validação--}}
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alart alert-danger p-3 my-4" style="border-radius: 5px" role="alert">
                        {{$error}}
                    </div>
                @endforeach
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{route('control.wallets.update',['wallet'=>$wallet->id])}}" method="post" class="invoice-form">
                        @csrf
                        @method('put')
                        {{--Colocar o usuario logado aqui--}}
                        <input type="hidden" name="user_id" value="{{\Illuminate\Support\Facades\Auth::user()->id}}">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="name" value="{{old('name') ?? $wallet->name}}" class="form-control" id="name">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <input type="text" name="description" value="{{old('description') ?? $wallet->description}}" class="form-control" id="description">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-center">
                            <button type="submit" class="btn bg-dark col-6"><i class="fa fa-edit mr-2"></i>Atualizar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
