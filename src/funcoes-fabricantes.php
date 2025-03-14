<?php
require_once "conecta.php";

/* Lógica/Funções para o CRUD de Fabricantes */

//listarFabricantes: usada pela página fabricantes/vizualizar.php
function listarFabricantes(PDO $conexao):array{
   $sql = "SELECT * FROM fabricantes";

   //Preparando o comando SQL ANTES de executar no servidor e guardando em memória (variável consulta ou query)
   $consulta = $conexao->prepare($sql);

   //Executando o comando de banco de dados
   $consulta->execute();

   //Busca/Retorna todos os dados provenientes da execução da consulta e os transforma em um array associativo
   return $consulta->fetchAll(PDO::FETCH_ASSOC);
}