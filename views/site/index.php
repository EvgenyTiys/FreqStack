<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = '';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Open "Skills" to see the list of skills</h1>

        <p class="lead"></p>

        <p><a class="btn btn-lg btn-success" href="<?=Url::to(['admin-skill/index']) ?>">Skills</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4 mb-3">
                <h2>Skill Categories</h2>

                <p>In this section you can see the list of skill categories</p>

                <p><a class="btn btn-outline-secondary" href="<?= Url::to(['admin-skill-cathegory/index']) ?>" >Skill Categories &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
