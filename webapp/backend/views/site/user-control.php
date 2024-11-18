<?php
$this->title = 'Starter Page';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Registered Users',
                'number' => $registeredUsers,
                'icon' => 'fas fa-user',
            ]) ?>
        </div>
    </div>
</div>