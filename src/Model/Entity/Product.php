<?php
// src/Model/Entity/Article.php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Collection\Collection;

class Product extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
        'slug' => false,
        'category_string' => true
    ];
    protected function _getCategoryString()
    {
    if (isset($this->_fields['category_string'])) {
        return $this->_fields['category_string'];
    }
    if (empty($this->categories)) {
        return '';
    }
    $categories = new Collection($this->categories);
    $str = $categories->reduce(function ($string, $category) {
        return $string . $category->name . ', ';
    }, '');
    return trim($str, ', ');
    }
}