<?php
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Form\FormBuilderInterface;

class LoginFormType
{
    private $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [
                'label' => 'Username',
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Password',
            ])
            ->add('_csrf_token', HiddenType::class, [
                'data' => $this->csrfTokenManager->getToken('authenticate')->getValue(),
            ])
            ->add('login', SubmitType::class, [
                'label' => 'Login',
            ]);
    }
}