<?php
$this->title = 'Dashboard';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $registeredUsers,
                'text' => 'User Registrations',
                'icon' => 'fas fa-user-plus',
                'theme' => 'info',
            ]) ?>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
            <?= \hail812\adminlte\widgets\SmallBox::widget([
                'title' => $totalIncome . '€',
                'text' => 'Total Income',
                'icon' => 'fas fa-euro-sign',
                'theme' => 'gradient-success',
            ]) ?>
        </div>
    </div>
    <div class="row">
        <?php foreach ($roleData as $role => $userCount): ?>
            <?php if ($role == 'admin'): ?>
                <div class="col-12 col-sm-6 col-md-2">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => $role,
                        'number' => $userCount,
                        'icon' => 'fas fa-user',
                        'theme' => 'gradient-danger',
                    ]) ?>
                </div>
                <?php elseif($role == 'manager' || $role == 'provider'): ?>
                    <div class="col-12 col-sm-6 col-md-2">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => $role,
                        'number' => $userCount,
                        'icon' => 'fas fa-user',
                        'theme' => 'gradient-warning',
                    ]) ?>
                </div>
                <?php else: ?>
                    <div class="col-12 col-sm-6 col-md-2">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => $role,
                        'number' => $userCount,
                        'icon' => 'fas fa-user',
                        'theme' => 'gradient-info',
                    ]) ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total Products',
                'number' => $existingProducts,
                'icon' => 'fas fa-box',
            ]) ?>
        </div>
        <div class="col-12 col-sm-6 col-md-3">
            <?= \hail812\adminlte\widgets\InfoBox::widget([
                'text' => 'Total Services',
                'number' => $existingServices,
                'icon' => 'fas fa-concierge-bell',
            ]) ?>
        </div>
    </div>
</div>