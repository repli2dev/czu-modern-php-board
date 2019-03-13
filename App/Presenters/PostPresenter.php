<?php declare(strict_types=1);
namespace App\Presenters;

use App\Model\Entity\Post;
use App\Model\Entity\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Nette;


final class PostPresenter extends Nette\Application\UI\Presenter
{
    /** @var EntityManagerInterface @inject */
    public $entityManager;

    public function actionNew(): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
    }

    public function actionToggle(int $id): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
        $postRepository = $this->entityManager->getRepository(Post::class);
        /** @var Post $post */
        $post = $postRepository->find($id);
        if ($post === null) {
            throw new Nette\Application\BadRequestException();
        }
        if ($post->getUser()->getId() !== $this->user->getId()) {
            throw new Nette\Application\ForbiddenRequestException();
        }
        $post->toggleActive();
        $this->entityManager->persist($post);
        $this->entityManager->flush();
        if ($post->isActive()) {
            $this->flashMessage('Příspěvek zaktivněn.');
        } else {
            $this->flashMessage('Příspěvek zneaktivněn.');
        }
        $this->redirect('Homepage:');
    }

    public function actionDelete(int $id): void
    {
        if (!$this->user->isLoggedIn()) {
            $this->redirect('Homepage:');
        }
        $postRepository = $this->entityManager->getRepository(Post::class);
        /** @var Post $post */
        $post = $postRepository->find($id);
        if ($post === null) {
            throw new Nette\Application\BadRequestException();
        }
        if ($post->getUser()->getId() !== $this->user->getId()) {
            throw new Nette\Application\ForbiddenRequestException();
        }
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        $this->flashMessage('Příspěvek smazán.');
        $this->redirect('Homepage:');
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
            // Find user using repository
            $userRepository = $this->entityManager->getRepository(User::class);

            /** @var User $userEntity */
            $userEntity = $userRepository->find($this->user->getId());

            $post = new Post(
                $values->type,
                $values->title,
                $values->content,
                new DateTime(),
                true,
                $userEntity
            );
            // Stage all changes to be saved on flush
            $this->entityManager->persist($post);

            // Flush (save) staged data to the database
            $this->entityManager->flush();

            // Show success message and redirect (to prevent duplicate insertions caused by F5)
            $this->flashMessage('Příspěvek byl vložen.', 'success');
            $this->redirect('Homepage:');
        };

        return $form;
    }
}
