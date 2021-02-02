@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12 d-flex justify-content-center">
                    <a href="{{route('control.wallets.create')}}" class="btn btn-dark btn-lg col-lg-5"><i
                            class="fa fa-plus-circle mr-3"></i>Cadastrar</a>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <div class="d-flex justify-content-center">
        @if(session()->exists('message'))
            {!! session()->get('message') !!}
        @endif
    </div>

    <div class="row">
        @if(!empty($wallets))
            @foreach($wallets as $wallet)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <small class="badge bg-dark float-right"
                                   style="font-size: 0.6em">{{$wallet->signature == 'premium' ? 'premium' : 'free'}}</small>
                            {{$wallet->name}}
                        </div>
                        <div class="card-body d-flex">
                            <div class="col-3">
                                <i class="fa fa-wallet fa-2x"></i>
                            </div>
                            <div class="col-9 text-right">
                                <p>Saldo Total</p>
                                @php
                                    $total = number_format($wallet->income() - $wallet->expense());
                                @endphp
                                <p style="font-size: 25px"
                                   class="badge {{$total <= 0 ? 'badge-danger' : 'badge-success'}}">R$ {{$total}}</p>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="mb-2">Recebido: R$ {{number_format($wallet->income(),2,',','.')}}</p>
                            <p class="m-0">Pago: R$ {{number_format($wallet->expense(),2,',','.')}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
