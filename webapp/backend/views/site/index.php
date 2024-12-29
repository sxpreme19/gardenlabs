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
            <?php elseif ($role == 'manager' || $role == 'provider'): ?>
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

    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <canvas id="mostSoldProductsChart" width="1.3" height="1.3"></canvas>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('mostSoldProductsChart').getContext('2d');

        const chartData = {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Total Quantity Sold',
                data: <?= json_encode($data) ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const labelCount = chartData.labels.length;

        new Chart(ctx, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: `Top ${labelCount} Most Sold Products`, 
                        font: {
                            size: 18, 
                            weight: 'bold' 
                        },
                        padding: {
                            top: 20,
                            bottom: 20 
                        }
                    }
                }
            },
        });
    });
</script>