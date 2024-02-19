<?php


namespace Tests\Unit;

use Oyster\Render\Pearl;
use Oyster\Render\Visual;
use Tests\Support\UnitTester;

class PearlCest
{
    // tests
    public function checkPearlRender(UnitTester $I)
    {
        $visual = new Visual(title: 'Wow');
        $pearl = new Pearl(visual: $visual, label: 'List 1');

        $expected = <<<HTML
<li data-pearl="List 1"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Wow</label><i class="expand fa fa-angle-right"></i></div></li>
HTML;
        $I->assertEquals($expected, $pearl->render());
        
        return;
    }

    public function checkPearlChildren(UnitTester $I){
        $visual = new Visual(title: 'Parent');
        $pearl = new Pearl(visual: $visual, label: 'Parent');
        $child1 = new Pearl(visual: new Visual(title: 'Child1'), label: 'Child 1');
        $child2 = new Pearl(visual: new Visual(title: 'Child2'), label: 'Child 2');
    
        $pearl->addPearl($child1);
        $pearl->addPearl($child2);

        $expected = <<<HTML
<li data-pearl="Parent"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Parent</label><i class="expand fa fa-angle-right"></i></div><ul><li data-pearl="Child 1"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Child1</label><i class="expand fa fa-angle-right"></i></div></li><li data-pearl="Child 2"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Child2</label><i class="expand fa fa-angle-right"></i></div></li></ul></li>
HTML;
        $I->assertEquals($expected, $pearl->render());
    }

    public function checkPearlMultiHierarchy(UnitTester $I){
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

        $expected = <<<HTML
<li data-pearl="Parent"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Parent</label><i class="expand fa fa-angle-right"></i></div><ul><li data-pearl="Child 1"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Child1</label><i class="expand fa fa-angle-right"></i></div><ul><li data-pearl="GrandChild 1"><div class=" visual"><i class="icon bi bi-list-check"></i><label>GrandChild1</label><i class="expand fa fa-angle-right"></i></div></li><li data-pearl="GrandChild 2"><div class=" visual"><i class="icon bi bi-list-check"></i><label>GrandChild2</label><i class="expand fa fa-angle-right"></i></div></li></ul></li><li data-pearl="Child 2"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Child2</label><i class="expand fa fa-angle-right"></i></div></li></ul></li>
HTML;
        $I->assertEquals($expected, $pearl->render());
    }

    public function checkPearlPopulate(UnitTester $I){
        $visual = new Visual(title: 'Parent');
        $pearl = new Pearl(visual: $visual, label: 'Parent');
        $child1 = new Pearl(visual: new Visual(title: 'Child1'), label: 'Child 1');

        $pearl->populate([[ 'visual' => 'Hello', 'label' => 'World', 'children' => [$child1]]]);

        $expected = <<<HTML
<li data-pearl="Parent"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Parent</label><i class="expand fa fa-angle-right"></i></div><ul><li data-pearl="World"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Hello</label><i class="expand fa fa-angle-right"></i></div><ul class="Pearl"><li data-pearl="Child 1"><div class=" visual"><i class="icon bi bi-list-check"></i><label>Child1</label><i class="expand fa fa-angle-right"></i></div></li></ul></li></ul></li>
HTML;
        $I->assertEquals($expected, $pearl->render());
    }

    public function checkAllAttributes(UnitTester $I){
        $visual = new Visual(title: 'Parent', classes: ['test']);
        $pearl = new Pearl(visual: $visual, label: 'Parent', classes: ['test']);

        $expected = <<<HTML
<li class="test" data-pearl="Parent"><div class="test visual"><i class="icon bi bi-list-check"></i><label>Parent</label><i class="expand fa fa-angle-right"></i></div></li>
HTML;
        $I->assertEquals($expected, $pearl->render());
    
    }
}
