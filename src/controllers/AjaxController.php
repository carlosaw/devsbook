<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class AjaxController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false) {
            header("Content-Type: apllication/json");
            echo json_encode(['error' => 'Usuário não logado']);
            exit;
        }        
    }

    public function like($atts) {        
        $id = $atts['id'];
        
        if(PostHandler::isLiked($id, $this->loggedUser->id)) {
            // delete no like
            PostHandler::deleteLike($id, $this->loggedUser->id);
        } else {
            // insere um like
            PostHandler::addLike($id, $this->loggedUser->id);
        }
    }
}