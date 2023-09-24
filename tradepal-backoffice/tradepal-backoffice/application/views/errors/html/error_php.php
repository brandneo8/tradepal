<?php /*
  <div style="border:1px solid #990000;padding:20px;margin:0 0 10px 0;">

  <h4>A System Error was encountered</h4>
  <p>Please contact with administrator at <a href="mailto:sadmaster@hotmail.com">sadmaster@hotmail.com</a></p>
  <p>Severity: <?php echo $severity; ?></p>
  <p>Message:  <?php echo $message; ?></p>
  <p>Filename: <?php echo $filepath; ?></p>
  <p>Line Number: <?php echo $line; ?></p>
  </div>
 * 
 */
?>
<div class="note note-danger" style="width: 97%; margin-left: auto; margin-right: auto; margin-top: 20px;">
    <h4><strong>A System Error was encountered</strong></h4>
    <div>
        <p>Please contact with administrator at <a href="mailto:sadmaster@hotmail.com">sadmaster@hotmail.com</a></p>
        <i class="fa fa-warning"></i> <strong>Severity</strong> -> <?php echo $severity; ?><br />
        <i class="fa fa-warning"></i> <strong>Message</strong> -> <?php echo $message; ?><br />
        <i class="fa fa-warning"></i> <strong>Filename</strong> -> <?php echo $filepath; ?><br />
        <i class="fa fa-warning"></i> <strong>Line Number</strong> -> <?php echo $line; ?><br />
    </div>
    <?php /*
      <p>Severity: <?php echo $severity; ?></p>
      <p>Message:  <?php echo $message; ?></p>
      <p>Filename: <?php echo $filepath; ?></p>
      <p>Line Number: <?php echo $line; ?></p>
     * 
     */
    ?>
</div>