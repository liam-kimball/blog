<!-- File: src/Template/Articles/view.ctp -->
<nav class="large-2 medium-3 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li><?= $this->Html->link('Home', ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="users view large-10 medium-9 columns content">
    <div class="columns">
        <h1><?= h($article->title) ?></h1>
        <p><?= h($article->body) ?></p>
        <p><small>Created: <?= $article->created->format(DATE_RFC850) ?></small></p>
    </div>
</div>