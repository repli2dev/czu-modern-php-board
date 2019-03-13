<?php declare(strict_types=1);
namespace App\Presenters;

use Nette;


final class PostPresenter extends Nette\Application\UI\Presenter
{
    public function actionNew(): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
    }

    public function createComponentPostForm(): Nette\Application\UI\Form
    {
        $form = new Nette\Application\UI\Form();
        $form->addSelect('type', 'Typ', [
            'offer' => 'Nabídka',
            'demand' => 'Poptávka',
            'other' => 'Ostatní',
        ]);
        $form->addText('title', 'Titulka')
            ->setRequired('Vyplňte, prosím, titulku příspěvku');
        $form->addTextArea('content', 'Obsah', 50, 10)
            ->setRequired('Vyplňte, prosím, obsah příspěvku');

        $form->addSubmit('submitted', 'Odeslat');
        $form->onSuccess[] = function (Nette\Application\UI\Form $form, Nette\Utils\ArrayHash $values) {
            if (!$this->user->isLoggedIn()) {
                throw new Nette\Application\ForbiddenRequestException();
            }
        };

        return $form;
    }
}
