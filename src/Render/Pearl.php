<?php
namespace Oyster\Render;

require_once __DIR__ . '/../../support/lib/vendor/autoload.php';

use \Approach\Render\HTML;
use \Approach\Render\Node;
use \Approach\Render\Stream;
use \Approach\Render\Attribute;
use \Stringable;

/* 
 * Pearl
 *
 * A Pearl is a self expanding list item that can be used to create a visual representation of a list
 * in a Oyster. 
 * It takes in a visual representation of the list, a label for the list, and a list of children pearls
 *
 * @param string|null $visual - the visual representation of the list
 * @param string|null $label - the label of the list
 * @param Pearl|null $children - the children of the list
 *
 * @see HTML
 *
 * @param string|null $id - the id of the list
 * @param string|array|Node|Attribute|null $classes - the classes of the list
 * @param array|Attribute|null $attributes - the attributes of the list
 * @param string|Stringable|Stream|null $content - the content of the list
 * @param array $styles - the styles of the list
 * @param bool $prerender - whether or not to prerender the list
 * @param bool $selfContained - whether or not the list is self contained
 *
 * @return Pearl
 * */
class Pearl extends HTML
{
    public HTML $visual;
    public HTML $label;
    public HTML $children;

    public function __construct(
        null|string|HTML|Stringable $visual = null,
        null|string|HTML|Stringable $label = null,
        null|Pearl $children = null,

        public null|string|Stringable $id = null,
        null|string|array|Node|Attribute $classes = null,
        public null|array|Attribute $attributes = new Attribute,
        public null|string|Stringable|Stream|self $content = null,
        public array $styles = [],
        public bool $prerender = false,
        public bool $selfContained = false,
    ) {
        parent::__construct(
            tag: 'li',
            id: $id,
            classes: $classes,
            attributes: new Attribute('data-pearl', $label), // We feed in the label as the data-pearl attribute
            styles: $styles,
            prerender: $prerender,
            selfContained: $selfContained
        );

        // force the visual to be HTML
        if( !($visual instanceof HTML) ){
            if ($visual === null) {
                $visual = new HTML(tag: 'div');
                $visual[] = new HTML(tag: 'i'); 
                $visual[] = $this->label = new HTML(tag: 'label', content: $label); // use internal label as fallback
                $visual[] = new HTML(tag: 'i', classes: ['fas', 'fa-angle-right']);
            }
            else{
                $visual = new HTML('div', content: $visual);
            }
        }
        
        $this->nodes[] = $visual;
        $this->visual = &$this->nodes[0];
        
        // Pattern Explaination
        // We first put all the nodes in an array
        // Then we use the array to create a reference to the nodes
        // So that the nodes can be accessed by reference
        // making it easier to manipulate the nodes
        // and acting as a sort of integrity check

        // We check if there are children
        // if not, we create an empty ul
        if($children !== null &&count($children) > 0){
            $this->children = new HTML(tag: 'ul');
            foreach ($children as $child) {
                $this->children[$child->label] = $child;
            }
        }
        else{
            $this->children = new HTML(tag: null);
        }
    }

    /**
     * Add a pearl to the children list
     * 
     * @param Pearl $pearl The pearl to add
     * @return self
     */

    public function addPearl(Pearl $pearl) : self{
        $this->children[$pearl->label] = $pearl;
        return $this;
    }

    /**
     * Populate child levels of this pearl with the given array
     * 
     * @param array $array An array of pearls to add
     *      Each pearl should be an associative array with the following keys:
     *          visual: string | HTML | null
     *          label: string | HTML
     *          children: array | null
     * @return self
     */
    public function populate(array $array) : self{
        
        foreach($array as $pearl){
            $this->addPearl( new Pearl(
                visual: $pearl['visual'],
                label: $pearl['label'],
                children: $pearl['children'] ?? null
            ));
        }
        
        return $this;
    }

    /**
     * Create a Pearl from an array
     * @param array<int,mixed> $array
     */
    public static function fromArray(array $array) : self{
        return (new Pearl)->populate($array);
    }
}
