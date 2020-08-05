<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class ConfigController extends Controller {

    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/signin');    
        }        
    }

    public function index($atts = []) { 
        $user = UserHandler::getUser($this->loggedUser->id);

        $flash ='';
        if(!empty($_SESSION['flash'])){

            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        
        $this->render('config', [
            'loggedUser'=>$this->loggedUser,
            'user' => $user,
            'flash'=> $flash
        ]);
    }

    public function updateAction () {
        // Pega todos os campos
        $avatar = filter_input(INPUT_POST, 'avatar');
        $cover = filter_input(INPUT_POST,'cover');
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $birthdate = filter_input(INPUT_POST, 'birthdate');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
        $work = filter_input(INPUT_POST, 'work', FILTER_SANITIZE_SPECIAL_CHARS);
        $newPassword = filter_input(INPUT_POST, 'new-password');
        $confirmPassword = filter_input(INPUT_POST, 'confirm-password');
        
        // Validar a data de nascimento
        if(isset($birthdate) && !empty($birthdate)){                       
            $birthdate = explode('/', $birthdate);
            if(count($birthdate) != 3){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');
            }
            $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
            if(strtotime($birthdate) === false){
                    $_SESSION['flash'] = 'Data de nascimento inválida!';
                    $this->redirect('/config');               
            }
        }
        
        // Validar senha!
        if(isset($newPassword) && !empty($newPassword) && isset($confirmPassword) && !empty($confirmPassword)){
            if($newPassword != $confirmPassword){                
                $_SESSION['flash'] = 'Comparação de senha inválido!';
                $this->redirect('/config');
            }            
        }

        // Verifica se o email já existe
        $user = UserHandler::getUser($this->loggedUser->id, false);
        if($user->email != $email){
            if( UserHandler::emailExists($email) === true){ 
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect('/config');
            }
        }

        // AVATAR
        if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['tmp_name'])){
            $newAvatar = $_FILES['avatar'];
            if(in_array($newAvatar['type'], ['image/jpeg','image/jpg', 'image/png'])){
                $avatarName = $this->cutImage($newAvatar, 200,200, 'media/avatars');
                $avatar = $avatarName;
            }
        }

        // COVER
        if(isset($_FILES['cover']) && !empty($_FILES['cover']['tmp_name'])){
            $newCover = $_FILES['cover'];
            if(in_array($newCover['type'], ['image/jpeg','image/jpg', 'image/png'])){
                $coverName = $this->cutImage($newCover, 850,310, 'media/covers');
                $cover = $coverName;
            }
        }
        
        // Atualiza tudo no BD e volta pro config       
        UserHandler::updateUser($name, $birthdate, $email, $city, $work, $newPassword, $avatar, $cover, $this->loggedUser->id ); 
            
        $this->redirect('/config');
        
    }

    private function cutImage($file, $w, $h, $folder) {
        list($widhtOrig, $heightOrig) = getimagesize($file['tmp_name']);
        $ratio = $widhtOrig / $heightOrig;

        $newWidth = $w;
        $newHeight = $newWidth / $ratio;

        if($newHeight < $h) {
            $newHeight = $h;
            $newWidth = $newHeight * $ratio;            
        }

        $x = $w - $newWidth;
        $y = $h - $newHeight;
        $x = $x < 0 ? $x / 2 : $x;
        $y = $y < 0 ? $y / 2 : $y;

        $finalImage = imagecreatetruecolor($w, $h);
        switch($file['type']) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = imagecreatefromjpeg($file['tmp_name']);
            break;
            case 'image/png':
                $image = imagecreatefrompng($file['tmp_name']);                
            break;
        }

        imagecopyresampled(
            $finalImage, $image,
            $x, $y, 0, 0,
            $newWidth, $newHeight, $widhtOrig, $heightOrig
        );

        $fileName = md5(time().rand(0,9999)).'.jpg';

        imagejpeg($finalImage, $folder.'/'.$fileName);

        return $fileName;
    }
}