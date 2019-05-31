<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contato;
use App\Telefone;
use App\Mail\EnviarEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContatoController extends Controller
{
    public function index(){
        $contatos = Contato::where('user_id', '=', Auth::user()->id)->get();
        //$telefone = Telefone::where('contato_id', '=', $contatos[0]->id)->limit(1)->get()[0];
        return view('contato.index',compact('contatos'));
    }

    public function create(){
        $quantidadeContatos = Contato::orderBy('id', 'DESC')->limit(1)->get();
        if(count($quantidadeContatos) == 0){
            $quantidadeContatos = 0;
        } else {
            $quantidadeContatos = $quantidadeContatos[0]->id;
        }
        return view('contato.create', compact('quantidadeContatos'));
    }

    public function store(Request $request){

        $request->validate([
            'nome_contato' => 'required',
            'email_contato' => 'required'
        ]);

        Contato::create([
            'nome_contato' => $request['nome_contato'],
            'email_contato' => $request['email_contato'],
            'link_facebook_contato' => $request['link_facebook_contato'],
            'link_linkedln_contato' => $request['link_linkedln_contato'],
            'user_id' => Auth::user()->id
        ]);

        for ($i = 0; $i < count($request['tipo_telefone']); $i++){
            if( $request['tipo_telefone'][$i] != "" && $request['tipo_telefone'][$i] != NULL && $request['telefone'][$i] != "" && $request['telefone'][$i] != NULL ){
                Telefone::create([
                    'tipo_telefone' => $request['tipo_telefone'][$i],
                    'telefone' => $request['telefone'][$i],
                    'contato_id' => (int)$request['ultimo_contato'] + 1
                ]);
            }
        }
        
        Mail::to($request['email_contato'])->send(new EnviarEmail());

        return redirect()->action('ContatoController@index')->with('success', 'Contato cadastrado com sucesso!!');
    }

    public function edit($id){
        $contato = Contato::find($id);
        $telefones = Telefone::where('contato_id', '=', $contato->id)->get();

        $array_id_telefones = [];
        for ($i = 0; $i < count($telefones); $i++){
            array_push($array_id_telefones, $telefones[$i]->id);
        }

        return view('contato.edit',compact('contato','telefones', 'array_id_telefones'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'nome_contato' => 'required',
            'email_contato' => 'required'
        ]);

        Contato::where('id', $id)->update([
            'nome_contato' => $request['nome_contato'],
            'email_contato' => $request['email_contato'],
            'link_facebook_contato' => $request['link_facebook_contato'],
            'link_linkedln_contato' => $request['link_linkedln_contato'],
            'user_id' => Auth::user()->id
        ]);

        //recupera todos telefones de um contato
        $array_id_telefones = array(json_decode($request->id_telefones_antigos));

        /*
         * verifica se o id_telefone que existia antes no banco de dados, ainda existe depois da requisição
         * caso exista, o sistema irá dar um update nas informações que recebeu do formulário
         * caso não exista o sistema exclui o id_telefone do banco
         */
        foreach ($array_id_telefones[0] as $keyRequest => $valueRequest) {
            if( in_array($array_id_telefones[0][$keyRequest], $request['id_telefone']) ){
                Telefone::where('id', (int)$request['id_telefone'][$keyRequest])->update([
                    'tipo_telefone' => $request['tipo_telefone'][$keyRequest],
                    'telefone' => $request['telefone'][$keyRequest],
                    'contato_id' => (int)$request['contato_id']
                ]);
            } else {
                Telefone::Find($array_id_telefones[0][$keyRequest])->delete();
            }
        }

        /*
         * caso não exista o id_telefone no banco, o id_telefone que vem do form seja null, mas existe valor preenchido no
         * form nos campos tipo_telefone e telefone, então o sistema insere um telefone no banco de dados
         */
        foreach ($request['id_telefone'] as $key => $value) {
            if( $request['id_telefone'][$key] == NULL  && $request['tipo_telefone'][$key] != NULL && $request['telefone'][$key] != NULL ) {
                Telefone::create([
                    'tipo_telefone' => $request['tipo_telefone'][$key],
                    'telefone' => $request['telefone'][$key],
                    'contato_id' => (int)$request['contato_id']
                ]);
            }
        }

        return redirect()->action('ContatoController@index')->with('success', 'Contato atualizado com sucesso!!');
    }

    public function destroy($id){
        Contato::Find($id)->delete();

        return redirect()->action('ContatoController@index')->with('success', 'Contato excluído com sucesso!!');
    }
}
