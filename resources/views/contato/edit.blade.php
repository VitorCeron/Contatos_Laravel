@extends('layouts.app')

@section('title', 'Update')

@section('content')

    <div class="container">
        <div class="row">
            <h4>Atualizar Contato</h4>
            <hr>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ URL::route('contato.update', $contato->id) }}" class="col-12" id="formCadastroContato">
        @method('PUT')
        @csrf
        <input type="hidden" name="contato_id" value="{{ $contato->id }}">
        <input type="hidden" name="id_telefones_antigos" value="{{ json_encode($array_id_telefones,TRUE) }}">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="nome_contato">Nome Contato</label>
                <input type="text" class="form-control" id="nome_contato" name="nome_contato" placeholder="Nome do Contato" value="{{ $contato->nome_contato }}">
            </div>

            <div class="form-group col-md-6">
                <label for="email_contato">E-mail Contato</label>
                <input type="text" class="form-control" id="email_contato" name="email_contato" placeholder="E-mail do Contato" value="{{ $contato->email_contato }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                <label for="link_facebook_contato">Link Facebook</label>
                <input type="text" class="form-control" id="link_facebook_contato" name="link_facebook_contato" placeholder="Link do Facebook" value="{{ $contato->link_facebook_contato }}">
            </div>

            <div class="form-group col-md-6">
                <label for="link_linkedln_contato">Link Linkedln</label>
                <input type="text" class="form-control" id="link_linkedln_contato" name="link_linkedln_contato" placeholder="Link do Linkedln" value="{{ $contato->link_linkedln_contato }}">
            </div>
        </div>

        <input-dinamico-telefone v-bind:items="{{ $telefones }}"></input-dinamico-telefone>

        <a href="{{ URL::route('contato.index') }}" id="btnVoltarTipoTelefone" class="btn btn-primary"><i class="fas fa-reply"></i> Voltar</a>
        <button type="submit" id="btnSalvarTipoTelefone" class="btn btn-success" ><i class="fas fa-save"></i> Salvar</button>


        {{--<script src="{{ asset('js/contato/create.js') }} "></script>--}}
    </form>





@endsection
