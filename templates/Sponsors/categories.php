<h1>
    Products tagged with
    <?= $this->Text->toList(h($categories), 'or') ?>
</h1>

<section>
<?php foreach ($sponsors as $sponsor): ?>
    <sponsor>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link(
            $sponsor->name,
            ['controller' => 'Sponsors', 'action' => 'view', $sponsor->slug]
        ) ?></h4>
        <span><?= h($sponsor->created) ?></span>
    </sponsor>
<?php endforeach; ?>
</section>