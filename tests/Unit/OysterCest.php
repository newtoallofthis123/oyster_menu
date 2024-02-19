<?php


namespace Tests\Unit;

use Oyster\Render\Header;
use Oyster\Render\Oyster;
use Oyster\Render\Pearl;
use Oyster\Render\Visual;
use Tests\Support\UnitTester;

class OysterCest
{
    public function _before(UnitTester $I)
    {
    }

    // tests
    public function checkOyster(UnitTester $I)
    {
        $pearl1 = new Pearl(visual: new Visual(title: 'Wow'), label: 'Wow');

        $oyster = new Oyster(
            header: new Header(),
            pearls: $pearl1,
        );

        $expected = <<<HTML
<div><section class=" header"><ul class="Toolbar"><button class="btn btn-secondary current-state ms-2 animate__animated animate__slideInDown" id="menuButton"><span id="menuButtonText">Location</span><i class="fa fa-caret-down"></i></button><div class="signOut"><button>
    <p>
        <i class="bi bi-box-arrow-right"></i> SignOut
    </p>
</button></div></ul></section><ul class="Shell Toolbar"><li data-pearl="Wow"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Wow</label><i class="expand fa fa-angle-right"></i></div></li><li data-pearl="Cool"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Cool</label><i class="expand fa fa-angle-right"></i></div></li></ul></div>
HTML;
    }

    public function checkOysterChildPearl(UnitTester $I)
    {
        $visual = new Visual(title: 'Parent');
        $pearl = new Pearl(visual: $visual, label: 'Parent');
        $child1 = new Pearl(visual: new Visual(title: 'Child1'), label: 'Child 1');
        $child2 = new Pearl(visual: new Visual(title: 'Child2'), label: 'Child 2');

        $grandChild1 = new Pearl(visual: new Visual(title: 'GrandChild1'), label: 'GrandChild 1');
        $grandChild2 = new Pearl(visual: new Visual(title: 'GrandChild2'), label: 'GrandChild 2');

        $child1->addPearl($grandChild1);
        $child1->addPearl($grandChild2);

        $pearl->addPearl($child1);
        $pearl->addPearl($child2);

        $oyster = new Oyster(
            header: new Header(),
            pearls: $pearl,
        );
        
        $expected = <<<HTML
<div><section class=" header"><ul class="Toolbar"><button class="btn btn-secondary current-state ms-2 animate__animated animate__slideInDown" id="menuButton"><span id="menuButtonText">Location</span><i class="fa fa-caret-down"></i></button><div class="signOut"><button>
    <p>
        <i class="bi bi-box-arrow-right"></i> SignOut
    </p>
</button></div></ul></section><ul class="Shell Toolbar"></ul></div>
HTML;

        $I->assertEquals($expected, $oyster->render());
    }
}
