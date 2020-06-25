<?php ob_start(); ?>

<div class="item">
    <div class="title"><?= $media['title'] ?></div>

    <div class="video">
        <?php
        if($type === "serie"): ?>
            <iframe src=<?=$episodeUrl['url_episode'] . "?autoplay=true"?> frameborder='0' allow='encrypted-media;'allowfullscreen></iframe>
               <?php else: ?>
             <iframe src=<?=$movie['movie_url'] . "?autoplay=true"?> frameborder='0' allow='encrypted-media;'allowfullscreen></iframe>
        <?php endif; ?>
    </div>

    <div class="type"><?= $name ?></div>
    <div class="duration"><?= $duration ?></div>
    <div class="release">Sorti le <?= $release ?></div>
    <div class="summary"><?= $summary ?></div>

    <div class="season">
        <?php 
            if($type === "serie"):
                foreach ($season as $seasonsList):?>
                   <br/><div class="season_list">Saison <?= $seasonsList["season"];
                   foreach ($episode as $episode):?>
                    <div class="episode_list">
                    <a class="item" href="index.php?media=<?= $media['id'].$season.$episode; ?>">
                    Episode <?= $episode["episode"];?> </a>
                    <?php
                    endforeach;?> </div></div>
                    <?php
                endforeach;
            endif
        ?>
    </div>
</div>


<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>