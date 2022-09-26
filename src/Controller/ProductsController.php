<?php

namespace App\Controller;

class ProductsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }

    public function index()
    {
        $this->loadComponent('Paginator');
        $products = $this->Paginator->paginate($this->Products->find());
        $this->set(compact('products'));
    }
    
    public function view($slug)
    {
    $product = $this->Products
            ->findBySlug($slug)
            ->contain('Categories')
            ->firstOrFail();
    $this->set(compact('product'));
    }

    public function add()
    {
        $product = $this->Products->newEmptyEntity();
        if ($this->request->is('post')) {
            $product = $this->Products->patchEntity($product, $this->request->getData());

            $product->user_id = 1;

            if ($this->Products->save($product)) {
                $this->Flash->success(__('Your product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to add your product.'));
        }

        $categories = $this->Products->Categories->find('list')->all();
        $this->set('categories', $categories);

        $this->set('product', $product);
    }

    public function edit($slug)
    {
        $product = $this->Products
            ->findBySlug($slug)
            ->contain('Categories')
            ->firstOrFail();

        if ($this->request->is(['post', 'put'])) {
            $this->Products->patchEntity($product, $this->request->getData());
            if ($this->Products->save($product)) {
                $this->Flash->success(__('Your product has been updated.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Unable to update your product.'));
        }

        $categories = $this->Products->Categories->find('list')->all();
        $this->set('categories', $categories);


        $this->set('product', $product);
    }

    public function delete($slug)
    {
    $this->request->allowMethod(['post', 'delete']);

    $product = $this->Products->findBySlug($slug)->firstOrFail();
    if ($this->Products->delete($product)) {
        $this->Flash->success(__('The {0} product has been deleted.', $product->title));
        return $this->redirect(['action' => 'index']);
    }
    }

    public function categories()
    {
    // The 'pass' key is provided by CakePHP and contains all
    // the passed URL path segments in the request.
    $categories = $this->request->getParam('pass');

    // Use the ArticlesTable to find tagged articles.
    $products  = $this->Products->find('categorised', [
            'categories' => $categories
        ])
        ->all();

    // Pass variables into the view template context.
    $this->set([
        'products' => $products,
        'categories' => $categories
    ]);
    }
}