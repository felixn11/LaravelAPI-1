<?php
namespace NotOnPaper\Transformers;

use League\Fractal\TransformerAbstract;

class LessonTransformer extends TransformerAbstract {

    public function transform($lesson)
    {
        return [
            'title' => $lesson['title'],
            'body'  => $lesson['body'],
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => '/lessons/' . $lesson['id'],
                ],
            ]
        ];
    }
}