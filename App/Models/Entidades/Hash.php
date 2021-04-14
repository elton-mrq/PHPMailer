<?php

namespace App\Models\Entidades;

class Hash
{
    private $id;
    private $hash;
    private $status;
    private $idUsuario;
    private $dataCadastro;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
  
    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash)
    {
        $this->hash = $hash;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getIdUsuario()
    {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function getDataCadastro()
    {
        return new \DateTime($this->dataCadastro);
    }

    public function setDataCadastro($dataCadastro)
    {
        $this->dataCadastro = $dataCadastro;
    }
}