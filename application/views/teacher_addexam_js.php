<script src="<?php echo my_res_URL(); ?>js/jquery-ui.js"></script>
<script type="text/javascript">
    $('#frmaddexam_submit').click(function(event){
        document.getElementById("frmaddexam").submit();
    });
    
    $(function() {
        $( "#datepicker" ).datepicker();
    });    

    var addedExamID = 0;

    function AddExam(id)
    {
        var postData = {};
        postData.date = $( "#datepicker" ).val();
        postData.id = id;

        pass = false;
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'teacher/AJAXAddExam', postData);
        if(rtData)
        {  
            if(!rtData.Valid)
            {
                $("#AddExamError").removeClass('hidden');
                $("#AddExamError td").html(rtData.Error.toString());
            }
            else
            {
                $('#addExamSuccessModal').modal('show');
                addedExamID = rtData.NewExamID;
            }
        }
        else
            alert("Could not connect to server.");
    }
    function ShowTab(id)
    {
        for(i=1; i<=3; i++){
            if(id == i){
                $( "#skill_"+i).removeClass('hidden');
                $( "#btn_lbl_"+i).removeClass('btn-default');
                $( "#btn_lbl_"+i).addClass('btn-success');
            }
            else{
                $( "#skill_"+i).addClass('hidden');
                $( "#btn_lbl_"+i).addClass('btn-default');
                $( "#btn_lbl_"+i).removeClass('btn-success');
            }
        }
    }

$('#addExamSuccessModal').on('hide.bs.modal', function (e) {
    redirect_url("<?php echo my_base_URL();?>"+'teacher/marks/'+addedExamID);
});
</script>