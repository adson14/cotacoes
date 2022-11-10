<?php

namespace App\Services;

use App\Repositories\HistoricoRepository;

class HistoricoService
{

    protected $repository;

    public function __construct(HistoricoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listar()
    {
        return $this->repository->getAll();
    }

    public function gravar(array $data)
    {
        return $this->repository->create($data);
    }

    public function buscar(array $where)
    {
        return $this->repository->find($where);
    }
}