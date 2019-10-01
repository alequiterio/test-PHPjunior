# API logistica de rotas
 API logistica de rotas é um projeto sem fins lucrativos, destinado a resolver um desafio proposto. Sua função é calcular a melhor rota a partir dos dados passados, sendo eles o ponto de origem, o ponto de destino, autonomia do veículo(km/l) e o valor do litro do combustível, de forma que o retorno sempre seja a rota de menor custo.


## Tecnologias Utilizadas
* PHP
* JSON

## Requisitos
* Rodar a aplicação em um servidor com PHP

## Estrutura de pastas
* /api/
    * /dados/
        * rotas.json
    * /objetos/
        * rota.php
    * /rota/
        * /consultar/
            * index.php
* /assets/
    * style.css
* index.php

### O que há em cada pasta
Dentro da pasta **/api** contém tudo necessário para o seu funcionamento:
1. Pasta **/dados** com o JSON usado como base de dados
2. Pasta **/objetos** com a classe Rota usada para toda a inteligência por trás da API
3. Pasta **/rota**, que por sua vez possui a pasta **/consultar** que possui um arquivo chamado **index.php**. Essa sequência deixa a url limpa, já que neste index.php que ocorre a chamada à API

Dentro da pasta **assets** tem arquivos referentes à documentação:
1. Arquivo **style.css** contém o estilo da documentação.

E por fim o **index.php** com o html da documentação.

## Utilização
Leia a documentação da API que existe na raiz deste repositório.