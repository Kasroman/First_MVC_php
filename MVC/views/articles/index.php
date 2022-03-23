<h1>Liste des articles</h1>

<?php foreach($articles as $article): ?>
    <h2>
        <a href="/mvc/articles/read/<?= $article['slug']?>">
            <?= $article['titre'] ?>
        </a>
    </h2>
    <p>
        <?= $article['contenu'] ?>
    </p>
<?php endforeach; ?> 