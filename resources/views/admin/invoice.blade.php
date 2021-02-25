@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6 title-invoice">
                    <h1 class="m-0 text-dark"><i
                            class="fa fa-plus-circle mr-2"></i> {{$type == 'expense' ? 'Lançar despesa' : 'Lançar receita'}}
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item col-sm-12 mt-3"><a class="btn btn-dark col-sm-12" href="{{route('control.invoices',['type'=>$type])}}"><i class="fa fa-list-alt mr-2"></i> Listar</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    @if(!empty($invoice->id))
                        <form action="{{route('control.invoiceUpdate')}}" method="post" class="invoice-form"
                              autocomplete="off">
                            @csrf
                            @method('put')
                            <input type="hidden" name="id" value="{{$invoice->id}}">
                            @if($type == 'expense')
                                <input type="hidden" name="type" value="expense">
                            @else
                                <input type="hidden" name="type" value="income">
                            @endif
                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <input type="text" name="description"
                                       value="{{old('description') ?? $invoice->description}}"
                                       class="form-control"
                                       id="description">
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="value">Valor</label>
                                        <input type="text" name="value" value="{{old('value') ?? $invoice->value}}"
                                               class="form-control mask-money"
                                               id="value">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="due_at">Dia de vencimento</label>
                                        @if($invoice->repeat_when == 'single')
                                            <input type="date" name="due_at"
                                                   value="{{old('due_at') ?? $invoice->due_at}}"
                                                   class="form-control" id="due_at">
                                        @else
                                            <input type="number" min="1" max="28" name="due_at"
                                                   value="{{date('d',strtotime($invoice->due_at)) ?? old('due_at')}}"
                                                   class="form-control" id="due_at">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wallet_id">Carteira</label>
                                        <select name="wallet_id" class="form-control" id="wallet_id">
                                            @foreach($wallets as $wallet)
                                                <option
                                                    value="{{$wallet->id}}" {{$invoice->wallet_id == $wallet->id ? 'selected' : ''}}>{{$wallet->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="category_id">Categoria</label>
                                        <select name="category_id" class="form-control" id="category_id">
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category->id}}" {{$invoice->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary bg-dark col-6"><i
                                        class="fa fa-save mr-2"></i>Lançar
                                </button>
                            </div>
                        </form>
                    @else
                        <form action="{{route('control.launch')}}" method="post" class="invoice-form"
                              autocomplete="off">
                            @csrf
                            @if($type == 'expense')
                                <input type="hidden" name="type" value="expense">
                            @else
                                <input type="hidden" name="type" value="income">
                            @endif
                            <div class="form-group">
                                <label for="description">Descrição</label>
                                <input type="text" name="description"
                                       class="form-control {{$errors->has('description') ? 'is-invalid' : ''}}" value="{{old('description')}}"
                                       id="description">
                                @if($errors->has('description'))
                                    <div class="invalid-feedback font-weight-bold">
                                        {{$errors->first('description')}}
                                    </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="value">Valor</label>
                                        <input type="text" name="value" class="form-control mask-money {{$errors->has('value') ? 'is-invalid' : ''}}"
                                              value="{{old('value')}}" id="value">
                                        @if($errors->has('value'))
                                            <div class="invalid-feedback font-weight-bold">
                                                {{$errors->first('value')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="due_at">Data de vencimento</label>
                                        <input type="date" name="due_at" class="form-control {{$errors->has('due_at') ? 'is-invalid' : ''}}" id="due_at"
                                               value="{{old('due_at') ?? ''}}">
                                        @if($errors->has('due_at'))
                                            <div class="invalid-feedback font-weight-bold">
                                                {{$errors->first('due_at')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="wallet_id">Carteira</label>
                                        <select name="wallet_id" class="form-control {{$errors->has('wallet_id') ? 'is-invalid' : ''}}" id="wallet_id">
                                            <option value="" disabled selected>Selecione uma carteira</option>
                                            @foreach($wallets as $wallet)
                                                <option
                                                    value="{{$wallet->id}}" {{old('wallet_id') == $wallet->id ? 'selected' : ''}}>{{$wallet->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('wallet_id'))
                                            <div class="invalid-feedback font-weight-bold">
                                                {{$errors->first('wallet_id')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="category_id">Categoria</label>
                                        <select name="category_id" class="form-control {{$errors->has('category_id') ? 'is-invalid' : ''}}" id="category_id">
                                            <option value="" disabled selected>Selecione uma categoria</option>
                                            @foreach($categories as $category)
                                                <option
                                                    value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('category_id'))
                                            <div class="invalid-feedback font-weight-bold">
                                                {{$errors->first('category_id')}}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex justify-content-around col-lg-12 my-4">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="single" name="repeat_when"
                                               class="custom-control-input"
                                               value="single" {{old('repeat_when') == 'single' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="single">Unica</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="repeat_when" id="fixed"
                                               class="custom-control-input"
                                               value="fixed" {{old('repeat_when') == 'fixed' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="fixed">Fixa</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="repeat_when" id="enrollment" value="enrollment"
                                               class="custom-control-input" {{old('repeat_when') == 'enrollment' ? 'checked' : ''}}>
                                        <label class="custom-control-label" for="enrollment">Parcelada</label>
                                    </div>
                                </div>

                                <div class="form-group col-lg-12 period" style="display: none">
                                    <select name="period" class="form-control" id="period">
                                        <option value="month">Mensal</option>
                                        <option value="year">Anual</option>
                                    </select>
                                </div>
                                <div class="form-group enrollments col-lg-12" style="display: none">
                                    <input type="number" class="form-control" min="1" value="1" max="420"
                                           name="enrollments">
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-dark col-6"><i class="fa fa-save mr-2"></i>Lançar
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {

            //abre o input fixo
            $('input[id="fixed"]').on('click', function () {
                $('div.period').slideDown();
                $('div.enrollments').slideUp();
            })

            //abre o input parcelado
            $('input[id="enrollment"]').on('click', function () {
                $('div.enrollments').slideDown();
                $('div.period').slideUp();
            })

            //Fecha o input fixo ou parcelado
            $('input[id="single"]').on('click', function () {
                $('div.period').slideUp();
                $('div.enrollments').slideUp();
            })

            //Verifica a opção marcada e mostra o input corespondente, se é fixa ou parcelada.
            if ($('input[type="radio"][value="fixed"]').prop('checked')) {
                $('div.period').css('display', 'block');
            }

            if ($('input[type="radio"][value="enrollment"]').prop('checked')) {
                $('div.enrollments').css('display', 'block');
            }

        })
    </script>
@endsection
