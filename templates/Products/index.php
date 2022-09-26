<h1>Products</h1>
<?= $this->Html->link('Add Product', ['action' => 'add']) ?>
<table>
    <tr>
        <th>Name</th>
        <th>Preis</th>
        <th>Category</th>
        <th>Modified</th>
    </tr>

    <?php foreach ($products as $product): ?>
    <tr>
        <td>
            <?php 
                echo $this->Html->link(
                    $product->name, 
                    [
                        'action' => 'view', 
                        $product->slug
                    ]
                );
            ?>
        </td>
        <td>
            <?= $product->preis ?>
        </td>
        <td>
            <?= $product->category ?>
        </td>
        <td>
            <?= $product->modified->format(DATE_RFC850) ?>
        </td>
        <td>
            <?= $this->Html->link('Edit', ['action' => 'edit', $product->slug]) ?>
            <?= $this->Form->postLink(
                'Delete',
                ['action' => 'delete', $product->slug],
                ['confirm' => 'Are you sure?'])
                ?>
        </td>
    </tr>
    <?php endforeach; ?>
</table>