<?php
return [
    'routes' => [
        ['name' => 'skeleton#getSkeletonContents', 'url' => '/getSkeletonContents', 'verb' => 'GET'],
        ['name' => 'skeleton#updateSkeletonContents', 'url' => '/updateSkeletonContents', 'verb' => 'POST'],
        ['name' => 'skeleton#deleteSkeletonFile', 'url' => '/deleteSkeletonFile', 'verb' => 'POST'],
        ['name' => 'skeleton#uploadSkeletonFile', 'url' => '/uploadSkeletonFile', 'verb' => 'POST'],
    ]
];
