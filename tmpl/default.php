<!-- Modal Window -->
<div id="<?= $md5Folder ?>"class="ui small download modal">
	<i class="close icon"></i>
	<div class="header">
		<i class="ui download icon"></i><span id="fileTodownload<?= $md5Folder ?>Heading"></span>
	</div>
	<div class="image content">
		<div class="description">
			<form id="downloadRequest<?= $md5Folder ?>Form" class="ui form" action="<?= $uri; ?>" method="post" target="_blank">
				<div class="ui two column grid">
					<div class="column">
						<div class="ui required field">
							<label>Full name:</label>
							<input name="name" type="text">
						</div>
						<div class="ui required field">
							<label>Email address:</label>
							<input name="email" type="email" >
						</div>
						<input id="filename" name="filename" type="hidden" >
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">Cancel</div>
		<div class="ui right labeled icon ok button"><i class="ui check mark icon"></i>Submit</div>
	</div>
</div>

<!-- Heading -->
<?php if($header) : ?>
<h3 class="ui header"><i class="ui download icon"></i>Downloads</h3>
<?php endif; ?>

<!-- List -->
<?php if($asList == false) : ?>
<table class="ui table">
	<thead>
	<tr>
		<th>File</th>
		<th class="ui collapsing cell">Size</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($newFiles as $file) : ?>
		<tr>
			<td><a id="<?= $md5Folder ?>" class="download link" data-filename="<?= $file->name; ?>" href="#"><?= $file->name; ?></a></td>
			<td><?= $file->size; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
	<tfoot>
	</tfoot>
</table>
<?php else : ?>
	<div class="ui relaxed divided list">
	<?php foreach($newFiles as $file) : ?>
		<div class="item">
			<a id="<?= $md5Folder ?>" class="header download link" data-filename="<?= $file->name; ?>" href="#"><?= $file->name; ?></a>
			<small><?= $file->size; ?></small>
		</div>
	<?php endforeach; ?>
	</div>
<?php endif ?>

<p><?= $text; ?></p>

<script>

	// Ready
	jQuery(document).ready(function(){

		// Form verification
		jQuery('#downloadRequest<?= $md5Folder ?>Form')
		.form({
			fields: {
				name: {
					identifier: 'name',
					rules: [
						{
							type   : 'empty',
							prompt : 'Please enter your name'
						}
					]
				},
				email: {
					identifier: 'email',
					rules: [
						{
							type   : 'empty',
							prompt : 'Please enter your email address'
						},
						{
							type   : 'email',
							prompt : 'Please enter a valid e-mail address'
						}
					]
				} 
			}
		});

		// Setup modal window to capture user details
		jQuery('#<?= $md5Folder ?>.ui.download.modal').modal({
			onApprove: function(){
				
				if(jQuery('#downloadRequest<?= $md5Folder ?>Form').form('is valid')){
					jQuery('#downloadRequest<?= $md5Folder ?>Form').submit();
				}
				else{
					return false;
				}
			}
		});

		// Setup click to submit the form and download the file
		jQuery('#<?= $md5Folder ?>.download.link').click(function(e){

			// Stop
			e.preventDefault();
			e.stopPropagation();

			// Find file name
			var thisFileName = jQuery(this).data('filename');

			// Update form and modal with relavant filename
			jQuery('#fileTodownload<?= $md5Folder ?>Heading').html(thisFileName);
			jQuery('#downloadRequest<?= $md5Folder ?>Form input[name="filename"]').val(thisFileName);

			// Show the modal
			jQuery('#<?= $md5Folder ?>.ui.download.modal').modal('show');
		});

});
</script>