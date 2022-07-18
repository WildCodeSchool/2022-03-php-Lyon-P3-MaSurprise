<?php

namespace App\Service;

use App\Form\SearchCakeFormType;
use App\Repository\CakeRepository;
use App\Repository\DepartmentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CakeSearchService
{
    private CakeRepository $cakeRepository;

    public function __construct(CakeRepository $cakeRepository)
    {
        $this->cakeRepository = $cakeRepository;
    }

    public function cakeSearch(mixed $search, mixed $department): mixed
    {
        // initializing cakes
        $cakes = [];
        // if KEYWORD is set and DEPARTMENT is not
        if (!empty($search) && (empty($department))) {
            $cakes = $this->cakeRepository->findLikeAll($search);
            // if DEPARTMENT is set and KEYWORD is not
        } elseif (!empty($department) && (empty($search))) {
            $cakes = $this->cakeRepository->findByDepartment($department);
            // if both DEPARTMENT and KEYWORD are set
        } elseif (!empty($search) && (!empty($department))) {
            $cakes = $this->cakeRepository->findLikeAllWithLocation($search, $department);
            // if neither KEYWORD nor DEPARTMENT are set
        } elseif (empty($search) && (empty($department))) {
            // if search is empty, display everything
            $cakes = $this->cakeRepository->findAll();
        }
        return $cakes;
    }
}
