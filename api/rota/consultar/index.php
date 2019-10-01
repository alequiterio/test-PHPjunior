<?php
/*
*
* Headers - configurações 
*
*/
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

/*
*
* Validação - verificação da existência dos dados necessários para o cálculo da melhor rota
*
*/

$data = json_decode(file_get_contents("php://input")); // recuperação do POST

if(
    empty($data->origem) &&
    empty($data->destino) &&
    empty($data->autonomia) &&
    empty($data->preco) 
){

	// Envia ao usuário a mensagem de erro com código 400 "bad request"
    http_response_code(400);
    echo json_encode(array("mensagem" => "Não foi possível completar o cálculo, pois faltam argumentos"));
    die; //mata o processo
}


/*
*
* Instância - criação de uma nova Rota
*
*/

include_once '../../objetos/rota.php'; 
$rota = new Rota( $data->origem, $data->destino, $data->autonomia, $data->preco );  

// chama método que calcula melhor rota
$json = $rota->calcularMelhorRota();
 	
// Envia ao usuário a resposta com código 200 "OK"
http_response_code(200);
echo $json;
 
?>
