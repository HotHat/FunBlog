<?php declare(strict_types=1);



class  HtmlTag {
    protected $tag;
    protected $attribute = [];
    protected $children = [];
    public function __construct($tag, $attribute, $children)
    {
        $this->tag = $tag;
        $this->attribute = $attribute;
        $this->children = $children;
    }
}

class Attribute {
    protected $key;
    protected $value;
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}

// class Div extends HtmlTag {}
// class H1 extends HtmlTag {}
// class Html extends HtmlTag {}
// class Link extends HtmlTag {}
// class Head extends HtmlTag {}
// class Header extends HtmlTag {}
// class Body extends HtmlTag {}
// class Span extends HtmlTag {}


function div($ch='', $attr='') { return new HtmlTag('div', $attr, $ch); }
function h1($ch='', $attr='') { return new HtmlTag('h1', $attr, $ch); }
function html($ch='', $attr='') { return new HtmlTag('html', $attr, $ch); }
function link($attr='') { return new HtmlTag('link', $attr, $ch=''); }
function head($ch='', $attr='') { return new HtmlTag('head', $attr, $ch); }
function header($ch='', $attr='') { return new HtmlTag('header', $attr, $ch); }
function body($ch='', $attr='') { return new HtmlTag('body', $attr, $ch); }
function span($ch='', $attr='') { return new HtmlTag('span', $attr, $ch); }


html([
    head([
        link( 'rel="stylesheet" href="https://1024.love/usr/themes/default/normalize.css"'),
        link( 'rel="stylesheet" href="https://1024.love/usr/themes/default/grid.css"'),
    ]),
    body([
        header([
            true ? span()  : h1() ,
            false ? span()  : h1() ,
        
        ], 'id="header" class="clearfix"')
    ])

]);

function attr($k, $v) {
    return new Attribute($k, $v);
}

function Y(...$arg) {
    return $arg;
}

define('CLS', 'class');
define('ID', 'id');

div([
    attr(CLS, 'ttt'), attr(ID, 'ppp')
],
    function () {
        h1(["class" => 'awesome'], "hello");
        h1(["class" => 'awesome'], "world");
    }
);

div('id="abc" class="hell"', function () {
    h1(["class" => 'awesome'], "hello");
});


div([
    h1(["class" => 'awesome'], "hello"),
], 'id="abc" class="hell"');






