function showloading(stat) {
  if (stat==true) {
    $(".loading").html("<img src='<?=base_url('assets/loading/loadingImage.gif');?>' height='50' width='50'/>")
  } else {
    $(".loading").html("");
  }
}
