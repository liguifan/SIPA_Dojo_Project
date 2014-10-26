<script type="text/javascript">
    $("#stID").change(function() {
        redirect_url( "<?php echo my_base_URL(); ?>parents?q=" + $("#stID").val())
    });
    function ShowExamDetail(sname, sid, eid)
    {
        var postData = {};
        postData.sid = sid;
        postData.eid = eid;

        pass = false;
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'parents/AJAXGetExamDetail', postData);
        if(rtData)
        {  
            if(rtData.Valid)
            {
                pass = true;
                $('#examDetailModalLabel').html(sname + " - Exam Detail");
                
                ExamDet = rtData.Detail.Exam;
                
                strHTML = '';
                strHTML += '<div class="row"><div class="col-md-3">Skill:</div><div class="col-md-6">'+ExamDet.GoalName+'</div></div>';
                if(ExamDet.GoalSpName)
                    strHTML += '<div class="row"><div class="col-md-3">Description:</div><div class="col-md-6">'+ExamDet.GoalSpName+'</div></div>';
                strHTML += '<div class="row"><div class="col-md-3">Level:</div><div class="col-md-6">'+ExamDet.LabelName+'</div></div>';
                strHTML += '<div class="row"><div class="col-md-3">Benchmark:</div><div class="col-md-6">'+ExamDet.DispBenchmark+'</div></div>';
                strHTML += '<div class="row"><div class="col-md-9">&nbsp;</div></div>';
                strHTML += '<div class="row"><div class="col-md-9">Exams</div></div>';

                $.each(rtData.Detail.Marks, function( index, value ) {
                    strHTML += '<div class="row"><div class="col-md-3">'+value.Date
                            +  '</div><div class="col-md-3">'+value.Score+' ('+((value.Pass > 0)?'Pass':'Fail')+')</div></div>';
                });
                
                $('#bodyModal').html(strHTML);
                $('#examDetailModal').modal('show');
            }
        }        
        if(!pass)
            alert("Error while connecting server.");
    }
</script>