<script src="<?php echo my_res_URL(); ?>js/jquery.handsontable.full.js"></script>
<script type="text/javascript">
var gridStudent = $("#tblstudent");
gridStudent.handsontable({
data: <?php echo json_encode($StudentMarksArray); ?>,
rowHeaders: true,
colHeaders: ['Student Name', 'Marks'],
columns: [
  {data: 1},
  {data: 2}],
cells: function (row, col, prop) {
    var cellProperties = {};
    if (col === 0) cellProperties.readOnly = true;
    return cellProperties;
  }      
});

//$('#tblstudent table').addClass('table-hover');
function SaveStudents(){
    var postData = {};
    postData.id = <?php echo $ExamID; ?>;
    postData.stdata = JSON.stringify($('#tblstudent').data('handsontable').getData());
    console.log(postData.stdata);

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'teacher/AJAXSaveMarks', postData);
    if(rtData)
    {
        if(rtData.Valid)
        {
            $('#saveStudentSuccessModal').modal('show');
        }
        else
        {
            allTR = "";
            $.each(rtData.Error, function( index, value ) {
                allTR += "<tr>";
                allTR += "<td>" + value[0] + "</td>";
                allTR += "<td>" + value[1] + "</td>";
                allTR += "<td>" + value[2] + "</td>";
                allTR += "</tr>";
            });
            $("#errtblbody").html(allTR);
            $("#errdiv").removeClass('hidden');
            $("#tblstudent").handsontable('render');
        }
    }
    else
        alert("Could not connect to server.<br>Please try again.");
    
    if(type == 1){
        
        $("#teacherLogin #errorText").parent().removeClass('hidden');}
    else{
        $("#parentLogin #errorText").html(errorText);
        $("#parentLogin #errorText").parent().removeClass('hidden');}
    
}

$('#saveStudentSuccessModal').on('hide.bs.modal', function (e) {
    redirect_url("<?php echo my_base_URL();?>"+'teacher/assessment');
});

</script>

