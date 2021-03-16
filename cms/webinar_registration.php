<?php 
error_reporting(0);
include("header.php");

define("PAGE_AJAX_COMMON","ajax_common.php");  

?> 

<script language="javascript" type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.history.js"></script>
<div id="listWrapper" class="table-responsive"> 
    <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Contact No.</th>
      <th scope="col">Profession</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
<?php 
$connection = mysqli_connect("localhost","root","root","insolindia") or die(mysqli_error($mysqli));
$id = $_GET['id'];
$dec = $_GET['dec'];
$query_read = "SELECT * FROM zoom";
		$result = mysqli_query($connection, $query_read);
		while($show = mysqli_fetch_array($result)){
?>
    <tr>
      <th scope="row"><?php echo $show['id'] ?></th>
      <td><?php echo $show['name'] ?></td>
      <td><?php echo $show['email'] ?></td>
      <td><?php echo $show['mob'] ?></td>
      <td><?php echo $show['profession'] ?></td>
      <td><?php echo $show['status'] ?></td>
    </tr>
    <tr>
  <?php }?>
 </tbody>
</table>
</div>    
            
     

<?php
include("footer.php"); 

?>