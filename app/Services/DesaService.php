<?php

use App\Repositories\Interfaces\DesaRepositoryInterface;

class DesaService {

    protected DesaRepositoryInterface $desaRepository;

    public function __construct(DesaRepositoryInterface $desaRepository)
    {
        $this->desaRepository = $desaRepository;
    }
}
