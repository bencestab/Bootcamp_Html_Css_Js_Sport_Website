<h1>Add Product</h1>
<?php
    echo $this->Form->create($product);
    echo $this->Form->control('user_id', ['type' => 'hidden', 'value' => 1]);
    echo $this->Form->control('name');
    echo $this->Form->control('description', ['rows' => '3']);
    echo $this->Form->control('category_string', ['type' => 'text']);
    echo $this->Form->button(__('Save Product'));
    echo $this->Form->end();
?>