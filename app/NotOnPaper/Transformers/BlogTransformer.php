<?php
namespace NotOnPaper\Transformers;

use League\Fractal\TransformerAbstract;

class BlogTransformer extends TransformerAbstract {

    public function transform($blog)
    {
        return [
            'title' => $blog['title'],
            'body'  => $blog['body'],
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/blogs/' . $blog['id'],
                ],
            ]
        ];
    }
}