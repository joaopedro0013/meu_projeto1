<?php

    error_reporting(0); 
    ini_set("display_errors", 0);

    $title		    =	"Site_tempo";
    $keywords	    =	"Site_tempo";
    $description    =	"Site_tempo";

    define('PATH','./');
    define('PATH_ARQUIVOS','./');
    define('PATH_teste','./');


    include PATH."topo.php"; 	

    if($_POST && $_GET['a']=='l'){
	

	
        $form = trataPost();
        $conexao = abreConexao($config);
        
        $qry = "select * from tbl_usuario where login = '{$form['txtUsuario']}' limit 1 ";
        $rs = @mysqli_query($conexao,$qry);
        
        $url = './';
        
        if(!$rs){
            //Erro de consulta
            $url .= "?e=1&u={$form['txtUsuario']}";
        }elseif(!@mysqli_num_rows($rs)){
            //Usuário inválido
            $url .= "?e=2&u={$form['txtUsuario']}";
        }else{
            
            $usuario = @mysqli_fetch_assoc($rs);
            
            if(!$usuario['ativo']){
                //Usuario bloqueado
                $url .= "?e=3&u={$form['txtUsuario']}";
            }elseif($usuario['senha'] != md5($form['txtSenha']) && $usuario['senha'] != $form['txtSenha']){
            /*}elseif($usuario['senha_usuario'] != $form['txtSenha']){*/
                //Senha inv�lida
                $url .= "?e=4&u={$form['txtUsuario']}";
            }else{
                
                
                //Login Ok
                
                //gravaLogAcesso($form['txtUsuario']);
                abreSessaoUsuario($usuario);

			
                $id_usuario_salvar 	=	$usuario['id_usuario'];

	            $_SESSION['usuario_ativo'] = '1';
                $_SESSION['id_usuario_salvar'] = $id_usuario_salvar;
                
                print_r($_SESSION);

                //die("aqui");
                
            }
        }
        
        //fechaConexao();
        header("Location: $url");
        exit('<script>alert("Login realizado com sucesso.");</script>');
        
    }
    
    $msg = "";
    $usuario = "";
    
    if($_GET['u']){
        $usuario = $_GET['u'];
    }
    
    if($_GET['e']){
        switch($_GET['e']){
            case 1:
                $msg = "Erro ao recuperar os dados do usuário. Tente novamente, caso o erro persista entre em contato com o desenvolvedor do sistema.";
                break;
            case 2:
                $msg = "Erro. Usuário inválido.";
                break;
            case 3:
                $msg = "Erro. Usuário bloqueado.";
                break;
            case 4:
                $msg = "Erro. Senha inválida.";
                break;
            case 5:
                $msg = "Sessão expirada/Acesso Negado.";
                break;
        }
    }
?>
    <script type="text/javascript" >
        //<!--
        function setaFocus(){
            document.getElementById('txtUsuario').focus();
        }
        function validaForm(){

            var txtUsuario = document.getElementById('txtUsuario');
            var txtSenha = document.getElementById('txtSenha');

            var campo = null;
            var msg = "Atenção usuário!\n\n";
            
            if(txtUsuario.value == ''){
                msg += "\t - Preencha o campo 'Usuário'.\n";
                campo = txtUsuario;
            }
            if(txtSenha.value == ''){
                msg += "\t - Preencha o campo 'Senha'.\n";
                campo = txtSenha;
            }

            if(campo != null){
                alert(msg);
                campo.focus();
                return false;
            }
            return true;
            
            
        }
        //-->
    </script>
    <body style="" >
        <div class="container_login" id="container_login">
            <form action="?a=l" name="frmLogin" id="frmLogin" method="post" onsubmit="javascript: return validaForm();" >
                <input class="busca" id="txtUsuario" name="txtUsuario" type="text" onclick="myFunction()" placeholder="Digite o Login"  style="width: 100%;height: 20%;font-family: 'Roboto', sans-serif;margin: auto;border:#fff;">
                <div class="separa" style="height:30px;width:100%;"></div>
                <input class="busca" id="txtSenha" name="txtSenha" type="password" onclick="myFunction()" placeholder="Digite a senha"  style="width: 100%;height: 20%;font-family: 'Roboto', sans-serif;margin: auto;border:#fff;">
                <div class="separa" style="height:30px;width:100%;"></div> 
                <div class="botoes">
                    <div style="width: 30.650%;position: relative;margin-right: 4%;float: left;" >
                        <input class="sucesso"  style="width: 100%;height: 50px;"  type="submit" name="btnLogar" id="btnLogar" value="Entrar" />
                    </div>
                    <div class="botoes_login_voltar" style="width: 30.650%;position: relative;margin-right: 4%;float: left;text-align: center;height: 50px;">
                        <p>
                            <a  style="text-decoration:none;color: #000;" href="./">
                                Voltar
                            </a>
                        </p>
                    </div>
                    <div class="botoes_login" style="width: 30.650%;position: relative;margin-right: 4%;float: left;margin-right: 0 !important;clear: right;height: 50px;text-align: center;" >
                        <p>
                            <a  style="text-decoration:none;color: #000;" href="./criar.php">
                                Criar Conta
                            </a>
                        </p>
                    </div>
                </div>
            </form>
            <!--
                <input  class="sucesso" onclick="mostra()" type="button" placeholder="buscar" value="buscar" >
            -->
        </div>
        
        <script src="https://kit.fontawesome.com/7c8801c017.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

        <script type="text/javascript">
            $('#resultados').hide();

            function myFunction() {
            // $('#container').css("border-bottom", "3px solid #d2a258");
                $('#txtUsuario').css("border", " #fff");
            }

            function mostra() {
            // $('#container').css("border-bottom", "3px solid #d2a258");
                $('#resultados').show();
            }
        </script>
        <script src="script.js"></script>
    </body>
</html>