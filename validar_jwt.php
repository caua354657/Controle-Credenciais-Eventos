<?php
    session_start();
    require('vendor/autoload.php');
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Firebase\JWT\ExpiredException;

    class json_web_token
    {
        public static function validar()
        {
            if(isset($_SESSION['jwt'])) 
            {
                $token = $_SESSION['jwt'];
                try //parte do código que pode causar erro
                {
                    $tokendecodificado = JWT::decode($token, new Key('minha_chave_secreta', 'HS256'));
                    if(isset($tokendecodificado->id, $tokendecodificado->nome, $tokendecodificado->categoria))
                    {
                        return [
                            'id' => $tokendecodificado->id,
                            'nome_usuario' => $tokendecodificado->nome,
                            'categoria' => $tokendecodificado->categoria
                        ];
                    }
                }                    
                catch(ExpiredException $erro) //o que fazer
                {
                    session_destroy();
                    header('refresh: 0.1; url=index.php');
                    echo '<script>alert("Sua sessão expirou. Faça login novamente!")</script>';
                    exit;
                }
            }
            else 
            {
                header("refresh:1; url=index.php");
                echo '<script>alert("Token não enviado")</script>';
                exit;
            }    
        }
    }
?>