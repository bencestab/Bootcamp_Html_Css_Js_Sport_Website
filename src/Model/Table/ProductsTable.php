<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;
use Cake\Event\EventInterface;
use Cake\Validation\Validator;
use Cake\ORM\Query;

class ProductsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp');
        $this->belongsToMany('Categories', [
            'joinTable' => 'products_categories',
            'dependent' => true
        ]);
    }

    public function beforeSave(EventInterface $event, $entity, $options)
    {

    if ($entity->category_string) {
            $entity->categories = $this->_buildCategories($entity->category_string);
    }

    if ($entity->isNew() && !$entity->slug) {
        $sluggedTitle = Text::slug($entity->name);
        // trim slug to maximum length defined in schema
        $entity->slug = substr($sluggedTitle, 0, 191);
    }
    }

    public function validationDefault(Validator $validator): Validator
    {
    $validator
        ->notEmptyString('name')
        ->minLength('name', 10)
        ->maxLength('name', 255)

        ->notEmptyString('body')
        ->minLength('body', 10);

    return $validator;
    }


    public function findCategorised(Query $query, array $options)
{
    $columns = [
        'Products.id', 'Products.sponsor_id', 'Products.name',
        'Products.description', 'Products.modified', 'Products.created',
        'Products.slug',
    ];

    $query = $query
        ->select($columns)
        ->distinct($columns);

    if (empty($options['categories'])) {
        // If there are no categories provided, find articles that have no categories.
        $query->leftJoinWith('Categories')
            ->where(['Categories.name IS' => null]);
    } else {
        // Find articles that have one or more of the provided categories.
        $query->innerJoinWith('Categories')
            ->where(['Categories.name IN' => $options['categories']]);
    }

    return $query->group(['Products.id']);
}

    protected function _buildCategories($categoryString)
{
    // Trim categories
    $newCategories = array_map('trim', explode(',', $categoryString));
    // Remove all empty categories
    $newCategories = array_filter($newCategories);
    // Reduce duplicated categories
    $newCategories = array_unique($newCategories);

    $out = [];
    $categories = $this->Categories->find()
        ->where(['Categories.name IN' => $newCategories])
        ->all();

    // Remove existing categories from the list of new categories.
    foreach ($categories->extract('name') as $existing) {
        $index = array_search($existing, $newCategories);
        if ($index !== false) {
            unset($newCategories[$index]);
        }
    }
    // Add existing categories.
    foreach ($categories as $category) {
        $out[] = $category;
    }
    // Add new categorys.
    foreach ($newCategories as $category) {
        $out[] = $this->Categories->newEntity(['name' => $category]);
    }
    return $out;
}
}