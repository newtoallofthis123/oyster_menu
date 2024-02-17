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
$coolVisual1 = new Visual(title: 'Child 1');
$coolVisual2 = new Visual(title: 'Child 2');
$coolVisual3 = new Visual(title: 'Parent');

$list1 = new Pearl(visual: $visual, label: 'List 1');
$list2 = new Pearl(visual: $coolVisual, label: 'List 2');

$pearl = new Pearl(visual: $visual, label: 'Wow');

$wow = new Pearl(visual: $otherVisual, label: 'Wow');
$parent = new Pearl(visual: $coolVisual3, label: 'Parent');
$child1 = new Pearl(visual: $coolVisual1, label: 'Child 1');
$child2 = new Pearl(visual: $coolVisual2, label: 'Child 2');

$parent->populate([['visual' => 'Hello', 'label' => 'World', 'children' => [$child1, $child2]]]);

$oyster = new Oyster(header: $newHeader, pearls: [$list1, $parent]);

$new[] = $oyster;
echo $webpage->render();
