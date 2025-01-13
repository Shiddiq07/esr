<?php
$animateIcon = ' <i class="bi bi-arrow-repeat glyphicon-refresh-animate"></i>';
?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body pt-3">
            	<div class="row">
		            <div class="col-sm-5">
		                <div class="input-group">
		                    <input class="form-control search" data-target="available" placeholder="Cari route yang tersedia">
		                    <span class="input-group-btn">
		                        <?= $this->html->a('<span class="bi bi-arrow-repeat"></span>', '/rbac/allowed/refresh', [
		                            'class' => 'btn btn-light',
		                            'id' => 'btn-refresh'
		                        ]) ?>
		                    </span>
		                </div>
		                <select multiple size="20" class="form-control list" data-target="available"></select>
		            </div>
		            <div class="col-sm-1 text-center">
		                <br><br>
		                <?= $this->html->a('<span class="bi bi-chevron-double-right"></span>' . $animateIcon, '/rbac/allowed/assign', [
		                    'class' => 'btn btn-success btn-assign ladda-button',
		                    'data-target' => 'available',
		                    'title' => 'Assign',
		                ]) ?><br><br>
		                <?= $this->html->a('<span class="bi bi-chevron-double-left"></span>' . $animateIcon, '/rbac/allowed/remove', [
		                    'class' => 'btn btn-danger btn-assign ladda-button',
		                    'data-target' => 'assigned',
		                    'title' => 'Remove'
		                ]) ?>
		            </div>
		            <div class="col-sm-5">
		                <input class="form-control search" data-target="assigned" placeholder="Cari route allowed">
		                <select multiple size="20" class="form-control list" data-target="assigned"></select>
		            </div>
		        </div>
            </div>
        </div>
    </div>
</div>
