<script type="text/javascript">
function persen(byr){
  var x =document.getElementById("subtotall").innerHTML;
  document.getElementById("persent").innerHTML=parseInt((byr/x)*100)+'%';
  document.getElementById("persentase").value=parseInt((byr/x)*100);
  if (document.getElementById("persentase").value==100) {
      document.getElementById("status").value='1';
  }else if(document.getElementById("persentase").value==0){
      document.getElementById("status").value='u';
  }else if(document.getElementById("persentase").value >100){
      document.getElementById("persent").innerHTML='out of range';
      document.getElementById("persentase").value='n';
  }else{
      document.getElementById("status").value='0';
  }
  //Y/x=p => p*100
}
function sub_ttl(){
  var qty = parseInt($('#qty').val());
  var price = parseInt($('#hrgj').val());
  var diskon=parseInt($('#disc').val());

  
        if(document.getElementById('cekpersen').checked== true) {
          if (!diskon) {
            $('#subttl').val(qty*price);
          }else{
            $('#subttl').val(qty*price-price*(diskon/100));
          };
      }else if(document.getElementById('ceknom').checked== true) {
         $('#subttl').val(qty*(price-diskon));
      }else{
        alert("pilih dulu metode diskonnya COEG !");
      }
  
  //val((qty * price ? qty * price : 0).toFixed(2));
}
function saveedit(ix,idv){
  var arrupdate=[
    idv,
    ix,
    $('#kdbarang').val(),
    $('#qty').val(),
    $('#hrgj').val(),
    $('#disc').val(),
    $('#subttl').val()
  ];
  window.open(document.URL+"&savedit="+arrupdate,"_self");
}
function ceknomnya(){
    document.getElementById("disc").disabled = false;
}
function cekpersennya() {
    var diskonn=$("#backupdisc").val();
    document.getElementById("disc").value=diskonn;
    document.getElementById("disc").disabled = true;

}
</script>