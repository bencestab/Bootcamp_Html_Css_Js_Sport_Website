<h1><?= h($product->title) ?></h1>
<p><?= h($product->body) ?></p>
<p><small>Created: <?= $product->created->format(DATE_RFC850) ?></small></p>
<p><b>Categories:</b> <?= h($product->category_string) ?></p>
<p><?= $this->Html->link('Edit', ['action' => 'edit', $product->slug]) ?></p>