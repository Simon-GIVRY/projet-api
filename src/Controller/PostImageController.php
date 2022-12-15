<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
#[Route()]
class PostImageController extends AbstractController
{

    public function __invoke(Request $request)
    {

        $post = $request->attributes->get('data');
        
        if (!($post instanceof Posts)) {
            throw new \RuntimeException("Article attendue");
        }

        // $file = $request->files->get('file');
        $post->setImageFile($request->files->get('file'));

        return $post;
    }

} 