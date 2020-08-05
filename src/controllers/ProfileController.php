<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false) {
            $this->redirect('/login');
        }        
    }

    public function index($atts = []) {
        $page = intval(filter_input(INPUT_GET, 'page'));

        // Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])) {
            $id = $atts['id'];
        }
        
        // Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user) {
            $this->redirect('/');
        }
        // Calcula a idade do usuario
        $dateFrom = new \DateTime($user->birthdate);//Pega data de nascimento
        $dateTo = new \DateTime('today');// Pega a data de hoje
        $user->ageYears = $dateFrom->diff($dateTo)->y;// Calcula a diferença 

        // Pegando o feed do usuário
        $feed = PostHandler::getUserFeed(
            $id,
            $page,
            $this->loggedUser->id
        );

        // Verificar se eu sigo o usuário
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);
    }

    public function follow($atts) {
        $to = intval($atts['id']);

        if(UserHandler::idExists($to)) {
            if(UserHandler::isFollowing($this->loggedUser->id, $to)) {// Tá seguindo?
                // Desseguir
                UserHandler::unfollow($this->loggedUser->id, $to);// Se tá tira
            } else {
                // Seguir
                UserHandler::follow($this->loggedUser->id, $to);// Senão Põe
            }
        }
        $this->redirect('/perfil/'.$to);
    }

    public function friends($atts = []) {
        // Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])) {
            $id = $atts['id'];
        }
        // Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user) {
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);//Pega data de nascimento
        $dateTo = new \DateTime('today');// Pega a data de hoje
        $user->ageYears = $dateFrom->diff($dateTo)->y;// Calcula a diferença 

        // Verificar se eu sigo o usuário
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_friends', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }

    public function photos($atts = []) {
        // Detectando o usuario acessado
        $id = $this->loggedUser->id;
        if(!empty($atts['id'])) {
            $id = $atts['id'];
        }
        // Pegando informações do usuario
        $user = UserHandler::getUser($id, true);
        if(!$user) {
            $this->redirect('/');
        }
        $dateFrom = new \DateTime($user->birthdate);//Pega data de nascimento
        $dateTo = new \DateTime('today');// Pega a data de hoje
        $user->ageYears = $dateFrom->diff($dateTo)->y;// Calcula a diferença 

        // Verificar se eu sigo o usuário
        $isFollowing = false;
        if($user->id != $this->loggedUser->id) {
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);
        }

        $this->render('profile_photos', [
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'isFollowing' => $isFollowing
        ]);
    }

}