<?php

namespace App\Controller;

use System\Core\Controller;

use System\Utilities;

use App\Storage\Alunos as Model;

class Alunos extends Controller
{
    private $limit = 16;

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->form(null);
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): $this->read();
        $this->data['count'] = isset($_SESSION['search'])? count(unserialize($_SESSION['search'])): Model::count();
        unset($_SESSION['search']);
        $this->content('alunos/index', $this->data);
    }

    public function edit($id)
    {
        $this->data['edit'] = true;
        $this->form($this->read($id));
        $this->data['data'] = $this->read();
        $this->content('alunos/index', $this->data);
    }

    public function read($id = null)
    {
        if (!isset($_SESSION['alunos']['pagination'])) {
            $this->pagination();
        }

        if (is_null($id)) {
            $data = Model::all(['select'=>'*',
                                'limit'=>$this->limit,
                                'offset'=>$_SESSION['alunos']['pagination'],
                                'order'=>'id DESC']);

            $count = Model::count();
            if ($count > $this->limit) {
                $_SESSION['alunos']['count'] = $count % $this->limit? (int)($count / $this->limit) + 1: $count / $this->limit;
            } else {
                $_SESSION['alunos']['count'] = 1;
            }

            return $data;
        }

        return Model::find($id);
    }

    public function create()
    {
        $data['ficha'] = filter_input(INPUT_POST, 'ficha');
        $data['nome'] = ucwords(strtolower(filter_input(INPUT_POST, 'nome')));
        $data['data_nascimento'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'data_nascimento'))));
        $data['pai'] = ucwords(strtolower(filter_input(INPUT_POST, 'pai')));
        $data['mae'] = ucwords(strtolower(filter_input(INPUT_POST, 'mae')));

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::create($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao realizar o cadastro!', 'error'=>'danger'];
            Utilities::redirect('alunos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Cadastro realizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('alunos');
        exit();
    }

    public function update($id)
    {
        $data['ficha'] = filter_input(INPUT_POST, 'ficha');
        $data['nome'] = ucwords(strtolower(filter_input(INPUT_POST, 'nome')));
        $data['data_nascimento'] = date('Y-m-d', strtotime(str_replace('/', '-', filter_input(INPUT_POST, 'data_nascimento'))));
        $data['pai'] = ucwords(strtolower(filter_input(INPUT_POST, 'pai')));
        $data['mae'] = ucwords(strtolower(filter_input(INPUT_POST, 'mae')));    

        if (filter_input(INPUT_POST, 'token') !== Utilities::token() || !Model::find($id)->update_attributes($data)) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('alunos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro atualizado com sucesso!', 'error'=>'success'];
        Utilities::redirect('alunos');
        exit();

    }

    public function delete($id)
    {
        if (!Model::find($id)->delete()) {
            $_SESSION['alert'] = ['message'=>'Erro ao tentar alterar o registro!', 'error'=>'danger'];
            Utilities::redirect('alunos');
            exit();
        }

        $_SESSION['alert'] = ['message'=>'Registro apagado com sucesso!', 'error'=>'success'];
        Utilities::redirect('alunos');
        exit();
    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('alunos');
            exit();
        }

        $_SESSION['alunos']['search'] = true;
        $field = filter_input(INPUT_POST, 'search');
        $_SESSION['search'] = serialize(Model::all(['select'=>'*',
                                                    'conditions'=>['nome LIKE CONCAT("%",?,"%")', $field],
                                                    'order'=>'id DESC']));
        Utilities::redirect('alunos');
        exit();
    }

    public function pagination($page = 1, $redirect = true)
    {
        $_SESSION['alunos']['pagination'] = $page > 1? ($page - 1) * $this->limit: 0;
        $_SESSION['alunos']['current_page'] = $page > 1? $page: 1;

        if ($redirect) {
            Utilities::redirect('alunos');
        }

        exit();
    }

    private function form($model = null)
    {
        $this->data['form']['ficha'] = is_object($model)? $model->ficha: null;
        $this->data['form']['nome'] = is_object($model)? $model->nome: null;
        $this->data['form']['data_nascimento'] = is_object($model)? date('d/m/Y', strtotime($model->data_nascimento)): null;
        $this->data['form']['pai'] = is_object($model)? $model->pai: null;
        $this->data['form']['mae'] = is_object($model)? $model->mae: null;
        return;
    }

    public function verify($id)
    {
        $data['status'] = count(Model::all(['conditions'=>['ficha = ?', $id]]))? true: false;

        $this->outputJSON($data);
    }
}