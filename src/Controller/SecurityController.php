<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;  // Asegúrate de usar la correcta importación de la ruta
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    // Ruta para la página de login
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtiene el último error de autenticación y el último nombre de usuario ingresado
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Registra el error de autenticación en los logs si existe
        if ($error) {
            error_log('Error de autenticación: ' . $error->getMessage());
        }

        // Renderiza la vista del formulario de login y pasa las variables de error y último nombre de usuario
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    // Ruta para el logout (aunque no se necesita hacer nada explícito aquí)
    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Symfony intercepta esta ruta automáticamente, no es necesario implementar lógica aquí
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
