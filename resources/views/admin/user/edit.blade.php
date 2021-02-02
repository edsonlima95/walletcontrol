@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark"><i
                            class="fa fa-user-edit mr-2"></i> Edição do perfil
                    </h1>
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
            @if(session()->exists('message'))
                {!!  session()->get('message')!!}
            @endif
            <div class="card">
                <div class="card-body">
                    <form action="{{route('control.users.update',['user'=>$user->id])}}" method="post"
                          enctype="multipart/form-data" class="invoice-form">
                        @csrf
                        @method('put')
                        <input type="hidden" name="id" value="{{$user->id}}">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" name="first_name" class="form-control" id="name"
                                           value="{{old('first_name') ?? $user->first_name}}">
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex justify-content-center">
                                <div class="form-group text-center">
                                    <label for="cover" style="cursor: pointer">
                                        <div class="cover">
                                            @php
                                                if($user->cover):
                                                    $cover = \Illuminate\Support\Facades\Storage::url($user->cover);
                                                    else:
                                                    $cover = asset('backend/assets/img/cover-default.png');
                                                endif
                                            @endphp
                                            <img src="{{$cover}}" style="width: 70px; height: 70px;" alt="">
                                        </div>
                                        Editar foto</label>
                                    <input type="file" name="cover" class="form-control" id="cover">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="last_name">Sobrenome</label>
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                           value="{{old('last_name') ?? $user->last_name}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Email</label>
                                    <input type="email" name="email" class="form-control" id="description"
                                           value="{{old('email') ?? $user->email}}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label for="description">Senha</label>
                                    <input type="password" name="password" class="form-control" id="description">
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
