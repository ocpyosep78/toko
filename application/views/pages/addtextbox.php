<div id="TextBoxesGroup">
 	<div id="TextBoxDiv1">
 		<label>Textbox #1 : </label><input type="text" id="textbox1" name="textbox1">
 	</div>
	<div id="TextBoxDiv2">
		<label>Textbox #2 : </label><input type="text" id="textbox2" name="textbox2">
	</div>
</div>
<input type="button" value="Add Button" id="addButton">
<input type="button" value="Remove Button" id="removeButton">
<script src="<?php echo base_url().'asset/js/jquery.min.js';?>"></script>
<script type="text/javascript">
$(window).load(function(){
$(document).ready(function () {
 	var counter = 2;
	$("#addButton").click(function () {
            if (counter > 2) {
                alert("Only 2 textboxes allowed");
                return false;
            }
            $('<div/>',{'id':'TextBoxDiv' + counter}).html(
              $('<label/>').html( 'Textbox #' + counter + ' : ' )
            )
            .append( $('<input type="text">').attr({'id':'textbox' + counter,'name':'textbox' + counter}) )
            .appendTo( '#TextBoxesGroup' )       
            counter++;
        });

        $("#removeButton").click(function () {
            if (counter == 1) {
                alert("No more textbox to remove");
                return false;
            }
            counter--;
            $("#TextBoxDiv" + counter).remove();
        });
});
}); 

</script>