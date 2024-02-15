<?php
namespace Oyster;

use \Approach\Render\HTML;
use \Oyster\Render\Header;
use \Oyster\Render\ListEle;
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

$list1 = new Pearl(visual: $visual, label: 'List 1');

$wow = new Pearl(visual: $visual, children: $list1, label: 'Wow');
$wow->children['List 2'] = new Pearl(visual: $visual, label: 'List 2');

$oyster = new Oyster(header: $newHeader, pearls: $wow);

$new[] = $oyster;
echo $webpage->render();
