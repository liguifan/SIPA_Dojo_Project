<script type="text/javascript">
    var curSkill = 1;
    var totalSkill = <?php echo $SkillCount; ?>;
    function NextSkill(){
        curSkill = (curSkill % totalSkill) + 1;
        RefreshTable();
    }
    function PrevSkill(){
        curSkill = ((curSkill + totalSkill - 2)% totalSkill) + 1;
        RefreshTable();
    }
    function RefreshTable(){
        $(".skillCol").addClass('hidden');
        $(".skillCol_"+curSkill).removeClass('hidden');
    }
    function SetActive(active, id){
        if(id === 0) return;

        var postData = {};
        postData.activeStatus = active?1:0;
        postData.activeID = id;

        pass = false;
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'teacher/AJAXActiveStudent', postData);
        if(rtData)
        {  
            if(rtData.Valid)
            {
                $("#btn_yes_"+id).removeClass(active?"btn-default":"btn-success");
                $("#btn_yes_"+id).addClass(active?"btn-success":"btn-default");
                $("#btn_no_"+id).removeClass(active?"btn-danger":"btn-default");
                $("#btn_no_"+id).addClass(active?"btn-default":"btn-danger");
                pass = true;
                redirect_url("");
            }
        }        
        $("#btn_yes_"+id).blur();
        $("#btn_no_"+id).blur();
        if(!pass)
            alert("Could not change status");
    }
    function ShowExamDetail(sname, sid, eid)
    {
        var postData = {};
        postData.sid = sid;
        postData.eid = eid;

        pass = false;
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'teacher/AJAXGetExamDetail', postData);
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

    $(function() {
        RefreshTable();
    });
</script>
