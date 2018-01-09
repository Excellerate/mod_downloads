<!-- Modal Window -->
<div class="ui small download modal">
  <i class="close icon"></i>
  <div class="header">
    <i class="ui download icon"></i><span id="fileTodownloadHeading"></span>
  </div>
  <div class="image content">
    <div class="description">
      <form id="downloadRequestForm" class="ui form" action="<?= $uri; ?>" method="post" target="_blank">
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

<!-- List -->
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
      <td><a class="download link" data-filename="<?= $file->name; ?>" href="#"><?= $file->name; ?></a></td>
      <td><?= $file->size; ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
  <tfoot>
  </tfoot>
</table>

<p><?= $text; ?></p>