<h1>Edit Product</h1>
<?php
    echo $this->Form->create($product);
    echo $this->Form->control('user_id', ['type' => 'hidden']);
    echo $this->Form->control('title');
    echo $this->Form->control('body', ['rows' => '3']);
    echo $this->Form->control('category_string', ['type' => 'text']);
    echo $this->Form->button(__('Save Product'));
    echo $this->Form->end();
?>
