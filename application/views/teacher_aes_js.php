<script src="<?php echo my_res_URL(); ?>js/jquery.handsontable.full.js"></script>
<script type="text/javascript">
var gridStudent = $("#tblstudent");
gridStudent.handsontable({
data: <?php echo json_encode($StudentArray); ?>,
rowHeaders: true,
minSpareRows: 1,
startRows: 3,
colHeaders: ['Student First Name', 'Student Last Name', 'Date of Birth', 'Parent First Name', 'Parent Last Name', 'Parent Email', 'Parent Contact'],
columns: [
  {data: 1},
  {data: 2},
  {data: 3},
  {data: 4},
  {data: 5},
  {data: 6},
  {data: 7}
]
});

//$('#tblstudent table').addClass('table-hover');
function SaveStudents(){
    var postData = {};
    postData.stdata = JSON.stringify($('#tblstudent').data('handsontable').getData());
    console.log(postData.stdata);

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'teacher/AJAXEditStudents', postData);
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
    redirect_url("<?php echo my_base_URL();?>"+'teacher/aes');
});

function ShowEdit()
{
    $('#btnEdit').addClass('hidden');
    $('#dispData').addClass('hidden');
    $('#btnSave').removeClass('hidden');
    $('#btnCancel').removeClass('hidden');
    $('#editData').removeClass('hidden');
    $("#tblstudent").handsontable('render');
}

$( window ).resize(function() {
    $("#tblstudent").handsontable('render');
});
<?php if($StartType > 0){ ?>
$(function(){ShowEdit();});
<?php } ?>
</script>

