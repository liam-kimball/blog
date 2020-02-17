<!-- File: scr/Template/Articles/add.ctp -->
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link('Home', ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users view large-10 medium-9 columns content">
    <h1>Add Article</h1>
    <?php
        echo $this->Form->create($article);
        echo $this->Form->control('title');
        echo $this->Form->control('body', ['rows' => '3']);
        echo $this->Form->button(__('Save Article'));
        echo $this->Form->end();
    ?>
</div>