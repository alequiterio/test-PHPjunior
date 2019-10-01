<!DOCTYPE html>
<html>
	<head>
		<title>logistica de rotas - API</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="assets/style.css">
	</head>
	<body>
		<header class="bloco-fixo" > 
			<section class="box" >
				<h1> API Logistica de Rotas <small>1.0.0</small> </h1>
			</section>
		</header>

		<main>
			
			<section class="box">
				
				<p>
					API Logistica de  Rotas é um projeto estruturado a fim de teste, referente a vaga de php jr.
 					<br>
					Sua função é calcular a melhor rota a partir dos dados passados, sendo eles o <b> ponto de origem</b>, o <b> ponto de destino</b>, <b> autonomia do veículo(km/l)</b> e o <b> valor do litro do combustível</b>, de forma que o retorno sempre seja a rota de menor custo. 
				</p>

			</section>

			<section class="box">

				<p>
					<h2>Colaboradores</h2>

					<ul>
						<li><a href="https://github.com/alequiterio" target="_blank" title="GitHub de Ale Quiterio" >Ale Quiterio</a></li>
					</ul>
					
				</p>
				

			</section>

			<section class="box">

				<p>
					<h2>Avisos</h2>

					Caso ocorra algum erro no api entre em contato com Ale Quiterio 
					
				</p>				

			</section>

			<section class="box">

				<p>
					<h2>Instalação</h2>

					Clone este repositório e hospede em alguma rede local ou servidor. Para fazer qualquer requisição à API, use sua rede + <b> /API Logistica de Rotas/api/ </b>. Como no exemplo localhost:
				
					<div class="card" >
						http://<b>localhost</b>/API Logistica de Rotas/api <small class="card__description"> Todas as requisições usaram essa base</small>
					</div>
					
				</p>				

			</section>

			<section class="box">

				<p>
					<h2>Requisição</h2>

					Para consultar a melhor rota, você deve fazer uma requisição à API pelo método <b>POST</b> ou se utilizar o <b>POSTMAN</b> selecione no <b>BODY</b> o <b>raw</b>, enviando um <b>JSON</b> da seguinte forma:

					<div class="card" >
						<div class="card__method">POST</div>
						/rota/consultar <small class="card__description"> Busca a rota com menor custo</small>
					</div>

					<code>
						<div class="code__title"> Parâmetros: JSON </div>
						<pre class="code__main">
	{
	    "origem" : "A",
	    "destino" : "D",
	    "autonomia" : 10,
	    "preco": 2.5
	}
						</pre>
					</code>

					<code>
						<div class="code__title"> Retorno: JSON </div>
						<pre class="code__main">
	{
	    "custo": 6.25,
	    "rota": "A B D"
	}
						</pre>
					</code>
					
				</p>				

			</section>

			<section class="box">

				<p>
					<h2>Lista de parâmetros</h2>

					<table border="1" class="tabela">
						<tr>
							<th>Nome</th>
							<th>Tipo</th>
							<th>Descrição</th>
						</tr>
						<tr>
							<td>origem</td>
							<td>String</td>
							<td>Ponto de partida</td>
						</tr>
						<tr>
							<td>destino</td>
							<td>String</td>
							<td>Ponto de chegada</td>
						</tr>
						<tr>
							<td>autonomia</td>
							<td>Integer</td>
							<td>Km que o automóvel gasta por litro</td>
						</tr>
						<tr>
							<td>preco</td>
							<td>Float</td>
							<td>Valor do litro</td>
						</tr>
					</table>
					
				</p>				

			</section>

			<section class="box">

				<p>
					<h2>Lista de retornos</h2>

					<table border="1" class="tabela">
						<tr>
							<th>Nome</th>
							<th>Tipo</th>
							<th>Descrição</th>
						</tr>
						<tr>
							<td>custo</td>
							<td>Float</td>
							<td>Preço total da viagem</td>
						</tr>
						<tr>
							<td>rota</td>
							<td>String</td>
							<td>Pontos pelos quais o veículo passará</td>
						</tr>
					</table>
					
				</p>				

			</section>

			<section class="box">

				<p>
					<h2>Lista de erros</h2>

					<table border="1" class="tabela">
						<tr>
							<th>Mensagem</th>
							<th>Descrição</th>
						</tr>
						<tr>
							<td>Não foi possível completar o cálculo, pois faltam argumentos</td>
							<td>Algum dos parâmetros não foi enviado pelo POST</td>
						</tr>
						<tr>
							<td>O formato esperado para 'origem' é string</td>
							<td>O parâmetro 'origem' não é no tipo string</td>
						</tr>
						<tr>
							<td>O formato esperado para 'destino' é string</td>
							<td>O parâmetro 'destino' não é do tipo string</td>
						</tr>
						<tr>
							<td>O formato esperado para 'autonomia' é int</td>
							<td>O parâmetro 'autonomia' não é do tipo int</td>
						</tr>
						<tr>
							<td>O formato esperado para 'preco' é float</td>
							<td>O parâmetro 'preco' não é do tipo float</td>
						</tr>
						<tr>
							<td>O destino não pode ser o mesmo que a origem</td>
							<td>Os parâmetros de origem e destino são iguais</td>
						</tr>
						<tr>
							<td>Não existem origens</td>
							<td>O ponto de origem não foi encontrado</td>
						</tr>
						<tr>
							<td>Internal Server Error</td>
							<td>Algum problema que não foi solucionado ocorreu</td>
						</tr>
					</table>
					
				</p>				

			</section>

		</main>

	</body>
</html>