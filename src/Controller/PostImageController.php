<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]

class PostImageController
{

    public function __invoke(Request $request)
    {
        $post = $request->attributes->get('data');
        
        // $file = $request->files->get('file');
        $post->setFile($request->File->get('file'));

        return $post;
    }

} 

// final class PostImageController extends AbstractController
// {

//     public function __invoke(Request $request): Posts
//     {

//         $post = $request->files->get('file');

//         if (!($post)) {
//             throw new BadRequestHttpException('"file" is required');
//         }

//         $postObject = new Posts();
//         $postObject->file = $post;

//         return $postObject;
//     }
// } 
