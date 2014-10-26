<script type="text/javascript">
function AJAXCreateExamType(){
    var postData = {};
    postData.examtype = $("#addTypeModal #examtype").val();
    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'admin/AJAXCreateExamType', postData);
    if(rtData)
        if(rtData.Valid){redirect_url("");return;}
    errorText = "Unknown Error occured.";
    $("#addTypeModal #errorText").html(errorText);
    $("#addTypeModal #errorText").parent().removeClass('hidden');
}
function AJAXCreateGoal(){
    var postData = {};
    postData.goal = $("#addGoalModal #goalname").val();
    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'admin/AJAXCreateGoal', postData);
    if(rtData)
        if(rtData.Valid){redirect_url("");return;}
    errorText = "Unknown Error occured.";
    $("#addGoalModal #errorText").html(errorText);
    $("#addGoalModal #errorText").parent().removeClass('hidden');
}
function AJAXCreateExam(){
    var postData = {};
    postData.etype = $("#addExamModal #etype").val();
    postData.grade = $("#addExamModal #grade").val();
    postData.goal  = $("#addExamModal #goal").val();
    postData.label = $("#addExamModal #label").val();
    postData.name  = $("#addExamModal #spgoalname").val();
    postData.benchmark = $("#addExamModal #benchmark").val();
    postData.percent   = $("#addExamModal #percent").is(':checked')?1:0;
    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'admin/AJAXCreateExam', postData);
    if(rtData)
    {
        if(rtData.Valid){redirect_url("");return;}
        errorText = rtData.Error;
    }
    else
        errorText = "Unknown Error occured.";
    $("#addExamModal #errorText").html(errorText);
    $("#addExamModal #errorText").parent().removeClass('hidden');
}
$("#ExamTypeSelect").change(function() {
    var ID = $("#ExamTypeSelect").val();
    $(".ExamTypeAll").addClass("hidden");
    $(".ExamType"+ID).removeClass("hidden");
});
$(function(){
    var ID = $("#ExamTypeSelect").val();
    $(".ExamTypeAll").addClass("hidden");
    $(".ExamType"+ID).removeClass("hidden");
});
function OpenModal(Etype, EtypeName, Grade, Goal, SpGoal, Label, Benchmark){
    $('#editExamModal #Exam').html(EtypeName);
    $('#editExamModal #Grade').html(Grade);
    $('#editExamModal #Goal').html(Goal);
    $('#editExamModal #Label').html(Label);
    $('#editExamModal #ExamID').val(Etype);
    $('#editExamModal #spgoalname').val(SpGoal);
    $('#editExamModal #benchmark').val(Benchmark);    
    $('#editExamModal').modal('show');
}
function AJAXEditExam()
{
    var postData = {};
    postData.examID = $("#editExamModal #ExamID").val();
    postData.name  = $("#editExamModal #spgoalname").val();
    postData.benchmark = $("#editExamModal #benchmark").val();
    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'admin/AJAXEditExam', postData);
    if(rtData)
    {
        if(rtData.Valid){redirect_url("");return;}
        errorText = rtData.Error;
    }
    else
        errorText = "Unknown Error occured.";
    $("#editExamModal #errorText").html(errorText);
    $("#editExamModal #errorText").parent().removeClass('hidden');
}
</script>
