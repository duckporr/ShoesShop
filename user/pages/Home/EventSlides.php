<?php
$sql_show_slide = "SELECT * FROM tbl_event WHERE end_date  >= CURDATE() ";
$query_show_slide = mysqli_query($connect, $sql_show_slide);
?>

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <?php
    $indicatorIndex = 0;
    while ($row = mysqli_fetch_array($query_show_slide)) {
    ?>
      <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $indicatorIndex; ?>" <?php echo $indicatorIndex == 0 ? 'class="active"' : ''; ?> aria-label="Slide <?php echo $indicatorIndex + 1; ?>"></button>
    <?php
      $indicatorIndex++;
    }
    ?>
  </div>
  <div class="carousel-inner">
    <?php
    $itemIndex = 0;
    mysqli_data_seek($query_show_slide, 0);
    while ($row = mysqli_fetch_array($query_show_slide) ) {
    ?>
      <div class="carousel-item <?php echo $itemIndex == 0 ? 'active' : ''; ?>">
      <a href="UserIndex.php?usingPage=event&eventId=<?php echo $row['id'] ?>">
        <img src="./../../admin/pages/Event/EventImages/<?php  echo $row['banner']; ?>" class="d-block w-100" alt="slide_event" style="border-radius: 10px; height: 624px">
      </a>
      </div>
    <?php
      $itemIndex++;
    }
    ?>
  </div>
  <?php
  if ($itemIndex > 1) {
  ?>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>
<?php
  }
?>