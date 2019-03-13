<?php declare(strict_types=1);
namespace App\Presenters;

use App\Model\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Nette;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{
    /** @var EntityManagerInterface @inject */
    public $entityManager;

    public function actionDefault(): void
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $this->template->posts = $postRepository->findBy([], ['postedAt' => 'DESC']);
    }
}
