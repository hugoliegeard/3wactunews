<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/administration')]
#[IsGranted('ROLE_ADMIN')]
class AdminController
{
    #[Route('/dashboard', name: 'admin_dashboard', methods: ['GET'])]
    public function dashboard(): Response
    {
        return new Response("<h1>Dashboard</h1>");
    }
}
