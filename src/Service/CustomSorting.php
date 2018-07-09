<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CustomSorting {
    private $title = "";
    private $sortFields = [];
    private $sort;
    private $direction = 'ASC';

    public function getData(){
        if(empty($this->title)) throw new \Exception("CustomSorting : Vous n'avez pas précisé de titre !");
        if(empty($this->sortFields)) throw new \Exception("CustomSorting : Vous n'avez pas précisé les champs triables !");
        return [
            'title'         => $this->title,
            'sortFields'    => $this->sortFields,
            'directions'    => ['ASC' => 'Ascendant', 'DESC' => 'Descendant'],
            'sort'          => $this->sort,
            'direction'     => $this->direction
        ];
    }

    public function __construct(RequestStack $requestStack) {
        $request = $requestStack->getCurrentRequest();
        $this->sort         = $request->query->get('sort');
        $this->direction    = $request->query->get('direction') ?? 'ASC';
    }

    public function setSort(string $sort): self {
        $this->sort = $sort;
        return $this;
    }

    public function setSortFields(array $sortFields): self {
        $this->sortFields = $sortFields;
        return $this;
    }

    public function setTitle(string $title): self {
        $this->title = $title;
        return $this;
    }

}