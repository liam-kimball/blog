<!-- File: scr/Template/Articles/index.cpt -->

<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link('Add Article', ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users view large-10 medium-9 columns content">
    <h1>Blog Articles</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created</th>
            <th>Action</th>
        </tr>

        <!-- Here is where we iterate through our $articles query object, printing out each article info -->

        <?php foreach ($articles as $article): ?>
        <tr>
            <td><?= $article->id ?></td>
            <td><?= $this->Html->link($article->title, ['action' => 'view', $article->id]) ?></td>
            <td><?= $article->created->format(DATE_RFC850) ?></td>
            <td>
                <?= $this->Form->postLink('Delete', ['action' => 'delete', $article->id], ['confirm' => 'Are you sure?']) ?>
                <?= $this->Html->link('Edit', ['action' => 'edit', $article->id]) ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>