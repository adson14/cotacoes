<?php

namespace App\Repositories;

use App\Models\Historico;

class HistoricoRepository
{

    protected $entity;

    public function __construct(Historico $historico)
    {
        $this->entity = $historico;
    }

    public function getAll()
    {
        return $this->entity->get();
    }

    public function create(array $data)
    {
        return $this->entity->create($data);
    }

    public function find(array $where)
    {
        return $this->entity->where($where)->orderBy('id','DESC')->get();
    }
}