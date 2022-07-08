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

    public function cakeSearch(
        $search, $department
    ): array {    
        // if KEYWORD is set and DEPARTMENT is not
        if (isset($search) && (empty($department))) {
            $cakes = $this->cakeRepository->findLikeName($search);
            $cakes += $this->cakeRepository->findLikeDescription($search);
            $cakes += $this->cakeRepository->findLikeBaker($search);
            // if DEPARTMENT is set and KEYWORD is not
        } elseif (isset($department) && (empty($search))) {
            $cakes = $this->cakeRepository->findByDepartment($department);
            // if both DEPARTMENT and KEYWORD are set
        } elseif (isset($search) && (isset($department))) {
            $cakes = $this->cakeRepository->findLikeNameWithLocation($search, $department);
            $cakes += $this->cakeRepository->findLikeDescriptionWithLocation($search, $department);
            $cakes += $this->cakeRepository->findLikeBakerWithLocation($search, $department);
            // if neither KEYWORD nor DEPARTMENT are set
        } elseif (empty($search) && (empty($department))) {
            // if search is empty, display everything
            $cakes = $this->cakeRepository->findAll();
        }
        return $cakes;
    }
}
