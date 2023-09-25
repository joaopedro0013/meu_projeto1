
<?php
    $title		    =	"Site_tempo";
    $keywords	    =	"Site_tempo";
    $description    =	"Site_tempo";

    define('PATH','./');
    define('PATH_ARQUIVOS','./');
    define('PATH_teste','./');


    include PATH."topo.php"; 

    validaSessao($config);

    $usuario_ativo = "";

    $usuario_ativo = $_SESSION['usuario_ativo'];
    $usuario_login = $_SESSION['login'];

    if($usuario_ativo == 1){
        $estrutura ='<div>
                        <h2 style="    font-family: '."'Roboto'".', sans-serif;color: #fff;" >
                            Olá '.$usuario_login.'.
                        </h2>   
                     </div>';
    }else{
        echo($usuario_ativo);
        $estrutura ='<div  class="login" style="    text-align: center;" >
                        <p>
                            <a style=" color: #000;margin: auto;text-decoration:none" href="./login.php">Login</a>
                        </p>
                    </div>';
    }

    if($_POST && $_GET['a']=='s'){
	

	
        $conexao = abreConexao($config);


        $id_usuario 	    = $_SESSION['id_usuario_salvar'];
        $salvarumidade	    = $_POST['salvarumidade'];  
        $salvartemperatura	= $_POST['salvartemperatura'];
        $salvardescricao	= $_POST['salvardescricao'];  
        $salvarvento	    = $_POST['salvarvento'];
        $salvarlugar	    = $_POST['salvarlugar'];
        
        //die("aqui");
        
        //print_array($_POST);
        //print_array($_FILES);
        //exit();
        
        $qry = "INSERT into  tbl_tempo (Data, Lugar, Umidade,
                                          Velocidade_vento, temperatura, 
                                          id_usuario,descricao)
                                          
                                   VALUES(now(),'{$salvarlugar}', '{$salvarumidade}',
                                        '{$salvarvento}', '{$salvartemperatura}', 
                                          '{$id_usuario}','{$salvardescricao}')";
                
        print_r($_SESSION);
                
        //die($qry);
        
        mysqli_query($conexao,$qry) or die('<script>alert("Erro: ' . mysqli_errno($conexao) . ' SQL.: '.$qry.'");</script>');
        
        $id_produto	=	mysqli_insert_id($conexao);
     
        //fechaConexao();
        die('<script>window.location.href="./";</script>');

        
    }

    $id_usuario 	    = $_SESSION['id_usuario_salvar'];

    $qry = "select * from tbl_tempo where id_usuario='$id_usuario'";
		
    //die($qry);
    $rs = @mysqli_query($conexao,$qry) or die("Erro: " . mysqli_error());
    $num = @mysqli_num_rows($rs);

    $estrutura_html = '';
    $option_html = '';

    while ($row = @mysqli_fetch_assoc($rs)):

        $Data			    = $row['Data'];   
        $Lugar				= $row['Lugar'];
        $Umidade			= $row['Umidade'];
        $Velocidade_vento	= $row['Velocidade_vento'];
        $temperatura		= $row['temperatura'];
        $descricao		= $row['descricao'];
        
        // <td valign="middle">' . $descricao . '</td>
        $estrutura_html .= '
                            <tr>
                                <td valign="middle" style="text-align: center;" >' . $Data . '</td>
                                <td valign="middle" style="text-align: center;" >' . $temperatura . 'C</td>
                                <td valign="middle" style="text-align: center;" >' . $descricao . '</td>	
                                <td valign="middle" style="text-align: center;" >' . $Umidade . '%</td>
                                <td valign="middle" style="text-align: center;" >' . $Lugar . '</td>		
                                <td valign="middle" style="text-align: center;" >' . $Velocidade_vento . 'Km/h</td>	
                            </tr>';
    endwhile;

    //print_r($_SESSION);
