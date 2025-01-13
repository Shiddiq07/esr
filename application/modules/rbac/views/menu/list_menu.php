<div class="row">
    <div class="col-lg-4">
        <?php echo $this->layout->renderPartial('_side_menu') ?>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                Group name : <strong><?php echo $menuType ?></strong>
            </div>

            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-md-8">
                        <strong><?= 'Menu Structure' ?></strong>
                        <p>Seret tiap daftar ke posisi yg anda sukai. Klik simbol (<span class="bi bi-chevron-down"></span>) dibagian samping untuk melihat pengaturan tambahan.</p>
                    </div>
                    <div class="col-md-4">
                        <?= $this->html->submitButton('Save Menu <span class=\'bi bi-save\'></span>', ['name'=> 'save', 'class' => 'btn btn-primary float-end btn-save-menu']);?>
                    </div>
                </div>

                <div class="alert alert-success">
                    <h4 class="alert-heading">Tips !</h4>
                    <small>Icon harus berisi berdasarkan Icon Bootstrap<br/>Ex. (bi bi-)grid <i class="bi bi-grid"></i><br/> Klik link untuk referensi <a href="https://icons.getbootstrap.com/">https://icons.getbootstrap.com/</a></small>
                </div>

                <?= form_open('', ['id' => 'formMenu']); ?>
                    <div class="dd">
                        <ol class="dd-list">
                        <?php
                        if (!empty($menus)) {
                            $i = 0;
                            foreach ($menus as $key => $menu) {
                                if ($menu->menu_parent == 0) {
                                    echo $this->layout->renderPartial('_view', [
                                        'menu' => $menu,
                                        'listGroup' => $listGroup,
                                        'childMenus' => $menus,
                                        'menuType' => $menuType,
                                        'i' => $i,
                                    ]);
                                }
                                $i++;
                            }
                        }
                        ?>
                        </ol>
                    </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
