<?php

namespace App\Controller;

use System\Core\Controller;
use System\Utilities;
use App\Storage\Alunos;

class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['data'] = isset($_SESSION['search'])? unserialize($_SESSION['search']): [];
        unset($_SESSION['search']);
        $this->content('home/index', $this->data);
    }

    public function search()
    {
        if (filter_input(INPUT_POST, 'token') !== Utilities::token()) {
            $_SESSION['alert'] = ['message'=>'Erro ao pesquisar!', 'error'=>'danger'];
            Utilities::redirect('');
            exit();
        }

        $field = filter_input(INPUT_POST, 'search');
        $_SESSION['search'] = serialize(Alunos::all(['select'=>'*',
                                                    'conditions'=>['nome LIKE CONCAT("%",?,"%")', $field],
                                                    'order'=>'id DESC']));
        Utilities::redirect('');
        exit();
    }
}