<?php
namespace Oyster;

use \Approach\Render\HTML;
use \Oyster\Render\Header;
use \Oyster\Render\Oyster;
use \Oyster\Render\Pearl;
use \Oyster\Render\Visual;

require_once __DIR__ . '/support/lib/vendor/autoload.php';
require_once __DIR__ . '/layout.php';
require_once __DIR__ . '/head.php';
global $body;

$body[] = $new = new HTML(tag: 'div', classes: ['Stage']);

$newHeader = new Header(crumbs: ['Home', 'About', 'Contact']);

$visual = new Visual(title: 'Wow');
$otherVisual = new Visual(title: 'Cool');
$coolVisual = new Visual(title: 'Nice');

$list1 = new Pearl(visual: $visual, label: 'List 1');
$list2 = new Pearl(visual: $coolVisual, label: 'List 2');

$wow = new Pearl(visual: $otherVisual, label: 'Wow');

$list1->addPearl($wow);
$list1->addPearl($list2);

$oyster = new Oyster(header: $newHeader, pearls: $list1);

$new[] = $oyster;
echo $webpage->render();
