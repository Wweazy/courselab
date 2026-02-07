<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class LanguageController extends AbstractController
{
    #[Route('/lang/{_locale}', name: 'lang_switch', requirements: ['_locale' => 'pl|en'])]
    public function switch(Request $request, SessionInterface $session, string $_locale): RedirectResponse
    {
        $session->set('_locale', $_locale);

        $referer = $request->headers->get('referer');
        return $this->redirect($referer ?? $this->generateUrl('home'));
    }
}
