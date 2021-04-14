<?php

namespace App\Models\DAO;

use App\Lib\Conexao;
use PDOException;

abstract class BaseDAO
{
    
    private $connection;
    private $table;

    public function __construct($table)
    {
        $this->connection = Conexao::getConnection();
        $this->table = $table;
    }

    
    /**
     * Método responsável por executar as queries
     *
     * @param string $query
     * @param array $params
     * @return smtp
     */
    private function execute($query, $params = [])
    {
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            die('Erro ao executar a query: ' . $e->getMessage());
        }
    }

    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        $where = strlen($where) ? ' WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';

        $query = "SELECT {$fields} FROM {$this->table} {$where} {$order} {$limit}";

        return $this->execute($query);
    }


    /**
     * Método responsável por inserir dados no banco
     * @param string $table
     * @param array $values
     * @return smtp
     */
    public function insert($values)
    {
        if(!empty($values)){

            //Retorna as chaves do array que representam os
            //campos da tabela
            $fields = array_keys($values);
            
            //Insere '?' em um array vazio, conforme quantidade de $fields
            $binds = array_pad([], count($fields), '?');

            //Monta o insert
            $query = 'INSERT INTO ' . $this->table . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

            //Invoca o método que executa a query
            $smtp =  $this->execute($query, array_values($values));     
            
            return $smtp->rowCount();

        }else{

            return false;
            
        }
    }

    public function update($where, $values)
    {
        if(!empty($where) && !empty($values)){
            
            $fields = array_keys($values);

            $query = "UPDATE $this->table SET " . implode(' = ?', $fields) . " = ? WHERE $where";

            $smtp = $this->execute($query, array_values($values));

            return $smtp->rowCount();

        } else {
            return false;
        }

    }

    public function delete($where)
    {
        if(!empty($where)){

            $query = "DELETE FROM {$this->table} WHERE {$where}";

            return $this->execute($query);

        }else {

            return false;

        }
    }

}
