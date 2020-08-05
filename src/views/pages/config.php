<?=$render('header', ['loggedUser' => $loggedUser]);?>

<section class="container main">    
    <?=$render('sidebar', ['activeMenu'=>'config', 'countFriends' => '33']);?>
    <section class="feed mt-10">
        <form id="user-config" method="POST" action="<?=$base;?>/config" enctype="multipart/form-data">            
            <div class="row">
                <div class="column pr-5">

                    <h1>Configurações</h1><br/><br/>
                    <?php if(!empty($flash)): ?>
                    <div class="flash"><?=$flash;?></div>           
                    <?php endif; ?>

                    <div class="config-file">
                        <span>Novo Avatar:</span><br/><br/>
                        <input type="file" name="avatar" /><br/>
                        <img class="img-avatar" src="<?=$base;?>/media/avatars/<?=$user->avatar;?>" />
                    </div><br/>
                    <div class="config-file">
                        <span>Nova Capa:</span><br/><br/>
                        <input type="file" name="cover" /><br/>
                        <img class="img-cover" src="<?=$base;?>/media/covers/<?=$user->cover;?>" />
                    </div>                                         
                </div>                           
                <div class="column side pl-5">
                    <?=$render('right-side');?>
                </div>
            </div>            
        <hr/>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Nome Completo:</label>
                    <input type="text" name="name" value="<?=$user->name;?>"/>
                </div>            
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Data de Nascimento:</label>
                    <input type="text" name="birthdate" class="birthdate" value="<?= date('d/m/Y', strtotime($user->birthdate)) ;?>" />
                </div>            
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">E-mail:</label>
                    <input type="email" name="email" value="<?=$user->email;?>" />
                </div>            
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Cidade:</label>
                    <input type="text" name="city" value="<?=$user->city;?>" />
                </div>            
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Trabalho:</label>
                    <input type="text" name="work" value="<?=$user->work;?>" />
                </div>            
            </div>
            <hr class="mt-10"/>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Nova Senha:</label>
                    <input type="password" name="new-password" class="password" />
                </div>            
            </div>
            <div class="row">
                <div class="column pr-10 config-col">
                    <label class="config-l">Confirmar Nova Senha:</label>
                    <input type="password" name="confirm-password" class="match-password" />
                </div>            
            </div>
            <div class="row mt-10"> 
                <div class="config-col">
                    <input class="btnUpdate" type="submit" value="Salvar" />
                </div>                    
            </div>
        </form>
    </section>
</section>
<script src="https://unpkg.com/imask@6.0.3/dist/imask.js"></script>
<script>
    IMask(
        document.querySelector('.birthdate'),
        {
            mask:'00/00/0000'
        }
        
    );
        
    document.querySelector('.match-password').addEventListener('keyup', (e)=>{
        var pass = document.querySelector('.password').value;
        
        var len = pass.length;
        if(e.target.value.length <= len){
            
            document.querySelector('.password').style.background = "";
            document.getElementById('user-config').onsubmit = function(e) {
                return false;
            }

        }

        if(len < e.target.value.length){
            document.querySelector('.password').style.background = "#FF0000";
            document.getElementById('user-config').onsubmit = function() {
                return false;
            }
        }
        if(len == e.target.value.length){

            if(pass != e.target.value ){                    
                
                document.querySelector('.password').style.background = "#FF0000";
                document.getElementById('user-config').onsubmit = function(e) {
                    return false;
                }
                
            }
            else{                   
                document.querySelector('.password').style.background = "";
                document.querySelector('.password').style.background = "#00FF00";
                document.getElementById('user-config').onsubmit = function(e) {
                    return true;
                }
            }
                
        }
    
    })       
              
</script>
<?=$render('footer');?>