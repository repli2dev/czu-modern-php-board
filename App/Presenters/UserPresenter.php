<?php declare(strict_types=1);
namespace App\Presenters;

use App\Model\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Nette;
use Nette\Application\UI\Form;


final class UserPresenter extends Nette\Application\UI\Presenter
{
    /** @var EntityManagerInterface @inject */
    public $entityManager;

    public function actionLogin(): void
    {
        if ($this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
    }

    public function actionLogout(): void
    {
        $this->user->logout(true);
        $this->flashMessage('Byli jste odhlášeni.', 'success');
        $this->redirect('User:login');
    }


    public function createComponentLoginForm(): Form
    {
        $form = new Form();
        $form->addText('username', 'Uživatelské jméno')
            ->setRequired('Vyplňte, prosím, pole uživatelské jméno');
        $form->addPassword('password', 'Heslo')
            ->setRequired('Zadejte, prosím, heslo.');
        $form->addSubmit('submitted', 'Přihlásit');
        $form->onSuccess[] = function (Form $form, Nette\Utils\ArrayHash $values): void {
            // Find user using repository
            $userRepository = $this->entityManager->getRepository(User::class);
            /** @var User $userEntity */
            $userEntity = $userRepository->findOneBy(['username' => $values->username]);
            // Check if we found something
            if ($userEntity === null) {
                $form->addError('Takový uživatel neexistuje.');
                return;
            }
            // Check if password matches
            if (!$userEntity->matchesPassword($values->password)) {
                $form->addError('Špatné heslo.');
            }
            // Login user
            $identity = new Nette\Security\Identity($userEntity->getId(), [], ['username' => $userEntity->getUsername()]);
            $this->user->login($identity);
            $this->redirect('Homepage:');
        };
        return $form;
    }
}
