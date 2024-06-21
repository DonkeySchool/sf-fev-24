<?php

namespace App\EventListener;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: Category::class)]
final class CategoryListener
{
    public function __construct(
        #[Autowire(env: 'FILE_PATH')]
        private string $filePath
    ) {}

    public function postPersist(Category $category): void
    {
    }
}
