<?php

return [
    'application' => [
        'tag' => [
            'application_tag' => 'application_id = application.id', 
            'tag' => 'tag_id = tag.id'
        ],
        'author' => 'author.id = author_id'
    ],
    'author' => [
        'application' => ['application' => 'author_id  = author.id']
    ],
    'tag' => [
        'application' => [
            'application_tag' => 'tag_id = tag.id', 
            'application' => 'application_id = application.id'
        ]
    ]
];