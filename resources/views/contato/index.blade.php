@extends('layouts.app')

@section('title', 'Index')

@section('content')

    @if(session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div><br />
    @endif

    <div class="container pl-0 pr-0">
        <div class="clearfix">
            <div class="col-md-4 float-left">
                <h4 class="mt-2">Lista de Contatos</h4>
            </div>

            <div class="col-md-8 float-right mr-0">
                <div class="form-group form-inline float-right">
                    <form>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Pesquise por nome" value="{{ isset($name) ? $name : '' }} " />
                        <button type="submit" href="{{ route('contato.index') }}" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Pesquisar</button>
                    </form>
                    <a href="{{  route('contato.create')  }}" class="btn btn-success"><i class="fas fa-plus"></i> Novo </a>
                </div>

            </div>
        </div>
    </div>

    <table class="table table-hover table-sm table-striped mt-4">
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th style="text-align: center"> Ações </th>
        </tr>
        @if (count($contatos) > 0)
            @foreach($contatos as $contato)
                <tr>
                    <td>{{ $contato->id }}</td>
                    <td>{{ $contato->nome_contato }}</td>
                    <td>{{ $contato->email_contato }}</td>
                    <td class="text-center">
                        <a class="btn btn-primary btn-sm" href="{{ route('contato.edit', $contato->id) }}" title="Editar Contato"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('contato.destroy', $contato->id) }}" method="POST" style="display: inline-block;">
                        @method('DELETE')
                        @csrf
                        <button type="submit" title="Apagar Tipo Telefone" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="4" align="center"><h3>Nenhum Contato cadastrado.</h3></td>
            </tr>
        @endif
    </table>

    <div class="d-flex justify-content-center">
    {{ $contatos->appends(['name' => isset($name) ? $name : ''])->links() }}
    </div>

@endsection
