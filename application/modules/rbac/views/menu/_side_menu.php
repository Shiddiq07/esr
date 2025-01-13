<div class="card">
	<div class="card-header">Custom Link</div>

	<div class="card-body pt-3">
		<div class="row g-3">
			<div class="col-12">
				<label>URL</label>
				<input type="text" name="url" id="url" class="form-control" placeholder="http://" value="http://" />
			</div>
			<div class="col-12">
				<label>Link Text</label>
				<input type="text" name="label" id="label" class="form-control" placeholder="Sample text" />
			</div>

			<div class="col-12">
				<?php echo $this->html->submitButton('Add to Menu', ['class' => 'btn btn-light float-end', 'id' => 'add-custom-to-menu']) ?>
			</div>
		</div>
	</div>
</div>
