<?php

    class Rota{
        
        private $rotas = array();
        private $origem = "";
        private $destino = "";
        private $autonomia = 0;
        private $preco = 0;

        /*
        *
        *   Método: Construtor
        *   Parâmetros: string, string, int, float
        *
        */
        public function __construct( $origem , $destino , $autonomia, $preco ){

            $this->origem =  $origem ;
            $this->destino =  $destino ;
            $this->autonomia = $autonomia;
            $this->preco = $preco;

            $this->verificarTipoAtributos();
            $this->verificarOrigemDestino();
            $this->rotas = $this->carregarRotas();

        }

        /*
        *
        *   Método privado: verifica se os tipos de cada atributo enviado estão dentro do aceito pela API
        *   Parâmetros: null
        *   Retorno: void
        *
        */
        private function verificarTipoAtributos(){

            if( !is_string( $this->origem ) ){
                $this->matarProcesso( 415 ,  "O formato esperado para 'origem' é string" );
            }
            if( !is_string( $this->destino ) ){
                $this->matarProcesso( 415 ,  "O formato esperado para 'destino' é string" );
            }
            if( !is_int( $this->autonomia ) ){
                $this->matarProcesso( 415 ,  "O formato esperado para 'autonomia' é int" );
            }
            if( !is_float( $this->preco ) ){
                $this->matarProcesso( 415 ,  "O formato esperado para 'preco' é float" );
            }

        }

        /*
        *
        *   Método privado: verifica se a origem é diferente do destino
        *   Parâmetros: null
        *   Retorno: void
        *
        */
        private function verificarOrigemDestino(){

            if( $this->origem == $this->destino ){
                $this->matarProcesso( 400 ,  "O destino não pode ser o mesmo que a origem" );
            }

        }

        /*
        *
        *   Método privado: mata o processo, enviando para o navegador um código e mensagem de erro
        *   Parâmetros: int, string
        *   Retorno: void
        *
        */
        private function matarProcesso( $codigo, $mensagem ){
            
            http_response_code($codigo);
            echo json_encode(array("mensagem" => $mensagem ));
            die; 

        }

        /*
        *
        *   Método privado: carrega um arquivo .json com as rotas base para cálculos, o transformando em um array
        *   Parâmetros: null
        *   Retorno: array
        *
        */
        private function carregarRotas(){
            return json_decode( file_get_contents( __DIR__.'/../dados/rotas.json') , true);
        }

        /*
        *
        *   Método privado: Percorre as rotas a partir da origem inicial, buscando os destinos possíveis usando a 
        *   recursividade para fazer com que estes destinos se tornem origens até que se chegue ao destino final 
        *   com a somatória dos kilômetros percorridos até o local.
        *   Parâmetros: string, int
        *   Retorno: 
        *
        */
        private function buscarRotasPossiveis( $origemAux , $distancia = 0 ){

            $rotasPossiveis = array();

            //verifica se existe rotas da origem atual
            if( isset( $this->rotas[$origemAux]) ): 

                //ordena as rotas de forma crescente
                ksort( $this->rotas[ $origemAux ]); 
                
                //percorre cada uma das rotas possíveis a partir da origem atual
                foreach(  $this->rotas[ $origemAux ] as $destinoRota => $distanciaRota ){ 

                    // soma a distancia que já existe com a do novo caminho
                    $distancia += $distanciaRota; 
                        
                        // adiciona no array de rotas possíveis a distância do caminho
                        $rotasPossiveis[$origemAux][$destinoRota] = $distancia;

                        // verifica se o destino da origem atual é diferente do destino que queremos chegar
                        if( $destinoRota != $this->destino ){ 
                            // seta no array de retorno as próximas rotas possíveis, chamando novamente a função
                            $rotasPossiveis[$origemAux][$destinoRota] = $this->buscarRotasPossiveis( $destinoRota,$distanciaRota );    
                        }
                        else {
                            break;
                        }
                            
                    //zera a distancia para o proximo caminho  
                    $distancia = 0;          
                    
                }

            else:
                $this->matarProcesso(400,"Não existem origens");
            endif;

            // se o array não possuir a chave da origem, retorna o array bruto, se não somente da chave correspondente à origem
            return isset($rotasPossiveis[$origemAux])? $rotasPossiveis[$origemAux]: $rotasPossiveis;
        }

        /*
        *
        *   Método privado: Compara o último valor - que representa a distância em km total do trajeto - entre dois arrays e retorna o que teve a distância menor
        *   Parâmetros: array, array
        *   Retorno: array
        *
        */
        private function verificarMenorTrecho( $valor , $retorno ){

            return count($retorno) > 0 ? (end( $valor )>end($retorno)? $retorno : $valor): $valor;
        }

        /*
        *
        *   Método privado: Quebra a matriz de possíveis rotas, a transformando em um array simples
        *   Parâmetros: string, (array ou int)*
        *   Retorno: array
        *
        */
        private function destrincharMatriz( $origem, $caminhos ){
            $arraySimples = array( 0 => $origem ); 

            // verifica se a variável 'caminhos' ainda é um array, pois no final do percurso ela pode representar a distância (int)
            if( is_array($caminhos) ):

                foreach ($caminhos as $origemCaminho => $percurso) {

                    array_push( $arraySimples, $origemCaminho);

                    // ternário pergunta se 'percurso' é um array, se sim chama novamente a função, se não o adiciona ao 'arraySimples'
                    array_push( $arraySimples, (is_array($percurso) ? $this->destrincharMatriz( $origemCaminho, $percurso ): $percurso) );

                    return $arraySimples;
                }

            else:
                array_push( $arraySimples, $caminhos);
                return $arraySimples;
            endif;

        }
            
        /*
        *
        *   Método privado: calcula o preço do menor percurso
        *   Parâmetros: int
        *   Retorno: float
        *
        */
        private function calcularPrecoRota( $distancia ){

            if( is_array( $distancia)) {
                $this->matarProcesso(500, "Internal Server Error");
            }
           
            return floatval( ( $distancia/$this->autonomia )*$this->preco);

        }

        /*
        *
        *   Método privado: transforma o array em um json
        *   Parâmetros: array
        *   Retorno: json
        *
        */
        private function montarJson( $rota ){

            $json["custo"] = array_pop($rota);
            $json["rota"] = implode(" ", $rota);

            return json_encode( $json);

        }

        /*
        *
        *   Método público: busca a melhor rota da origem ao destino informados
        *   Parâmetros: null
        *   Retorno: json
        *
        */
        public function calcularMelhorRota(){

            $rotasPossiveis = $this->buscarRotasPossiveis( $this->origem );

            $melhorRota = array();

            // percorre as rotas possíveis, destrinchando as matrizes 
            foreach ($rotasPossiveis as $origemRota => $caminhos) { 

                $arraySimples =  $this->destrincharMatriz( $origemRota , $caminhos );                 
                $melhorRota =   $this->verificarMenorTrecho( $arraySimples , $melhorRota );

            }

            // adiciona no início do array a origem inicial
            array_unshift($melhorRota, $this->origem);

            // coloca no último valor do array o custo da rota inteira
            $melhorRota[ count($melhorRota) - 1 ] = $this->calcularPrecoRota( end($melhorRota) );

            return $this->montarJson( $melhorRota );
        }



        
    }

?>