?>
<body style="" >

    <?=$estrutura?>
    <div class="container" id="container">
        
        <input class="busca" id="busca" name="busca" type="text" onclick="myFunction()" placeholder="Olá, Digite um lugar"  style="width: 70%;height: 40%;font-family: 'Roboto', sans-serif;margin: auto;border:#fff;">
        <button  class="sucesso" onclick="mostra()">Buscar</button>
        <!--
            <input  class="sucesso" onclick="mostra()" type="button" placeholder="buscar" value="buscar" >
        -->
    </div>
    <div class="separa" style="height:10px;width:100%;"> </div>

    <div class="not-found">
            <img src="images/404.png">
            <p>Oops! Localizaçõa Invalida :/</p>
    </div>
    <div class="resultados" id="resultados" style="">
        <form action="?a=s" name="salvarclima" id="salvarclima" method="post" >
            <div class="temperatura" style="text-align: center;" >
                <img style="width: 30%;" src="">
                <p class="temperature" id="idtemperatura" name="idtemperatura"></p>
                <p class="description"  id="iddescricao"  name="iddescricao" ></p>

                <input  id="salvartemperatura" name="salvartemperatura" type="hidden" value=""  >
                <input  id="salvardescricao" name="salvardescricao" type="hidden" value=""  >
                <input  id="salvarlugar" name="salvarlugar" type="hidden" value=""  >
            </div>
            <div class="separa" style="height:10px;width:100%;">
            </div>
            <div class="detalhes_clima" >
                <div class="umidade" style="text-align: center;" >
                    <i class="fa-solid fa-water"></i>
                    <div class="text">
                        <span  id="idumidade" name="idumidade" ></span>
                        <p>Umidade</p>
                        <input  id="salvarumidade" name="salvarumidade" type="hidden" value=""  >
                    </div>
                </div>
                <div class="vento" style="text-align: center;">
                    <i class="fa-solid fa-wind"></i>
                    <div class="text">
                        <span  id="idvelocidade" name="idvelocidade" ></span>
                        <p>Velocidade do vento</p>
                        <input  id="salvarvento" name="salvarvento" type="hidden" value=""  >
                    </div>
                </div>
            </div>
            <div style="width: 30.650%;position: relative;margin-right: 4%;float: left;" >
                <input class="sucesso"  onclick="salva()" style="width: 100%;height: 50px;"  type="submit" name="btnsalvar" id="btnsalvar" value="salvar" />
            </div>
        </form>
    </div>
    <div class="container_mostrar">
        <table cellspacing="1" class="tablesorter">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Temperatura</th>
                    <th>Descricao</th>    
                    <th>Umidade</th>    
                    <th>Local</th>    
                    <th>Velocidade do Vento</th>                      
                            <!--<th>Detalhes</th>--> 
                </tr>
            </thead>
            <tbody>
                <?php echo $estrutura_html; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Data</th>
                    <th>Temperatura</th>
                    <th>Descricao</th>    
                    <th>Umidade</th>    
                    <th>Local</th>   
                    <th>Velocidade do Vento</th>                    
                    <!--<th>Detalhes</th>--> 
                </tr>
            </tfoot>
        </table>
    </div>

    <script src="https://kit.fontawesome.com/7c8801c017.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>

    <script type="text/javascript">

        $('#resultados').hide();

        function myFunction() {
           // $('#container').css("border-bottom", "3px solid #d2a258");
            $('#busca').css("border", " #fff");
        }

        function salva() {

            document.getElementById("salvartemperatura").value = document.getElementById("idtemperatura").innerHTML;
            var idtemperatura = $("#salvartemperatura").val();

            $string1 = idtemperatura;
            $num1    = parseInt($string1.match(/\d/g).join(''));
            $("#salvartemperatura").val($num1);
            //alert($num1);



            document.getElementById("salvardescricao").value = document.getElementById("iddescricao").innerHTML;
            var iddescricao = $("#salvardescricao").val();

            //alert(iddescricao);

            //document.getElementById("salvarlugar").value = document.getElementById("busca").innerHTML;
            //var busca = $("#salvarlugar").val();


            var input = document.querySelector("#busca");
            var texto = input.value;

            $("#salvarlugar").val(texto);
            //alert(texto);
            //console.log(texto);
           // console.log('aquiiii');

            document.getElementById("salvarumidade").value = document.getElementById("idumidade").innerHTML;
            var idumidade = $("#salvarumidade").val();

            $string3 = idumidade;
            $num3    = parseInt($string3.match(/\d/g).join(''));
            $("#salvarumidade").val($num3);
            //alert($num3);




            document.getElementById("salvarvento").value = document.getElementById("idvelocidade").innerHTML;
            var idvelocidade = $("#salvarvento").val();

            $string4 = idvelocidade;
            $num4    = parseInt($string4.match(/\d/g).join(''));
            $("#salvarvento").val($num4);
            //alert($num4);



        }

        function mostra() {
           // $('#container').css("border-bottom", "3px solid #d2a258");
            $('#resultados').show();

        }

        window.onload = function(){
            console.log('Onload disparado');
        }
    </script>
    <script src="script.js"></script>
</body>

</html>