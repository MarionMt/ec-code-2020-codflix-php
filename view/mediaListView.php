<?php ob_start(); ?>

<div class="row">
    <div class="col-md-4 offset-md-8">
        <form method="get">
            <div class="form-group has-btn">
                <input type="search" id="search" name="title" value="<?= $search; ?>" class="form-control"
                       placeholder="Rechercher un film ou une série">

                <button type="submit" class="btn btn-block bg-red">Valider</button>
            </div>
        </form>
    </div>
</div>

<div class="media-list">
    <?php 
    foreach ($medias as $media): ?>
        <a class="item" href="index.php?media=<?= $media['id']; ?>
                                              <?= $media['type'] === 'serie' ? ' &season=1 &episode=1' : null ?>">
            <div class="video">
                <div>
                    <iframe allowfullscreen="" frameborder="0"
                            src="<?= $media['trailer_url']; ?>" ></iframe>
                </div>
            </div>
            <div class="title"><?= $media['title']; ?></div>
            <div class="release">
                <?php if (isset($_GET['title'])):
                echo $release;
                endif
                ?>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>