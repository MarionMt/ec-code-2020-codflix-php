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
                foreach ($allSeasons as $seasonsList):?>
                   <br/><div class="season_list">Saison <?= $seasonsList["season"];
                   foreach ($episode as $episode):?>
                    <div class="episode_list">Episode <?= $episode["episode"];?> </div>
                    <?php
                    endforeach;?> </div>
                    <?php
                endforeach;
            endif
        ?>
    </div>
</div>
<script type="text/javascript">
spoiler = false
</script>

<?php $content = ob_get_clean(); ?>

<?php require('dashboard.php'); ?>