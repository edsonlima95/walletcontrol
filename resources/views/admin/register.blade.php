{{--<form action="{{route('control.users.store')}}" method="post"--}}
{{--      enctype="multipart/form-data" class="invoice-form">--}}
{{--    @csrf--}}
{{--    <input type="hidden" name="id" value="{{$user->id}}">--}}
{{--    <div class="row">--}}
{{--        <div class="col-lg-6">--}}
{{--            <div class="form-group">--}}
{{--                <label for="name">Nome</label>--}}
{{--                <input type="text" name="first_name" class="form-control" id="name"--}}
{{--                       value="{{old('first_name')}}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-6 d-flex justify-content-center">--}}
{{--            <div class="form-group text-center">--}}
{{--                <div class="cover">--}}
{{--                    <img src="{{asset('backend/assets/img/cover-default.png')}}"--}}
{{--                         class="img-fluid" alt="">--}}
{{--                </div>--}}
{{--                <label for="cover" style="cursor: pointer">Editar foto</label>--}}
{{--                <input type="file" name="cover" class="form-control" id="cover">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-12">--}}
{{--            <div class="form-group">--}}
{{--                <label for="description">Email</label>--}}
{{--                <input type="email" name="email" class="form-control" id="description"--}}
{{--                       value="{{old('email') ?? $user->email}}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-lg-12">--}}
{{--            <div class="form-group">--}}
{{--                <label for="description">Senha</label>--}}
{{--                <input type="password" name="password" class="form-control" id="description">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="col-lg-12 d-flex justify-content-center">--}}
{{--        <button type="submit" class="btn bg-dark col-6"><i class="fa fa-edit mr-2"></i>Atualizar--}}
{{--        </button>--}}
{{--    </div>--}}
{{--</form>--}}
    <!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/adminlte.min.css')) }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/fontawesome-free/css/all.min.css')) }}">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset(mix('backend/assets/css/style.css')) }}">
    <title>Login | Wallet Control</title>

    <style>
        .login-wrap {
            background-color: #00ff5f;
            height: 100vh;
        }

        div.left {
            height: 100vh;
            background-color: #343a40;
        }

        div.right {
            height: 100vh;
        }

    </style>
</head>
<body>
<div class="login-wrap d-flex">
    <div class="col-lg-4 left">
        <div class="col-lg-12 d-flex justify-content-end align-items-center" style="height: 100vh">
            <img src="{{asset('backend/assets/img/undraw_3.svg')}}" alt="" class="img-fluid">
        </div>
    </div>
    <div class="col-lg-8 right">
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
            <div class="col-lg-8">
                <form action="{{route('control.register-store')}}" method="post" enctype="multipart/form-data"
                      class="invoice-form">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center my-3">
                            <i class="fa fa-sign-in-alt fa-2x"></i>
                        </div>
                        <div class="col-lg-12">
                            {{-- Exibe os erros de validação--}}
                            @if($errors->any())
                                @foreach($errors->all() as $error)
                                    <div class="alart alert-danger p-3 my-4" style="border-radius: 5px" role="alert">
                                        {{$error}}
                                    </div>
                                @endforeach
                            @endif

                            {{--Exibe as mensagem que nao sao da validação--}}
                            @if(session()->exists('message'))
                                {!!  session()->get('message')!!}
                            @endif
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="first_name">Nome</label>
                                <input type="text" name="first_name" value="{{old('first_name')}}"
                                       class="form-control"
                                       id="first_name">
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex justify-content-center">
                            <div class="form-group text-center">
                                <label for="cover" style="cursor: pointer">
                                    <div class="cover">
                                        <img src="{{asset('backend/assets/img/cover-default.png')}}"
                                             class="img-fluid" alt="">
                                    </div>
                                    Enviar foto
                                </label>
                                <input type="file" name="cover" class="form-control" id="cover">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="last_name">Sobrenome</label>
                                <input type="text" name="last_name" class="form-control" id="last_name"
                                       value="{{old('last_name')}}">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" value="{{old('email')}}"
                                       class="form-control"
                                       id="email">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="password" value="{{old('password')}}"
                                       class="form-control" id="password">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="submit" class="btn bg-dark col-6"><i class="fa fa-save mr-2"></i>Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
