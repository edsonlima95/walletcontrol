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
    @notifyCss
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

@include('notify::messages')

<div class="login-wrap d-flex">
    <div class="col-lg-4 left">
        <div class="col-lg-12 d-flex justify-content-end align-items-center" style="height: 100vh">
            <img src="{{asset('backend/assets/img/undraw_3.svg')}}" alt="" class="img-fluid">
        </div>
    </div>
    <div class="col-lg-8 right">
        <div class="row d-flex justify-content-center align-items-center" style="height: 100vh">
            <div class="col-lg-6 ">
                <form action="{{route('control.login')}}" method="post" class="invoice-form" autocomplete="off">
                    @csrf

                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center my-3">
                            <i class="fa fa-lock fa-2x"></i>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="value">E-mail</label>
                                <input type="text" name="email" value="{{old('email')}}"
                                       class="form-control mask-money {{$errors->has('email') ? 'is-invalid' : ''}}"
                                       id="value">
                                @if($errors->has('email'))
                                    <div class="invalid-feedback font-weight-bold">
                                        {{$errors->first('email')}}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" name="password" value="{{old('password')}}"
                                       class="form-control {{$errors->has('password') ? 'is-invalid' : ''}}"
                                       id="password">
                                @if($errors->has('password'))
                                    <div class="invalid-feedback font-weight-bold">
                                        {{$errors->first('password')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-between my-4">
                        <a href="#" style="color: black">Esqueci a senha</a>
                        <a href="{{route('control.register')}}" style="color: black">Cadastre-se</a>
                    </div>
                    <div class="col-lg-12 d-flex justify-content-center">
                        <button type="submit" class="btn bg-dark col-6"><i class="fa fa-sign-in-alt mr-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset(mix('backend/assets/js/jquery.min.js')) }}"></script>
@notifyJs
<script>

    $(function () {
        $('input').on('focus', function () {
            $(this).css({background: 'transparent', 'border-bottom': '1px solid black'});
        })
    })
</script>
</body>
</html>
