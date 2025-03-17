<?php
require_once "conecta.php";

/* Lógica/Funções para o CRUD de Fabricantes */

//listarFabricantes: usada pela página fabricantes/vizualizar.php
function listarFabricantes(PDO $conexao):array{
   $sql = "SELECT * FROM fabricantes ORDER BY nome";

   try {
      //Preparando o comando SQL ANTES de executar no servidor e guardando em memória (variável consulta ou query)
   $consulta = $conexao->prepare($sql);

   //Executando o comando de banco de dados
   $consulta->execute();

   //Busca/Retorna todos os dados provenientes da execução da consulta e os transforma em um array associativo
   return $consulta->fetchAll(PDO::FETCH_ASSOC);

   } catch (Exception $erro) {
      die("Erro: ".$erro->getMessage());
   }

}

//inserirFabricantes: usada pela página fabricantes/vizualizar.php
function inserirFabricantes(PDO $conexao, string $nomeDoFabricante):void {
   /* :named parameter (parâmetro nomeado) 
   Usamos este recurso do PDO para 'reservar' um espaço seguro em memória para colocação do lado. NUNCA passe de forma direta valores para comandos SQL.
   */
   
  $sql = "INSERT INTO fabricantes(nome) VALUE(:nome)";

  try {
   $consulta = $conexao->prepare($sql);

   /* bindValue() -> permite vincular o valor do parâmetro à consulta que será executada.É necessário indicar qual é o parâmetro (:nome), de onde vem o valor ($nomeDoFAbricante) e de que tipo ele é (PDO:PARAM_STR) */
   $consulta->bindValue(":nome", $nomeDoFabricante, PDO::PARAM_STR);

   $consulta->execute();
  } catch (Exception $erro) {
   die ("Erro ao inserir: ".$erro->getMessage());
  
  }

}

//listarUmFabricante:usada pela página fabricantes/atualizar.php
function listarFabricante(PDO $conexao, int $idFabricante):array {
   $sql = "SELECT * FROM fabricantes WHERE id = :id";

   try {
      $consulta = $conexao->prepare($sql);
      $consulta->bindValue(":id", $idFabricante, PDO::PARAM_INT);
      $consulta->execute();

      //Usamos o fetch para garantir o retorno de um único array associativo com o resultado.
      return $consulta->fetch(PDO::FETCH_ASSOC);
   } catch (Exception $erro) {
   die("Erro ao careegar fabricante: ".$erro->getMessage());
      
   }
}