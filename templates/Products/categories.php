<h1>
    Products tagged with
    <?= $this->Text->toList(h($categories), 'or') ?>
</h1>

<section>
<?php foreach ($products as $product): ?>
    <product>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link(
            $product->name,
            ['controller' => 'Products', 'action' => 'view', $product->slug]
        ) ?></h4>
        <span><?= h($product->created) ?></span>
    </product>
<?php endforeach; ?>
</section>