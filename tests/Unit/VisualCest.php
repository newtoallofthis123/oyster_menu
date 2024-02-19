<?php


namespace Tests\Unit;

use Oyster\Render\Visual;
use Tests\Support\UnitTester;

class VisualCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function checkVisualRendering(UnitTester $I)
    {
        $visual = new Visual(title: 'Wow');

        $toGet = <<<HTML
<div class=" visual"><i class="icon bi bi-list-check"></i><label>Wow</label><i class="expand fa fa-angle-right"></i></div>
HTML;   

        $I->assertEquals('Wow', $visual->title);
        $I->assertEquals($toGet, $visual->render());
    }
}
