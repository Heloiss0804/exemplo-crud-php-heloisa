<?php
require_once "conecta.php";

function listarProdutos(PDO $conexao):array {
 // $sql = "SELECT * FROM produtos";
    $sql = "SELECT 
                produtos.id, produtos.nome AS produto,  
                produtos.preco, produtos.quantidade, 
                fabricantes.nome AS fabricante
            FROM produtos INNER JOIN fabricantes
            ON produtos.fabricante_id = fabricantes.id
            ORDER BY produto";
                

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->execute();
    return $consulta->fetchAll(PDO::FETCH_ASSOC);


  } catch (Exception $erro) {
    die("Erro ao carregar produtos: ".$erro->getMessage());
  }

}


function inserirProduto(PDO $conexao, string $nome, float $preco, int $quantidade, int $idFabricante, string $descricao):void { 
  $sql = 
  "INSERT INTO produtos(nome,preco,quantidade,fabricante_id,descricao) VALUES (:nome, :preco, :quantidade, :fabricante, :descricao)";

      try{
        $consulta = $conexao->prepare($sql);
        $consulta ->bindValue (":nome", $nome, PDO::PARAM_STR ) ;
        $consulta ->bindValue(":preco", $preco, PDO::PARAM_STR);
        $consulta ->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
        $consulta ->bindValue(":fabricante", $idFabricante, PDO::PARAM_INT);
        $consulta ->bindValue(":descricao", $descricao, PDO:: PARAM_STR);

        $consulta->execute();

      }
      catch(Exception $erro){
        die("Erro ao inserir produto: " .$erro->getMessage());
      }

}

function listarUmProduto(PDO $conexao, int $idProduto):array{
  /* Eu estava tentando selecionar a tabela "produto",e na real era tabela no plural "produtos". */
  $sql = "SELECT * FROM produtos WHERE id= :id";

  try {
    $consulta = $conexao->prepare($sql);
    $consulta->bindValue(":id", $idProduto, PDO::PARAM_INT);
    $consulta->execute();
    //Usar somente Fetch para chamar um só linha de registro, não todos como estava antes fetchAll (chama todos os registros constam na tabela)
    //Usamos o fetch para garantir o retorno de um único array associativo com o resultado
    return $consulta->fetch(PDO::FETCH_ASSOC);
 } catch (Exception $erro) {
   die("Erro ao carregar produto: ".$erro->getMessage());
 }
};


//Atualizando o produro
 function atualizarProduto(PDO $conexao, int $idproduto, string $nome, float $preco, int $quantidade, int $idFabricante, string $descricao):void { 
  $sql = 
  "UPDATE produtos SET
   nome = :nome,
   preco = :preco,
   quantidade = :quantidade,
   fabricante_id = :fabricante_id,
   descricao = :descricao  
   WHERE id = :id";

      try{
        $consulta = $conexao->prepare($sql);
        $consulta ->bindValue (":nome", $nome, PDO::PARAM_STR ) ;
        $consulta ->bindValue(":preco", $preco, PDO::PARAM_STR);
        $consulta ->bindValue(":quantidade", $quantidade, PDO::PARAM_INT);
        $consulta ->bindValue(":fabricante_id", $idFabricante, PDO::PARAM_INT);
        $consulta ->bindValue(":id", $idproduto, PDO::PARAM_INT);
        $consulta ->bindValue(":descricao", $descricao, PDO:: PARAM_STR);

        $consulta->execute();

      }
      catch(Exception $erro){
        die("Erro ao atualizar produto: " .$erro->getMessage());
      }
    }

    //Excluindo produto
    function excluirProduto(
      PDO  $conexao, int $idProduto):void {
      $sql = "DELETE FROM produtos WHERE id = :id";
    
      try {
        $consulta = $conexao->prepare($sql);
        $consulta->bindValue(":id", $idProduto, PDO::PARAM_INT);
        $consulta->execute();
    
        
      } catch (Exception $erro) {
        die("Erro ao excluir produtos: ".$erro->getMessage());
      }
    
    }
?>