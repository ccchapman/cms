<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

use \craft\elements\Entry;

return [
    [
        'sectionId' => '1000',
        'typeId' => '1000',
        'title' => 'Theories of life',
    ],

    // Deleted
    [
        'sectionId' => '1000',
        'typeId' => '1000',
        'title' => 'Deleted today',
        'dateDeleted' => (new DateTime('now'))->format('Y-m-d H:i:s')
    ],
    [
        'sectionId' => '1000',
        'typeId' => '1000',
        'title' => 'Deleted 40 days ago',
        'dateDeleted' => (new DateTime('now'))->sub(new DateInterval('P40D'))->format('Y-m-d H:i:s')
    ],
    [
        'sectionId' => '1000',
        'typeId' => '1000',
        'title' => 'Deleted 25 days ago',
        'dateDeleted' => (new DateTime('now'))->sub(new DateInterval('P25D'))->format('Y-m-d H:i:s')
    ],

    [
        'sectionId' => '1003',
        'typeId' => '1003',
        'title' => 'With URL 1',
    ],
    [
        'sectionId' => '1003',
        'typeId' => '1003',
        'title' => 'With URL 2',
    ],

    [
        'sectionId' => '1003',
        'typeId' => '1003',
        'title' => 'Pending 1'
    ],
    [
        'sectionId' => '1003',
        'typeId' => '1003',
        'title' => 'Pending 2'
    ],
];
