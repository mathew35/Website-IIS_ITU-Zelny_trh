<?php
class mod
{
    public $name = '';
    public function __construct($val)
    {
        $this->name = $val;
    }
    public function addCategory()
    {
        // TODO
        echo "Adding category ...\n";
    }
    public function removeCategory()
    {
        // TODO
        echo "Removing category ...\n";
    }
    public function addAttribute($category, $attribute)
    {
        // TODO
        echo "Added attribute $attribute to $category\n";
    }
    public function removeAttribute($category, $attribute)
    {
        // TODO
        echo "Removed attribute $attribute from $category\n";
    }
    public function changeAttribute($category, $attribute, $newAttribute)
    {
        // TODO
        echo "Changed attribute $attribute in $category to $newAttribute\n";
    }
}
